<?php
/**
 * Created by PhpStorm.
 * User: lbhurtado
 * Date: 07/04/16
 * Time: 22:27
 */

namespace App\Commands\Keywords;

abstract Class Keyword
{
    protected $order;

    protected $pattern;

    protected $reply;

    /**
     * @return mixed
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @return mixed
     */
    public function getPattern()
    {
        return $this->pattern;
    }

    /**
     * @return mixed
     */
    public function getReply()
    {
        return $this->reply;
    }

}