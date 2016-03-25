<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cluster extends Model
{

    protected $fillable = ['number'];

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
        $nonconfusingletters = "FHJKMNPRTVWXY";

        $alpha = substr(str_shuffle($nonconfusingletters), 0, 3);

        $numeric = rand(1, 9) . rand(1, 9) . rand(1, 9) . rand(1, 9);

        $this->attributes['token'] = $alpha . $numeric;

        if( is_null($this->attributes['token']) )
            return false; // failed to create token
        else
            return true;
    }
}
