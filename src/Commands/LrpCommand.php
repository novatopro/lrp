<?php

namespace NovatoPro\Lrp\Commands;

use Illuminate\Console\Command;

class LrpCommand extends Command
{
    public $signature = 'lrp';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
