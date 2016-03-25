<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pop extends Model
{
    protected $fillable = ['region', 'province', 'town', 'barangay', 'place',  'cluster', 'precinct', 'registered_voters'];

    protected static function boot() {
        parent::boot();

        static::created(function ($model) {
            $region = Region::create(['name' => $model->region]);
            $province = Province::create(['name' => $model->province]);
            $town = Town::create(['name' => $model->town]);
            $barangay = Barangay::create(['name' => $model->barangay]);
            $place = Place::create(['name' => $model->place]);
            $cluster = Cluster::create(['number' => $model->cluster]);
            $precinct = Precinct::create(['number' => $model->precinct]);

            $precinct->cluster()->associate($cluster)->save();
            $cluster->place()->associate($place)->save();
            $place->barangay()->associate($barangay)->save();
            $barangay->town()->associate($town)->save();
            $town->province()->associate($province)->save();
            $province->region()->associate($region)->save();
        });
    }
}
