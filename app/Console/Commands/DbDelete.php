<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class DbDelete extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete DB';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        DB::statement('DROP DATABASE ' . env('DB_DATABASE'));
        $this->info('DB Deleted');
    }
}
