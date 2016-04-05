<?php
/**
 * Created by PhpStorm.
 * User: lbhurtado
 * Date: 05/04/16
 * Time: 07:39
 */

namespace App\Classes\Repositories\Interfaces;


interface MissiveRepositoryInterface
{
    public function getAll();

    public function find($id);
}