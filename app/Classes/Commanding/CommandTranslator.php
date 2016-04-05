<?php
/**
 * Created by PhpStorm.
 * User: lbhurtado
 * Date: 9/23/15
 * Time: 12:12
 */

namespace App\Classes\Commanding;

use Exception;

class CommandTranslator
{
    private $command;

    private $reflection_class;

    private function setCommand($command)
    {
        $this->command = $command;

        $this->reflection_class = new \ReflectionClass($command);

        return $this;
    }

    private function getNameSpace()
    {
        return $this->reflection_class->getNamespaceName();
    }

    private function getShortName()
    {
        return $this->reflection_class->getShortName();
    }

    public function toCommandHandler($command)
    {
        $this->setCommand($command);

        $handler = $this->getNameSpace() . "\\" . str_replace('Command', 'CommandHandler', $this->getShortName());

        if (!class_exists($handler)) {
            $message = "Command handler [$handler] does not exist.";

            throw new Exception($message);
        }

        return $handler;
    }

    public function toValidator($command)
    {
        $this->setCommand($command);

        $validator = $this->getNameSpace() . "\\" . str_replace('Command', 'Validator', $this->getShortName());

        //return str_replace('Command', 'Validator', get_class($command));
        return $validator;
    }
}