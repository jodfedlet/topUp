<?php


namespace App\Console\Commands;

use App\System;
use \Illuminate\Console\Command;

class SyncToken extends Command
{

    /**
     * @var string
     */
    protected $signature = 'sync:tokens';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync Token from the Reloadly API';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
       // $this->handle();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $systems = System::where('api_key','!=',null)->where('api_secret','!=',null)->get();
        foreach ($systems as $system){
            $system['api_token'] = $system->getToken();
            $system->save();
        }
    }
}
