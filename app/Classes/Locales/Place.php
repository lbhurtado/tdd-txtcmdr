<?php

namespace App\Classes\Locales;

use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    protected $fillable = ['name'];

    function clusters() {
        return $this->hasMany(Cluster::class);
    }

    function barangay() {
        return $this->belongsTo(Barangay::class);
    }
}
