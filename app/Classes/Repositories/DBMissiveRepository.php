<?php
/**
 * Created by PhpStorm.
 * User: lbhurtado
 * Date: 05/04/16
 * Time: 07:31
 */

namespace App\Classes\Repositories;

use App\Classes\Missive;
use App\Classes\Repositories\Interfaces\MissiveRepositoryInterface;

class DbMissiveRepository implements MissiveRepositoryInterface
{
    public function getAll()
    {
        return Missive::all();
    }

    public function find($id)
    {
        return Missive::find($id);
    }
}