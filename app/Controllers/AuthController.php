<?php
namespace App\Controllers;

use App\Engine\Storage;
use App\Engine\Validator;
use App\Models\Task;
use App\Models\User;

class AuthController extends Controller {
    
    public function login (){
        $host  = $_SERVER['HTTP_REFERER'];
        $user = $this->request->getPostParams();
        $v = new Validator(
            [
                'email' => 'required|string|min:8',
                'password' => 'required|string|min:4'
            ]
        );

        $errors = $v->check()->errors();
        if (count($errors)) {
            return $this->response->json($errors);
        }
//        echo( $user['email']);
        $get_user = User::where([['email', '=', $user['email']]]);
        if(!$get_user){

            return $this->response->json('User not found');
        }
        return $this->response->json($get_user[0]['token']);
    }
    public function getUser (){
        $user = $this->request->getParam('id');
        $user = User::where([['id','=',$user]]);
        var_dump($user);
    }
    
}
