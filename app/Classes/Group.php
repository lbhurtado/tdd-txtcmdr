<?php

namespace App\Classes;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = ['name'];

    function add($users) {

        $method = $users instanceof User ? 'save' : 'saveMany';

        return  $this->members()->$method($users);

    }

    function members() {
        return $this->belongsToMany(User::class)->withTimestamps();
    }
}
