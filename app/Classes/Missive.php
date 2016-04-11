<?php

namespace App\Classes;

use Illuminate\Database\Eloquent\Model;
use App\Events\MissiveWasRecorded;

class Missive extends Model
{
    use MobileTrait;

    protected $fillable = ['mobile', 'body'];
}
