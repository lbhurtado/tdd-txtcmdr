<?php

namespace App\Classes;

use App\Classes\User;
use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    protected $fillable = ['pin', 'user_id'];

    protected $casts = [
        'pin' => 'string',
    ];

    function getZeroPaddedNumber($value, $padding, $pad_type = STR_PAD_LEFT) {
        return str_pad($value, $padding, "0", STR_PAD_LEFT);
    }

    public function __construct(array $attributes = array()) {
        $this->setRawAttributes(
            array_merge(
                $this->attributes,
                array('pin' => $this->getZeroPaddedNumber(random_int(0,9999), 4))
            ),
            true
        );

        parent::__construct($attributes);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
