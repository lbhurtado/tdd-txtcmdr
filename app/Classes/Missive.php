<?php

namespace App\Classes;

use App\Classes\Eventing\EventGenerator;
use App\Events\MissiveWasRecorded;
use Illuminate\Database\Eloquent\Model;
use App\WatcherAutoDesignateException;
use App\Events\MissiveWasPosted;

class Missive extends Model
{
    use MobileTrait;

    use EventGenerator;

    protected $fillable = ['mobile', 'body'];

    public static function boot()
    {
        parent::boot();

        static::created(function($model) {
            event(new MissiveWasRecorded($model));
        });
    }

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
}
