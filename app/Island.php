<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Island extends Model
{
    protected $fillable = ['name'];

    function regions() {
        return $this->hasMany(Region::class);
    }
}
