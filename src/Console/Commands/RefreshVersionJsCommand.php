<?php

namespace Cloudteam\BaseCore\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class RefreshVersionJsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cache:clean-js-version';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Cache::delete('asset_version');
    }
}
