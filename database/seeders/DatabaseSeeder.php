<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\UsersSeeder; // Pastikan sudah diimport

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Memanggil UsersSeeder untuk menambahkan data pengguna
        $this->call([
            UsersSeeder::class, // Memastikan UsersSeeder dipanggil
        ]);
    }
}
