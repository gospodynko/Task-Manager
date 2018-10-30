<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 29.10.18
 * Time: 14:16
 */

namespace App\Controllers;


use App\Engine\Storage;

class Controller
{
    protected $response;
    protected $request;

    public function __construct()
    {
        session_start();
        $this->response = Storage::get('Response');
        $this->request = Storage::get('Request');
    }

}