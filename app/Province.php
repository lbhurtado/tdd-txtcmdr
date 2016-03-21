<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    protected $fillable = ['name'];

    function towns() {
        return $this->hasMany(Town::class);
    }

    function region() {
        return $this->belongsTo(Region::class);
    }
}
