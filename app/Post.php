<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['title', 'body'];

    use RecordsActivity;

//    protected static $recordEvents = ['created'];

}
