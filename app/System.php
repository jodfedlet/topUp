<?php

namespace App;

use App\Traits\SystemTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class System extends Model
{
    use SystemTrait;

    protected $guarded = ['id'];

    public static function getData()
    {
        return System::first();
    }
}
