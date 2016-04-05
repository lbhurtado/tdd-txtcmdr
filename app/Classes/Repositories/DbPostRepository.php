<?php
/**
 * Created by PhpStorm.
 * User: lbhurtado
 * Date: 05/04/16
 * Time: 19:47
 */

namespace App\Classes\Repositories;

use App\Classes\Repositories\Interfaces\PostRepositoryInterface;
use App\Classes\Post;

class DbPostRepository implements PostRepositoryInterface
{
    public function getAll()
    {
        return Post::all();
    }

    public function find($id)
    {
        return Post::find($id);
    }
}