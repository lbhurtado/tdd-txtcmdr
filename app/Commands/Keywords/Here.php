<?php
/**
 * Created by PhpStorm.
 * User: lbhurtado
 * Date: 07/04/16
 * Time: 22:52
 */

namespace App\Commands\Keywords;

class Here extends Keyword
{
    protected $order = 2;

    protected $pattern = "/^#?(?<tag>here)\\s*(?<message>.*)$/i";

    protected $reply = "You sent HERE";
}