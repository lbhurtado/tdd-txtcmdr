<?php
/**
 * Created by PhpStorm.
 * User: lbhurtado
 * Date: 03/04/16
 * Time: 17:56
 */

namespace App\Classes\Messaging\SMS\Facades;

use Illuminate\Support\Facades\Facade;

class SMS extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'sender';
    }
}