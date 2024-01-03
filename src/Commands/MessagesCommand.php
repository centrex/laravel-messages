<?php

declare(strict_types = 1);

namespace Centrex\Messages\Commands;

use Illuminate\Console\Command;

class MessagesCommand extends Command
{
    public $signature = 'messages';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
