<?php

namespace AtakanAtici\EDM\Commands;

use Illuminate\Console\Command;

class EDMCommand extends Command
{
    public $signature = 'laravel-edm';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
