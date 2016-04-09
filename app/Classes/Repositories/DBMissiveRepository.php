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
use App\Events\MissiveWasRecorded;

class DbMissiveRepository implements MissiveRepositoryInterface
{
    public function record($mobile, $body)
    {
        $missive = Missive::create(compact('mobile', 'body'));

        return $missive;
    }

    public function getAll()
    {
        return Missive::all();
    }

    public function find($id)
    {
        return Missive::find($id);
    }
}