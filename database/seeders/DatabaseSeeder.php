<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        /**
         * Super user Josh Gottsegen, josh@onelightstudios.com, password: password
         */
        $users = DB::table('users')->count();
        if (!$users) {
            DB::table('users')->insert([
                'name' => 'Josh',
                'email' => 'josh@onelightstudios.com',
                'password' => Hash::make('password'),
            ]);
        }

        $games = DB::table('games')->count();
        if (!$games) {
            DB::table('games')->insert([
                'number_one' => 3,
                'number_two'=> 2,
                'number_three' => 2,
                'live_on' => Carbon::now('America/Los_Angeles')->format('Y-m-d a'),
                'author_name' => 'Smart',
                'author_location' => 'CA',
                'author_email' => 'smartdev0322@gmail.com',
                'link' => 'https://github.com',
                'link_title' => 'visit me',
            ]);
        }

    }
}
