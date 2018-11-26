<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 29.10.18
 * Time: 23:33
 */

namespace App\Models;


use App\Engine\Model;

class Task extends Model
{
    /**
     * @var string
     */
    public $table = 'tasks';

    /**
     * @var string
     */
    public $key = 'id';

    /**
     * @var array
     */
    public $attributes = [
        'id',
        'tasks',
        'status',
        'user_id',
        'updated_at'
    ];
}