<?php

namespace Tests\Unit;

use App\Models\Experience;
use Carbon\Carbon;
use Tests\TestCase;

class ExperienceTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Carbon::setTestNow('2026-10-15');
    }

    protected function tearDown(): void
    {
        Carbon::setTestNow();
        parent::tearDown();
    }

    private function exp(array $attributes): Experience
    {
        return new Experience($attributes);
    }

    public function test_present_range_gets_a_live_duration_replacing_stale_text(): void
    {
        $exp = $this->exp(['date_range' => 'March 2024 - Present (1.7 yrs)']);

        $this->assertSame('March 2024 - Present · 2 yrs 8 mos', $exp->displayDateRange());
    }

    public function test_closed_range_counts_both_end_months(): void
    {
        $this->assertSame(
            'June 2022 - February 2024 · 1 yr 9 mos',
            $this->exp(['date_range' => 'June 2022 - February 2024 (1.7 yrs)'])->displayDateRange()
        );
        $this->assertSame(
            'January 2020 - September 2020 · 9 mos',
            $this->exp(['date_range' => 'January 2020 - September 2020'])->displayDateRange()
        );
    }

    public function test_free_text_is_left_untouched(): void
    {
        $text = 'Graduated 2020 | 4 Years | 161 Credits';

        $this->assertSame($text, $this->exp(['date_range' => $text])->displayDateRange());
    }

    public function test_career_stats_skip_education_and_count_distinct_companies(): void
    {
        $stats = Experience::careerStats(collect([
            $this->exp(['company' => 'ACI', 'date_range' => 'March 2024 - Present', 'icon' => 'fas fa-briefcase']),
            $this->exp(['company' => 'MBM', 'date_range' => 'June 2022 - February 2024', 'icon' => 'fas fa-briefcase']),
            $this->exp(['company' => 'MBM', 'date_range' => 'January 2022 - May 2022', 'icon' => 'fas fa-briefcase']),
            $this->exp(['company' => 'ICT Wing', 'date_range' => 'January 2020 - September 2020', 'icon' => 'fas fa-code']),
            $this->exp(['company' => 'BAIUST', 'date_range' => 'January 2016 - December 2019', 'icon' => 'fas fa-graduation-cap']),
        ]));

        $this->assertSame(3, $stats['companies']);
        $this->assertSame(6.8, $stats['years']); // Jan 2020 → mid Oct 2026
    }
}
