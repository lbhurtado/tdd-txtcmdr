<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Town;

class Place extends Model
{
    protected $fillable = ['name'];

    function clustered_precincts() {
        return $this->hasMany(ClusteredPrecinct::class);
    }

    function barangay() {
        return $this->belongsTo(Town::class);
    }
}
