<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Validator;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'mobile', 'email', 'password',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * This is a useful switch to temporarily turn of automatic model validation.
     *
     * @var boolean
     */
    public static $autoValidate = true;

    public static $defaultCountryCode = "63";

    public static $mobileRegex = "/^(?<country>0|63|\+63)(?<telco>9\d{2})(?<number>\d{7})$/";

    protected $attributes = array(
        'verified' => false,
    );
    /**
     * The rules to use for the model validation.
     * Define your validation rules here.
     *
     * @var array
     */
    protected static $rules = array(
        'mobile' => array("regex:/(0|63)(\\d{10})/")
    );

    protected static function boot()
    {
        // This is an important call, makes sure that the model gets booted
        // properly!
        parent::boot();

        // You can also replace this with static::creating or static::updating
        // if you want to call specific validation functions for each case.
        static::creating(function ($model) {
            if ($model::$autoValidate) {
                // If autovalidate is true, validate the model on create
                // and update.
                if ($model->validate()) {

                    if (preg_match(static::$mobileRegex, $model->mobile, $matches))
                        $model->mobile = static::$defaultCountryCode . $matches['telco'] . $matches['number'];

                    return true;
                }

                return false;
            }
        });
    }

    public function validate()
    {
        $validator = Validator::make(['mobile' => $this->mobile], static::$rules);

        if ($validator->fails()) {
            return false;
        }

        return true;
    }

    public function groups() {
        return $this->belongsToMany(Group::class)->withTimestamps();
    }
}
