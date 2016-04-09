<?php
/**
 * Created by PhpStorm.
 * User: lbhurtado
 * Date: 07/04/16
 * Time: 22:27
 */

namespace App\Commands\Keywords;

trait Keyword
{
    protected $order;

    protected $pattern;

    protected $reply;

    protected $keyword;

    /**
     * @return mixed
     */
    public function getKeyword()
    {
        if ( is_null($this->keyword) )
        {
            $class = (new \ReflectionClass($this))->getShortName();

            if (preg_match("/^#?(?<verb>[A-Z][a-z0-9]+)?(?<keyword>[A-Z][a-z0-9]+)(?<suffix>[A-Z][a-z0-9]+)?$/", $class, $matches))
            {
                return $matches['keyword'];
            }

            return strtoupper($class);
        }

        return $this->keyword;
    }

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

        if ( is_null($this->pattern) )
        {
            return  "/^#?(?<tag>{$this->getKeyword()})\\s*(?<message>.*)$/i";
        }

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