<?php
/**
 * Created by PhpStorm.
 * User: oi
 * Date: 23.11.18
 * Time: 9:30
 */

namespace App\Controllers;
use App\Engine\Storage;
use App\Engine\Validator;
use App\Models\Task;
use App\Models\User;


class TaskController extends Controller
{
    public function addTask()
    {

        $task = $this->request->getPostParams();

        $v = new Validator(
            [
                'tasks' => 'string|min:8',
                'status' => 'string'
            ]);
         $errors = $v->check()->errors();
        if (count($errors)) {
            return $this->response->json($errors,'403');
        }
        $headers = apache_request_headers();
        $token = $headers['token'];
        $user = User::where([['token','=',$token]]);
        $task['user_id'] = $user[0]['id'];
        $task['updated_at'] = date('Y-m-d H:i:s');
        $task = Task::add($task);
        if($task){
            return $this->response->json(200);
        }
        else
        {
            return $this->response->json(404);
        }

    }
    public function getTasks ()
    {
        $headers = apache_request_headers();
        $token = $headers['token'];
        $user = User::where([['token','=',$token]]);
        $tasks = Task::where([['user_id','=',$user[0]['id']]]);
        if ($tasks){
            return $this->response->json($tasks);
        }
        else {
            return $this->response->json(404);
        }

    }
    public function getTask ()
    {
        $headers = apache_request_headers();
        $token = $headers['token'];
        $user = User::where([['token','=',$token]]);
        $task = $this->request->getParam('id');
        $task = Task::where([['user_id','=',$user[0]['id']],['id','=',$task]]);
        if ($task){
            return $this->response->json($task);
        }
        else {
            return $this->response->json(404);
        }
    }
    public function editTask ()
    {
        $headers = apache_request_headers();
        $token = $headers['token'];
        $user = User::where([['token','=',$token]]);
        $task = $this->request->getPostParams();
        $task_cur = Task::where([['user_id','=',$user[0]['id']],['id','=',$task['id']]]);
        if ($task){
            $update = Task::update('status',$task['status'],'id',$task['id']);
            return $this->response->json($update);
        }
        else {
            return $this->response->json(404);
        }

    }

}