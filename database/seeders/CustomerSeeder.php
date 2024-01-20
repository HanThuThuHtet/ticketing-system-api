<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 10; $i++) {
            DB::table('customers')->insert([
                'name' => 'Customer ' . $i,
                'cpe_id' => 'CPE00' . $i,
                'phone' => '123456789' . $i,
                'township' => 'Sample Township ' . $i,
                'plan' => 'Plan ' . $i,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
