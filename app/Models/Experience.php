<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Experience extends Model
{
    protected $fillable = [
        'role',
        'company',
        'location',
        'date_range',
        'description',
        'technologies',
        'icon',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    /** "Month YYYY - Month YYYY" or "Month YYYY - Present", optionally followed by "(…)". */
    private const RANGE = '/^\s*([A-Za-z]+\.?\s+\d{4})\s*[-–—]\s*([A-Za-z]+\.?\s+\d{4}|present|now|current)\b/i';

    public function techList(): array
    {
        return collect(explode(',', (string) $this->technologies))
            ->map(fn ($t) => trim($t))
            ->filter()
            ->values()
            ->all();
    }

    /** Degrees and courses share the timeline but aren't jobs. */
    public function isEducation(): bool
    {
        return str_contains((string) $this->icon, 'graduation-cap');
    }

    /** [start, end] parsed from date_range; end is now() for "Present". Null if unparseable. */
    public function period(): ?array
    {
        if (! preg_match(self::RANGE, (string) $this->date_range, $m)) {
            return null;
        }

        try {
            $start = Carbon::parse('1 ' . $m[1])->startOfMonth();
            $end = preg_match('/^(present|now|current)$/i', $m[2])
                ? now()->startOfMonth()
                : Carbon::parse('1 ' . $m[2])->startOfMonth();
        } catch (\Throwable) {
            return null;
        }

        return $end->lt($start) ? null : [$start, $end];
    }

    /**
     * The date range with an up-to-date duration, e.g.
     * "March 2024 - Present (1.7 yrs)" → "March 2024 - Present · 2 yrs 7 mos".
     * Text that isn't a "Month YYYY - …" range is shown unchanged.
     */
    public function displayDateRange(): string
    {
        $period = $this->period();
        if (! $period) {
            return (string) $this->date_range;
        }

        preg_match(self::RANGE, (string) $this->date_range, $m);

        // +1: a job from March to March counts as one month, like LinkedIn does.
        $months = (int) round($period[0]->diffInMonths($period[1])) + 1;

        return trim($m[0]) . ' · ' . self::formatMonths($months);
    }

    /**
     * Headline numbers for the About section, derived from the timeline so
     * they never go stale: years since the first job, and distinct employers.
     *
     * @param  Collection<int, self>  $experiences
     * @return array{years: float, companies: int}
     */
    public static function careerStats(Collection $experiences): array
    {
        $jobs = $experiences->reject->isEducation();

        $firstStart = $jobs->map->period()->filter()->map(fn ($p) => $p[0])->min();

        return [
            'years' => $firstStart ? round($firstStart->diffInMonths(now()) / 12, 1) : 0.0,
            'companies' => $jobs->pluck('company')->filter()->unique()->count(),
        ];
    }

    private static function formatMonths(int $months): string
    {
        [$y, $m] = [intdiv($months, 12), $months % 12];

        return trim(
            ($y ? $y . ' ' . ($y === 1 ? 'yr' : 'yrs') : '') . ' ' .
            ($m ? $m . ' ' . ($m === 1 ? 'mo' : 'mos') : '')
        ) ?: '1 mo';
    }
}
