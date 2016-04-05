<?php
/**
 * Created by PhpStorm.
 * User: lbhurtado
 * Date: 05/04/16
 * Time: 19:45
 */

namespace App\Classes\Repositories\Interfaces;


interface PostRepositoryInterface
{
    public function getAll();

    public function find($id);
}