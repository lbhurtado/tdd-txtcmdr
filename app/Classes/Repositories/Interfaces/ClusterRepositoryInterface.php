<?php
/**
 * Created by PhpStorm.
 * User: lbhurtado
 * Date: 05/04/16
 * Time: 13:42
 */

namespace App\Classes\Repositories\Interfaces;


interface ClusterRepositoryInterface
{
    public function getAll();

    public function find($id);
}