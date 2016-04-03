<?php

namespace App\Classes;

use App\Classes\User;
use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    protected $fillable = ['pin'];

    protected $casts = [
        'pin' => 'string',
    ];

    private function getZeroPaddedNumber($value, $padding)
    {
        return str_pad($value, $padding, "0", STR_PAD_LEFT);
    }

    public function __construct(array $attributes = array())
    {
        $pin = $this->getZeroPaddedNumber(random_int(0,9999), 4);

        $mergedAttributes = array_merge($this->attributes, compact('pin'));

        $this->setRawAttributes($mergedAttributes, true);

        parent::__construct($attributes);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
