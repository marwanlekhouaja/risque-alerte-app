<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TestPlanification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:test-planification';

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
        \Log::info("✅ Tâche planifiée exécutée à " . now());
        return 0;
    }
}
