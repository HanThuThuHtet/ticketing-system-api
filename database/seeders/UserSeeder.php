<?php

namespace Database\Seeders;

use App\Models\Queue;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    // public function run()
    // {
    //     $user = DB::table('users')->insert([
    //         'name' => "Admin1",
    //         'email' => "admin1@gmail.com",
    //         'password' => Hash::make('11111111'),
    //         'email_verified_at' => now(),
    //         'remember_token' => Str::random(10),
    //         'role' => 'admin',
    //     ]);

    //     $queues = Queue::all();
    //     $user->queues()->attach($queues);
    // }

    public function run()
    {
        $user = User::create([
            'name' => "Admin",
            'email' => "admin@gmail.com",
            'password' => Hash::make('11111111'),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
            'role' => 'admin',
        ]);

        $queues = Queue::all();
        $user->queues()->attach($queues);
    }
}
