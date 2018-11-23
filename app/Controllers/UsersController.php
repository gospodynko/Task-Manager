<?php
namespace App\Controllers;

use App\Engine\Storage;
use App\Engine\Validator;
use App\Models\Task;
use App\Models\User;
use Symfony\Component\Config\Definition\Exception\Exception;

class UsersController extends Controller
{
    public function getUser (){
        $user = $this->request->getParam('id');
        $user = User::where([['id','=',$user]]);
        return $this->response->json($user,'200') ;
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
            return $this->response->json($errors,'403');
        }
        $password = password_hash($user['password'], PASSWORD_DEFAULT);
        $us = User::where([['email','=',$user['email']]]);
        if($us){
            try {
                $update = User::update('password',$password,'email',$user['email']);

            }
            catch (Exception $e){
                return $e->getMessage();
            }
            return $this->response->json('success:200');
        }
            return true;

    }


}