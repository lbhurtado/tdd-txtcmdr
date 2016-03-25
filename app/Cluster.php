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
}
