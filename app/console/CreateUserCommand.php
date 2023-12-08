<?php

namespace App\Console;

use Aloe\Command;
use Illuminate\Support\Facades\Auth;
use Lib\Uuid;

class CreateUserCommand extends Command
{
    protected static $defaultName = 'user:create';
    public $description = 'Create user for auth';
    public $help = '';

    public function config()
    {
        $this->setArgument('username', 'required');
        $this->setArgument('password', 'required');
    }

    protected function handle(): void
    {
        $auth = auth();
        $auth->dbConnection(db()->connection());

        $args = $this->arguments();

        $auth->register([
            'username' => $args['username'],
            'password' => $args['password'],
            'id' => Uuid::v4()
        ]);
    }
}
