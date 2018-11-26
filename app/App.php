<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 29.10.18
 * Time: 15:07
 */

namespace App;


use App\Engine\Router;
use App\Engine\Storage;

class App
{
    /**
     * @var Router
     */
    private $router;

    public function __construct()
    {
        $this->router = Storage::get('Router');
    }

    public function run()
    {
        $current_request = $this->router->getCurrent();
        $controller = new $current_request->controller;
        $response = $controller->{$current_request->method}();
        $response->render();
    }
}