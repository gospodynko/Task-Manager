<?php
namespace App\Controllers;

use App\Engine\Storage;
use App\Engine\Validator;
use App\Models\Task;
use App\Models\User;

class UsersController extends Controller
{
    public function getUser (){
        $user = $this->request->getParam('id');
        $user = User::where([['id','=',$user]]);
        var_dump($user);
    }

    public function updateUser (){
        $user = $this->request->getPostParams();
        $v = new Validator(
            [
                'email' => 'string|min:8',
                'password' => 'string|min:4'
            ]
        );

        $errors = $v->check()->errors();
        if (count($errors)) {
            return $this->response->json($errors);
        }
        $update = User::update('email','email','id',1);
        var_dump($update);
    }


}