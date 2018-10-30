<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 29.10.18
 * Time: 14:30
 */

namespace App\Controllers;


use App\Engine\Request;
use App\Models\Post;

class HomeController extends Controller
{
    public function index()
    {
        $_SESSION['comment_errors'] = null;
        $_SESSION['inputs'] = null;
        $num_page = $this->request->getIntParam('page') ?? 1;
        $limit = 5;
        $posts = Post::paginate($num_page, $limit);

        $populars = Post::getPopular('comments', 'comments_count', 'post_id', 6);

        $pages = ceil((int) Post::count() / 5);
        return $this->response->html('posts', [
            'posts' => $posts,
            'pages' => $pages,
            'current_page' => $num_page,
            'populars' => $populars
        ]);
    }
}