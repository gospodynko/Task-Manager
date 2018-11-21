<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 29.10.18
 * Time: 23:33
 */

namespace App\Models;


use App\Engine\Model;

class User extends Model
{
    /**
     * @var string
     */
    public $table = 'users';

    /**
     * @var string
     */
    public $key = 'id';

    /**
     * @var array
     */
    public $attributes = [
        'id',
        'role',
        'email',
        'password',
        'token',
        'updated_at'
    ];
}