<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportDatabase extends Command
{
    protected $signature = 'db:import';
    protected $description = 'Import SQL file into Railway MySQL';

    public function handle()
    {
        $path = database_path('import/study_manager.sql');

        if (!file_exists($path)) {
            $this->error("File not found: $path");
            return;
        }

        $sql = file_get_contents($path);

        DB::unprepared($sql);

        $this->info("Import thành công!");
    }
}
