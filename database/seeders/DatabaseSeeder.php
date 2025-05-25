<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call(UserRolesSeederBaru::class);

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'role_id' => 3, // id user biasa
            'company_code' => 'default',
            'status' => 1,
            'is_deleted' => 0,
            'created_by' => 'system',
            'created_date' => now(),
            'last_update_by' => null,
            'last_update_date' => null,
        ]);

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@rdoutdoor.com',
            'password' => bcrypt('admin123'),
            'role_id' => 1, // pastikan id 1 adalah admin di tabel roles
            'company_code' => 'default',
            'status' => 1,
            'is_deleted' => 0,
            'created_by' => 'system',
            'created_date' => now(),
            'last_update_by' => null,
            'last_update_date' => null,
        ]);
    }
}