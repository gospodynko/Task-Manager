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
use Symfony\Component\Config\Definition\Exception\Exception;

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
        var_dump($task['tasks']);
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
        $user = $this->request->getParam('id');
        $tasks = Task::where([['user_id','=',$user]]);
        if ($tasks){
            return $this->response->json($tasks);
        }
        else {
            return $this->response->json(404);
        }

    }
    public function getTask ()
    {
        $user = $this->request->getParam('user_id');
        $task = $this->request->getParam('id');
        $task = Task::where([['user_id','=',$user],['id','=',$task]]);
        if ($task){
            return $this->response->json($task);
        }
        else {
            return $this->response->json(404);
        }
    }

}