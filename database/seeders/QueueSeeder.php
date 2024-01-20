<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QueueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 10; $i++) {
            DB::table('queues')->insert([
                'name' => 'Queue ' . $i,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
