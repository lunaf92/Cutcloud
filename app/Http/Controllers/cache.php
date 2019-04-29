<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Artisan;

class cache extends Controller
{
    public function clear(){
        Artisan::call('cache:clear');
        Artisan::call('config:cache');
        Artisan::call('view:clear');
        return "Cache is cleared";
    }
}
