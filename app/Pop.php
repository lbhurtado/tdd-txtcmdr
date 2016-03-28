<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pop extends Model
{
    protected $fillable = ['region', 'province', 'town', 'barangay', 'place',  'cluster', 'precinct', 'registered_voters'];

    protected static function boot()
    {
        parent::boot();

        static::created(function ($model)
        {
            $region = Region::firstOrCreate([
                'name' => $model->region
            ]);

            $province = Province::firstOrCreate([
                'name' => $model->province
            ]);

            $town = Town::firstOrCreate([
                'name' => $model->town
            ]);

            $barangay = Barangay::firstOrCreate([
                'name' => $model->barangay
            ]);

            $place = Place::firstOrCreate([
                'name' => $model->place
            ]);

            $cluster = Cluster::firstOrCreate([
                'number' => $model->cluster
            ]);

            $precinct = Precinct::firstOrCreate([
                'number' => $model->precinct,
                'registered_voters' => $model->registered_voters
            ]);

            $precinct->cluster()->associate($cluster)->save();

            $cluster->place()->associate($place)->save();

            $place->barangay()->associate($barangay)->save();

            $barangay->town()->associate($town)->save();

            $town->province()->associate($province)->save();

            $province->region()->associate($region)->save();

        });
    }
}
