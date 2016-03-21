<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    protected $fillable = ['name'];

    function provinces() {
        return $this->hasMany(Province::class);
    }

    function island() {
        return $this->belongsTo(Island::class);
    }
}
