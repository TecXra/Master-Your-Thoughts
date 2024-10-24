<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class VideoNextCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'video:next';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Daily Video Question on a 24-hour loop at midnight.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        \Log::info("Cron is working fine!");
    }
}
