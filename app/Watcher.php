<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Watcher extends Model
{
    protected $table = 'users_watchers';

    public function user(){

        return $this->morphOne(User::class, 'userable');
    }

    function cluster() {

        return $this->belongsTo(Cluster::class, 'cluster_id');
    }

    public static function designate(Cluster $cluster, User $user) {
        $watcher = static::create()->cluster()->associate($cluster);

        $watcher->user()->save($user);

        $watcher->save();

        return $watcher;
    }

    public static function autoDesignate($token, $attributes = []) {
        $user = User::create($attributes);

        $cluster = Cluster::where('token', '=', $token)->firstOrFail();

        return static::designate($cluster, $user);
    }

    public function scopeHasMobile($query, $mobile)
    {
        if (preg_match(User::$mobileRegex, $mobile, $matches))
            $mobile = User::$defaultCountryCode . $matches['telco'] . $matches['number'];

        return $query->whereHas('user', function($q) use ($mobile){
            $q->where('mobile', '=', $mobile);
        });
    }
}
