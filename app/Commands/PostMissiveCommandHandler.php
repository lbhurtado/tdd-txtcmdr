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
use App\Commands\RegisterUserCommand;

class PostMissiveCommandHandler extends CommandHandler
{
    public function handle($command)
    {
        $missive = Missive::post($command->mobile, $command->body);

        $this->dispatcher->dispatch($missive->releaseEvents());

        $this->commandBus->execute(new RegisterUserCommand($command->mobile, $command->body));

        $this->commandBus->execute(new PostKeywordCommand($command->mobile, $command->body));
    }

}