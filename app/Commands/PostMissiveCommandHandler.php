<?php
/**
 * Created by PhpStorm.
 * User: lbhurtado
 * Date: 04/04/16
 * Time: 19:49
 */

namespace App\Commands;

use App\Classes\Commanding\CommandHandler;
use App\Classes\Missive;

class PostMissiveCommandHandler extends CommandHandler
{
    public function handle($command)
    {
        $missive = Missive::post($command->mobile, $command->body);

        $this->dispatcher->dispatch($missive->releaseEvents());
    }

}