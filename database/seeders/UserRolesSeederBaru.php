<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class UserRolesSeederBaru extends Seeder
{
    public function run(): void
    {
        DB::table('roles')->insert([
            [
                'name' => 'admin',
                'company_code' => 'default',
                'status' => 1,
                'is_deleted' => 0,
                'created_by' => 'system',
                'created_date' => Carbon::now(),
                'last_update_by' => null,
                'last_update_date' => null,
            ],
            [
                'name' => 'owner',
                'company_code' => 'default',
                'status' => 1,
                'is_deleted' => 0,
                'created_by' => 'system',
                'created_date' => Carbon::now(),
                'last_update_by' => null,
                'last_update_date' => null,
            ],
            [
                'name' => 'user',
                'company_code' => 'default',
                'status' => 1,
                'is_deleted' => 0,
                'created_by' => 'system',
                'created_date' => Carbon::now(),
                'last_update_by' => null,
                'last_update_date' => null,
            ],
        ]);
    }
}
