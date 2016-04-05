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

    public function __construct(EventDispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    abstract public function handle($command);
}