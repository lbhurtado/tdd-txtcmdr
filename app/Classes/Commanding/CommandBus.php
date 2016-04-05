<?php
/**
 * Created by PhpStorm.
 * User: lbhurtado
 * Date: 9/24/15
 * Time: 17:08
 */
namespace App\Classes\Commanding;

interface CommandBus
{
    public function execute($command);
}