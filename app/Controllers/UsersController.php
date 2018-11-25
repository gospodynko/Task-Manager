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


        $headers = apache_request_headers();
        $token = $headers['token'];
        $u = User::where([['token','=',$token]]);
        if($u[0]['role'] =='admin') {
            $user = $this->request->getParam('id');
            $user = User::where([['id', '=', $user]]);
            return $this->response->json($user, '200');
        }
        else{
            return $this->response->json('access denided');
        }
    }

    public function updateUser (){
        $user = $this->request->getPostParams();
        $v = new Validator(
            [
                'email' => 'required|string|min:8',
                'password' => 'required|string|min:4'
            ]
        );
        $errors = $v->check()->errors();
        if (count($errors)) {
            return $this->response->json($errors,'403');
        }
        $headers = apache_request_headers();
        $token = $headers['token'];
        $u = User::where([['token','=',$token]]);
        if($u['role'] == 'admin'){

        }

        if($u[0]['email'] == $user['email'] || $u[0]['role'] =='admin') {


        $password = password_hash($user['password'], PASSWORD_DEFAULT);
        $us = User::where([['email','=',$user['email']]]);
        if($us){
            try {
                $update = User::update('password',$password,'email',$user['email']);

            }
            catch (Exception $e){
                return $e->getMessage();
            }
            return $this->response->json(http_response_code());
        }
            return true;
        }
        else{
            return $this->response->json('access denided');
        }
    }
    public function addUser (){
        $user = $this->request->getPostParams();
        $v = new Validator(
            [
                'email' => 'required|email|min:8',
                'password' => 'required|string|min:4'
            ]
        );

        $errors = $v->check()->errors();
        if (count($errors)) {
            return $this->response->json($errors,'403');
        }
        $headers = apache_request_headers();
        $token = $headers['token'];
        $u = User::where([['token','=',$token]]);
        if($u[0]['role'] =='admin'){
            $length = 24;
            $user['password'] = password_hash($user['password'], PASSWORD_DEFAULT);
            $user['role'] = 'user';
            $user['token'] = $token = bin2hex(random_bytes($length));
            $user['updated_at'] = date('Y-m-d H:i:s');
            $user = User::add($user);
            if($user){
                return $this->response->json(http_response_code());
            }
            return $this->response->json(http_response_code());
        }

        else{
            return $this->response->json('access denided');
        }
    }


}