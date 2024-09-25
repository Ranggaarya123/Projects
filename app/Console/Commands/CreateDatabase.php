<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

class CreateDatabase extends Command
{
    protected $signature = 'database:create';
    protected $description = 'Create the database';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $schemaName = Config::get('database.connections.mysql.database');
        $charset = Config::get('database.connections.mysql.charset', 'utf8mb4');
        $collation = Config::get('database.connections.mysql.collation', 'utf8mb4_unicode_ci');

        Config::set('database.connections.mysql.database', null);

        $query = "CREATE DATABASE IF NOT EXISTS `$schemaName` CHARACTER SET $charset COLLATE $collation;";

        DB::statement($query);

        Config::set('database.connections.mysql.database', $schemaName);

        $this->info("Database `$schemaName` created successfully!");
    }
}
