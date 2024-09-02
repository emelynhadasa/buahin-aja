<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DbTruncate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:truncate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Truncate all tables in the database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $tables = DB::select('SHOW TABLES');
        foreach($tables as $table)
        {
            $table_array = get_object_vars($table);
            Schema::disableForeignKeyConstraints();
            DB::table($table_array[key($table_array)])->truncate();
            Schema::enableForeignKeyConstraints();
        }

        $this->info('All tables truncated');
    }
}
