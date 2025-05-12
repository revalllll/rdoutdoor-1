<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $email = 'admin@gmail.com';

        // Cek apakah user dengan email tersebut sudah ada
        $userExists = DB::table('users')->where('email', $email)->exists();

        // Jika belum ada, insert user baru
        if (!$userExists) {
            DB::table('users')->insert([
                'name' => 'Admin',
                'email' => $email,
                'password' => Hash::make('adminpassword'),
                'role_id' => 1, // Pastikan 1 adalah ID dari "admin" di tabel user_roles
                // Field tambahan jika perlu
                'CompanyCode' => 'RD001',
                'Status' => 1,
                'IsDeleted' => 0,
                'CreatedBy' => 'system',
                'CreatedDate' => now(),
                'LastUpdateBy' => 'system',
                'LastUpdateDate' => now(),
            ]);
        }
    }
}
