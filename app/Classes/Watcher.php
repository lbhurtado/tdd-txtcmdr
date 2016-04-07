<?php

namespace App\Classes;

use App\Classes\Locales\Cluster;
use Illuminate\Database\Eloquent\Model;
use Exception;

class Watcher extends Model
{
    protected $table = 'users_watchers';

    public function user()
    {
        return $this->morphOne(User::class, 'userable');
    }

    function cluster() {

        return $this->belongsTo(Cluster::class, 'cluster_id');
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
}
