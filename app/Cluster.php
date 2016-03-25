<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cluster extends Model
{
    function precincts() {
        return $this->hasMany(Precinct::class);
    }

    function place() {
        return $this->belongsTo(Place::class);
    }

    function watchers() {
        return $this->hasMany(Watcher::class);
    }

    /**
     * Boot function for using with Cluster Events
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {

            $model->generateToken();
        });
    }

    /**
     * Generates the value for the Cluster::token field. Used to
     * activate the enlist the watcher's account.
     * @return bool
     */
    protected function generateToken()
    {
        $this->attributes['token'] = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 3) . rand(1000,9999);

        if( is_null($this->attributes['token']) )
            return false; // failed to create token
        else
            return true;
    }
}
