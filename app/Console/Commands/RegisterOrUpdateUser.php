<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class RegisterOrUpdateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:register {email} {password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Register new user or update password if exist';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $email = $this->argument('email');
        $password = $this->argument('password');

        User::updateOrInsert(
                ['email' => $email],
                ['password' => Hash::make($password)]
            );

        $this->info('The command was successful!');
        $this->info('Current registered users are:');
        $this->table(
            ['Name', 'Email'],
            User::all(['name', 'email'])->toArray()
        );

        return 0;
    }
}
