<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Watcher extends Model
{
    protected $table = 'users_watchers';

    protected $fillable = ['clustered_precinct_id'];

    public function user(){

        return $this->morphOne(User::class, 'userable');
    }
}
