<?php
/**
 * Created by PhpStorm.
 * User: lbhurtado
 * Date: 07/04/16
 * Time: 22:26
 */

namespace App\Commands\Keywords;

class Start extends Keyword
{
    protected $order = 1;

    protected $pattern = "/^#?(?<tag>start)\\s*(?<message>.*)$/i";

    protected $reply = "You sent START";
}