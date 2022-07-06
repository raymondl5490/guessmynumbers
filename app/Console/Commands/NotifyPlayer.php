<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\TestAmazonSes;
use App\Models\Game;

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
        Mail::to('cristianvice363@outlook.com')->send(new TestAmazonSes());
        
        return 0;
    }
}
