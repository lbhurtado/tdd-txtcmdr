<?php
/**
 * Created by PhpStorm.
 * User: lbhurtado
 * Date: 9/25/15
 * Time: 21:30
 */

namespace App\Classes\Commanding;

use App\Classes\Eventing\EventDispatcher;

abstract class CommandHandler
{
    protected $dispatcher;

    protected $commandBus;

    public function __construct(EventDispatcher $dispatcher, DefaultCommandBus $commandBus)
    {
        $this->dispatcher = $dispatcher;

        $this->commandBus = $commandBus;
    }

    abstract public function handle($command);
}