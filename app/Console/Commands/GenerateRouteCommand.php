<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GenerateRouteCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'route:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate route to client types';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->call('ziggy:generate', [
            '--types-only' => true,
            'path' => 'resources/js/Types/ziggy.d.ts'
        ]);
    }
}
