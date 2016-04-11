<?php
/**
 * Created by PhpStorm.
 * User: lbhurtado
 * Date: 07/04/16
 * Time: 22:27
 */

namespace App\Commands\Keywords;

use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Jobs\Job;

abstract class KeywordJob extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected static $keywords = [];

    protected static $pattern;

    protected static $order;

    protected $reply;

    public static function getKeywords() {
        if ( count(static::$keywords) == 0 )
        {
            $class = (new \ReflectionClass(static::class))->getShortName();

            if (preg_match("/^#?(?<verb>[A-Z][a-z0-9]+)?(?<keyword>[A-Z][a-z0-9]+)(?<suffix>[A-Z][a-z0-9]+)?$/", $class, $matches))
            {
                return $matches['keyword'];
            }

            return strtoupper($class);
        }

        return implode("|", static::$keywords);
    }

    /**
     * @return mixed
     */
    public function getOrder()
    {
        return $this->order;
    }

    public static function getPattern()
    {

        if ( is_null(static::$pattern) )
        {
            return  "/^#?(?<keyword>" . static::getKeywords() . ")\\s*(?<arguments>.*)$/i";
        }

        return self::$pattern;
    }

    /**
     * @return mixed
     */
    public function getReply()
    {
        return $this->reply;
    }

}