<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DumpMysql extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dump:mysql';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return mixed
     */
    public function handle()
    {
        \Spatie\DbDumper\Databases\MySql::create()
        ->setDbName(env('DB_DATABASE'))->setUserName(env('DB_USERNAME'))
        ->setPassword(env('DB_PASSWORD'))
        ->dumpToFile('storage/dump_db/dump_'.date('Y-m-d').'.sql');
        \Log::info("Mysql Database dumped...".date('Y-m-d'));
    }
}
