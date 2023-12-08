<?php

namespace App\Console;

use Aloe\Command;

class MigrateCommand extends Command
{
    protected static $defaultName = 'migrate';
    public $description = 'Migrate schema to db';
    public $help = '';

    protected function handle(): void
    {
        $sqlFiles = glob(__DIR__ . '/../../migrations/*.sql');

        foreach ($sqlFiles as $sqlFile) {
            $command = file_get_contents($sqlFile);

            db()->query($command)->execute();
        }

        $this->comment('Migration success');
    }
}
