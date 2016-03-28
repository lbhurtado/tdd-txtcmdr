<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Exception;

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
        try
        {
            $watcher = static::create()->cluster()->associate($cluster);

            $watcher->user()->save($user);

            $watcher->save();
        }
        catch (Exception $e)
        {
           return false;
        }

        return $watcher;
    }

    public static function autoDesignate($token, $attributes = []) {
        try
        {
            $user = User::create($attributes);
            $cluster = Cluster::where('token', '=', $token)->firstOrFail();
        }
        catch (Exception $e)
        {
            return false;
        }

        return static::designate($cluster, $user);
    }

    public function scopeHasMobile($query, $mobile)
    {
        if (preg_match(User::$mobileRegex, $mobile, $matches))
            $mobile = User::$defaultCountryCode . $matches['telco'] . $matches['number'];

        return $query->with('user')->whereHas('user', function($q) use ($mobile){
            $q->where('mobile', '=', $mobile);
        });
    }

    public static $test = "Magic Mike";



    public static $patterns = array(
        'organization' => "/^#?(?<tag>start)\\s*(?<message>.*)$/i",
        'deployment' => "/^#?(?<tag>here)\\s*(?<message>.*)$/i",
        'hashcode' => "/^#?(?<tag>hash)\\s*(?<message>.*)$/i",
        'reject' => "/^#?(?<tag>reject)\\s*(?<message>.*)$/i",
        'stray' => "/^#?(?<tag>stray)\\s*(?<message>.*)$/i",
        'transmission' => "/^#?(?<tag>tx)\\s*(?<message>.*)$/i",
    );

    public function execute(Missive $missive)
    {
        foreach(self::$patterns as $key=>$value)
        {
            if (preg_match($value, $missive->body, $matches))
            {
                $post = new Post([
                    'title' => $matches['tag'],
                    'body' => $matches['message'],
                ]);

                $post->user()->associate($this->user);

                $post->save();

                return true;
            }
        }

        return false;

    }
}
