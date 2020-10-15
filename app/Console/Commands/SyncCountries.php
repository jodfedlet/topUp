<?php


namespace App\Console\Commands;
use App\Country;
use App\System;
use Illuminate\Console\Command;


class SyncCountries extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:countries';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync Countries with the Reloadly API';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->handle();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $countries = System::getData()->getCountries();
        foreach ($countries as $country) {
            Country::updateOrCreate(
                ['iso' => $country->isoName],
                [
                    'name' => $country->name,
                    'currency_code' => $country->currencyCode,
                    'currency_name' => $country->currencyName,
                    'currency_symbol' => $country->currencySymbol,
                    'flag' => $country->flag,
                    'calling_codes' => $country->callingCodes
                ]
            );
        }
    }
}
