<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cluster extends Model
{

    protected $fillable = ['number'];

    function precincts() {
        return $this->hasMany(Precinct::class);
    }

    function place() {
        return $this->belongsTo(Place::class);
    }

    function watchers() {
        return $this->hasMany(Watcher::class);
    }

    /**
     * Boot function for using with Cluster Events
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {

            $model->generateToken();
        });
    }

    /**
     * Generates the value for the Cluster::token field. Used to
     * activate the enlist the watcher's account.
     * @return bool
     */
    protected function generateToken()
    {
        $non_confusing_letters = "FHJKMNPRTVWXY";

        $alpha = substr(str_shuffle($non_confusing_letters), 0, 3);

        $numeric = rand(1, 9) . rand(1, 9) . rand(1, 9) . rand(1, 9);

        $this->attributes['token'] = $alpha . $numeric;

        if( is_null($this->attributes['token']) )
            return false; // failed to create token
        else
            return true;
    }

    public function getClusteredPrecinctsAttribute() {
        $cp = implode(' ', $this->precincts()->pluck('number')->toArray());

        return $cp;
    }

    public function getDesignationAttribute() {
        $input = array();

        array_push($input, "Clustered Precincts " . $this->clustered_precincts);
        array_push($input, "Cluster #" . $this->number);
        array_push($input, $this->place->name);
        array_push($input, $this->place->barangay->name);
        array_push($input, $this->place->barangay->town->name);
        array_push($input, $this->place->barangay->town->province->name);
//        array_push($input, $this->place->barangay->town->province->region->name);

        return implode("\n", $input);
    }

    public function getTotalRegisteredVotersAttribute() {

        return $this->precincts->sum('registered_voters');
    }
}
