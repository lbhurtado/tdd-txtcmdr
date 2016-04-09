<?php

namespace App\Classes;

use App\Classes\Eventing\EventGenerator;
use App\Classes\Locales\Cluster;
use App\Classes\User;
use App\Events\MissiveWasRecorded;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\WatcherAutoDesignateException;
use App\Events\MissiveWasPosted;

class Missive extends Model
{
    use MobileTrait;

    use EventGenerator;

    protected $fillable = ['mobile', 'body'];

    /**
     * @deprecated
     *
     * @param $mobile
     * @param $body
     * @return static
     */
    public static function post($mobile, $body)
    {
        $missive = static::create(compact('mobile', 'body'));

        $missive->raise(new MissiveWasPosted($missive));

        return $missive;
    }

    public static function record($mobile, $body)
    {
        $missive = static::create(compact('mobile', 'body'));

        event(new MissiveWasRecorded($missive));

        return $missive;
    }
}
