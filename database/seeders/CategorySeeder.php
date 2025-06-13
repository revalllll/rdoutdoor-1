<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        DB::table('categories')->insert([
            [
                'name' => 'Tenda',
                'company_code' => 'default',
                'status' => 1,
                'is_deleted' => 0,
                'created_by' => 'system',
                'created_date' => Carbon::now(),
                'last_update_by' => null,
                'last_update_date' => null,
            ],
            [
                'name' => 'Carrier',
                'company_code' => 'default',
                'status' => 1,
                'is_deleted' => 0,
                'created_by' => 'system',
                'created_date' => Carbon::now(),
                'last_update_by' => null,
                'last_update_date' => null,
            ],
            [
                'name' => 'Matras',
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
