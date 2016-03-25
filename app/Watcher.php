<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Cluster;
use App\User;

class Watcher extends Model
{
    protected $table = 'users_watchers';

    protected $fillable = ['cluster_id'];

    public function user(){

        return $this->morphOne(User::class, 'userable');
    }

    function cluster() {

        return $this->belongsTo(Cluster::class, 'cluster_id');
    }

    public static function designate(Cluster $cluster, User $user) {
        $watcher = static::create()->cluster()->associate($cluster);
        $watcher->user()->save($user);

        return $watcher;
    }
}
