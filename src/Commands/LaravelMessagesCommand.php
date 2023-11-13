<?php

declare(strict_types=1);

namespace Centrex\LaravelMessages\Commands;

use Illuminate\Console\Command;

class LaravelMessagesCommand extends Command
{
    public $signature = 'laravel-messages';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
