<?php

namespace App\Classes\Locales;

use Illuminate\Database\Eloquent\Model;

class Precinct extends Model
{
    protected $fillable = ['number', 'registered_voters'];

    function cluster() {
        return $this->belongsTo(Cluster::class);
    }

    public function getNumberAttribute($value)
    {
        $matches = null;

        if (preg_match('/(\\d)*\\s*([a-zA-z])/', $value, $matches)) {

            return str_pad($matches[1], 4, "0", STR_PAD_LEFT) . $matches[2];
        }

        return $value;
    }

    public function setNumberAttribute($value)
    {
        $matches = null;

        if (preg_match('/(\\d)*\\s*([a-zA-z])/', $value, $matches)) {

            $this->attributes['number'] = $matches[1] . $matches[2];
        }
        else {

            $this->attributes['number'] = $value;
        }
    }
}
