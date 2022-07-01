<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // seed the default result texts
        DB::table('settings')->insertOrIgnore([
            [
                'key' => 'result_text_win_try_1',
                'value' => json_encode(['WOW!', 'First Guess Win!', 'First try! YES!']),
            ],
            [
                'key' => 'result_text_win_try_2',
                'value' => json_encode(['Yeah budddddy!', 'Winner!!', 'Hizzah!!:)']),
            ],
            [
                'key' => 'result_text_win_try_3',
                'value' => json_encode(['Hurray!', 'You got it!!', 'Third guess is the winner!']),
            ],
            [
                'key' => 'result_text_lose_correct_0',
                'value' => json_encode(['Better luck next time!', 'Close!', 'Good try! :)']),
            ],
            [
                'key' => 'result_text_lose_correct_1',
                'value' => json_encode(['Almost!', 'Good try!!', 'Better luck next round!']),
            ],
            [
                'key' => 'result_text_lose_correct_2',
                'value' => json_encode(['Try again next round!', 'Ohh. So close!', 'Oh nuts! Close one!']),
            ],
        ]);
    }
}
