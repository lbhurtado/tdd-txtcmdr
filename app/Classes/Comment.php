<?php

namespace App\Classes;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['body', 'user_id', 'post_id'];

    use RecordsActivity;
}
