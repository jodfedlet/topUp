<?php

namespace App\Helpers;


use Illuminate\Support\Facades\Artisan;
Artisan::call('schedule:run');
exit;