<?php

namespace App\Console\Commands;

use App\Exceptions\UserManagementException;
use App\Services\AbstractServices\UsersService;
use Illuminate\Console\Command;

class CreateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-user {username} {password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new user to update the products table';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        $usersService = app(UsersService::class);
        try {
            $user = $usersService->createUser($this->argument('username'), $this->argument('password'));
            $this->info('User created successfully, username: ' . $user->username);
        } catch (UserManagementException $e) {
            $this->error($e->getMessage());
        }
    }
}
