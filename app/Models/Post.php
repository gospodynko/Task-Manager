<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 29.10.18
 * Time: 23:33
 */

namespace App\Models;


use App\Engine\Model;

class Post extends Model
{
    /**
     * @var string
     */
    public $table = 'posts';

    /**
     * @var string
     */
    public $key = 'id';

    /**
     * @var array
     */
    public $attributes = [
        'id',
        'author',
        'text',
        'updated_at'
    ];

}