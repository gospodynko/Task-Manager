<?php
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
require_once 'app/helpers.php';
require './vendor/autoload.php';

use App\Engine\DI;
use App\Engine\Storage;

try {
    DI::start();
    $router = Storage::get('Router');
    $router->post('/', 'AuthController@login');
//    $router->get('/post/', 'PostController@get');
//    $router->get('/search/', 'PostController@search');
    $router->post('/post/add', 'PostController@add');
    $router->post('/login', 'AuthController@login');
    $router->get('/getUser', 'UsersController@getUser');
    $router->post('/updateUser', 'UsersController@updateUser');
    $router->post('/addTask','TaskController@addTask');
    $router->post('/addUser','UsersController@addUser');
    $router->post('/editTask','TaskController@editTask');

    $router->get('/getTasks','TaskController@getTasks');

    $router->get('/getTask','TaskController@getTask');
    $router->get('/fibonacci', 'ExerciseController@fibonacci');
    $router->get('/get_price', 'ExerciseController@get_price');
//    $router->post('/comment/add', 'PostController@addComment');
//    $router->get('/404', 'SystemController@notFound');
    $app = Storage::get('App');
    $app->run();
} catch (\Exception $e) {
    echo json_encode([
        'error' => $e->getMessage()
    ]);
}