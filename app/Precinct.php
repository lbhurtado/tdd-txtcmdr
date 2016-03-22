<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Precinct extends Model
{
    protected $fillable = ['number'];

    function clustered_precinct() {
        return $this->belongsTo(ClusteredPrecinct::class);
    }
}
