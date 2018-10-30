<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 30.10.18
 * Time: 0:27
 */

namespace App\Controllers;


use App\Engine\Validator;
use App\Models\Comment;
use App\Models\Post;

class PostController extends Controller
{
    public function get()
    {
        $_SESSION['post_errors'] = null;
        $_SESSION['inputs_post'] = null;
        $id = $this->request->getIntParam('id');
        $post = Post::find($id);
        $comments = Comment::where([['post_id', '=', $id]]);

        return $this->response->html('post', [
            'post' => $post,
            'comments' => $comments
        ]);
    }

    public function search()
    {
        $search_str = $this->request->getParam('q');

        $posts = Post::where([['text', 'like', '%' . $search_str . '%']]);

        return $this->response->html('search', [
            'posts' => $posts,
            'search_str' => $search_str
        ]);
    }

    public function add()
    {
        $host  = $_SERVER['HTTP_REFERER'];
        $data = $this->request->getPostParams();
        $v = new Validator(
            [
                'text' => 'required|string|min:10',
                'author' => 'required|string|min:2'
            ]
        );

        $errors = $v->check()->errors();
        $_SESSION['post_errors'] = null;
        $_SESSION['inputs_post'] = null;
        if (count($errors)) {
            $_SESSION['post_errors'] = $errors;
            $_SESSION['inputs_post']['author'] = $data['author'];
            $_SESSION['inputs_post']['text'] = $data['text'];
            header('Location:' . $host);
            exit(200);
        }

        $data['updated_at'] = date('U');

        $post_id = Post::add($data);
        if ($post_id) {
            $_SESSION['post_create'] = 1;
        } else {
            $_SESSION['post_create'] = 0;
        }

        header('Location:' . $host);
        exit(200);
    }

    public function addComment()
    {
        $host  = $_SERVER['HTTP_REFERER'];
        $data = $this->request->getPostParams();
        $v = new Validator(
            [
                'text' => 'required|string|min:10|max:250',
                'author' => 'required|string|min:2',
                'post_id' => 'required|integer'
            ]
        );

        $errors = $v->check()->errors();
        $_SESSION['comment_errors'] = null;
        $_SESSION['inputs'] = null;
        if (count($errors)) {
            $_SESSION['comment_errors'] = $errors;
            $_SESSION['inputs']['author'] = $data['author'];
            $_SESSION['inputs']['text'] = $data['text'];
            header('Location:' . $host);
            exit(200);
        }
        $data['updated_at'] = date('U');

        $comment_id = Comment::add($data);


        header('Location:' . $host);
        exit(200);
    }
}