<?php

namespace App\Classes\Locales;

use Illuminate\Database\Eloquent\Model;

class Island extends Model
{
    protected $fillable = ['name'];

    function regions() {
        return $this->hasMany(Region::class);
    }
}
