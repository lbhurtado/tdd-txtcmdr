<?php

namespace App\Classes;

use App\Classes\Locales\Cluster;
use App\Classes\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\WatcherAutoDesignateException;
use App\Events\MissiveWasPosted;

class Missive extends Model
{
    protected $fillable = ['mobile', 'body'];

    use MobileTrait;

    protected static function boot()
    {
        parent::boot();

        static::created(function ($model)
        {
            $model->execute();
        });
    }

    protected function execute()
    {
        try
        {
            $user = User::hasMobile($this->mobile)->firstOrFail();

            $type = $user->userable_type;

            if ( ! is_null($type))
            {
                switch ($type)
                {
                    case Watcher::class:
                        $watcher = (new \ReflectionClass($type))
                            ->newInstance()->with('user')->whereHas('user', function($q){
                                $q->whereMobile($this->mobile);
                            })->firstOrFail();

                        $watcher->execute($this);

                        break;
                }

            }
        }
        catch (ModelNotFoundException $e)
        {
            $this->spawn();
        }
    }

    protected function spawn()
    {
        if (preg_match(Cluster::$token_pattern, $this->body, $matches))
        {
            Watcher::autoDesignate($this->body, ['mobile' => $this->mobile]);
        }
        else
        {
            User::create(['mobile' => $this->mobile]);
        }
    }

    public static function post($mobile, $body)
    {
        $missive = static::create(compact('mobile', 'body'));

        $missive->raise(new MissiveWasPosted($missive));

        return $missive;
    }
}
