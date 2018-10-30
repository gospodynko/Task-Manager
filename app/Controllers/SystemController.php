<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 30.10.18
 * Time: 14:01
 */

namespace App\Controllers;


class SystemController extends Controller
{
    public function notFound()
    {
        return $this->response->html('404');
    }
}