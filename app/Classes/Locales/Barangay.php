<?php

namespace App\Classes\Locales;

use Illuminate\Database\Eloquent\Model;

class Barangay extends Model
{
    protected $fillable = ['name'];

    function places() {
        return $this->hasMany(Place::class);
    }

    function town() {
        return $this->belongsTo(Town::class);
    }
}
