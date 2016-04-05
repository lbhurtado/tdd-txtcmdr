<?php
/**
 * Created by PhpStorm.
 * User: lbhurtado
 * Date: 9/27/15
 * Time: 19:57
 */

namespace App\Listeners;

use App\Events\MissiveWasPosted;

class VarDump extends Listener
{
    public function whenMissiveWasPosted(MissiveWasPosted $event)
    {
        var_dump($event);
    }
}