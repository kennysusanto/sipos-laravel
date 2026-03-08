<?php

namespace Database\Seeders;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $tenant = Tenant::query()->updateOrCreate(
            ['name' => 'master'],
            ['display_name' => 'Master Tenant']
        );

        User::query()->updateOrCreate([
            'email' => 'admin@example.com',
        ], [
            'tenant_id' => $tenant->id,
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'role' => 'admin',
            'password' => Hash::make('password'),
        ]);

        User::query()->updateOrCreate([
            'email' => 'kenny@example.com',
        ], [
            'tenant_id' => $tenant->id,
            'name' => 'Kenny',
            'email' => 'kenny@example.com',
            'role' => 'user',
            'password' => Hash::make('password'),
        ]);
    }
}
