<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Town extends Model
{
    protected $fillable = ['name'];

    function barangays() {
        return $this->hasMany(Barangay::class);
    }

    function province() {
        return $this->belongsTo(Province::class);
    }
}
