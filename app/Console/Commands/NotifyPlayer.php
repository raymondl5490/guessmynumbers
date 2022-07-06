<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\YourGameIsScheduled;
use App\Models\Game;
use Illuminate\Support\Carbon;

class NotifyPlayer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify:player';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send an email to player 24hrs before his game lives';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // This command is scheduled at 11:00, 23:00 everyday. in order to send email before 24hrs the game lives ...
        $game = Game::where('live_on', '=', Carbon::now('America/Los_Angeles')->addDay()->addHours(12)->format('Y-m-d a'))->first();
        Mail::to($game->author_email)->send(new YourGameIsScheduled($game));
        
        return 0;
    }
}
