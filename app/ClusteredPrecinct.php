<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClusteredPrecinct extends Model
{
    function precincts() {
        return $this->hasMany(Precinct::class);
    }

    function place() {
        return $this->belongsTo(Place::class);
    }
}
