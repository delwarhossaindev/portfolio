<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     *
     * The first admin comes from ADMIN_EMAIL / ADMIN_PASSWORD in .env. Without
     * a password a random one is generated and printed once. An existing admin
     * keeps their current password, so re-seeding never resets it.
     */
    public function run(): void
    {
        $this->call([RolesAndPermissionsSeeder::class, PortfolioSeeder::class]);

        $email = env('ADMIN_EMAIL', 'admin@example.com');
        $password = env('ADMIN_PASSWORD') ?: Str::password(16);

        $admin = User::query()->firstOrCreate(['email' => $email], [
            'name' => env('ADMIN_NAME', 'Admin'),
            'password' => Hash::make($password),
        ]);

        $admin->syncRoles(['admin']);

        if ($admin->wasRecentlyCreated && ! env('ADMIN_PASSWORD')) {
            $this->command?->warn("Admin created: {$email} / {$password}  (save this password now)");
        }
    }
}
