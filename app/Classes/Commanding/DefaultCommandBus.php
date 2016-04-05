<?php
/**
 * Created by PhpStorm.
 * User: lbhurtado
 * Date: 9/23/15
 * Time: 12:09
 */

namespace App\Classes\Commanding;

use App\Classes\Commanding\CommandTranslator;
use Illuminate\Contracts\Foundation\Application;

class DefaultCommandBus implements CommandBus
{

    protected $app;

    protected $commandTranslator;

    /**
     * CommandBus constructor.
     * @param $commandTranslator
     */
    public function __construct(Application $app, CommandTranslator $commandTranslator)
    {
        $this->app = $app;

        $this->commandTranslator = $commandTranslator;
    }


    public function execute($command)
    {
        $handler = $this->commandTranslator->toCommandHandler($command);

        return $this->app->make($handler)->handle($command);
    }
}