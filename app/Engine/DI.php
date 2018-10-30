<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 29.10.18
 * Time: 14:57
 */

namespace App\Engine;


use App\App;

class DI
{
    static public function start()
    {
        Storage::set('Request', new Request());
        Storage::set('Router', new Router());
        Storage::set('App', new App());
        Storage::set('Response', new Response());
    }
}