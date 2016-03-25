<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Validator;
use App\Token;
use Exception;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'mobile', 'email', 'password', 'handle'
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

                    $model->generatePassword();

                    $model->generateHandle();

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

    /**
     * Generates the value for the User::password field.
     * @return bool
     */
    protected function generatePassword()
    {
        $last_4_digits = substr($this->mobile, -4);

        $this->attributes['password'] = $this->password ? $this->password : \Hash::make($last_4_digits);

        if( is_null($this->attributes['password']) )
            return false; // failed to create token
        else
            return true;
    }

    /**
     * Generates the value for the User::handle field.
     * @return bool
     */
    protected function generateHandle()
    {
        $this->attributes['handle'] = $this->handle ? $this->handle : $this->mobile;

        if( is_null($this->attributes['handle']) )
            return false; // failed to create token
        else
            return true;
    }

    public function groups() {

        return $this->belongsToMany(Group::class)->withTimestamps();
    }

    public function tokens() {
        return $this->hasMany(Token::class);
    }

    public function newToken($attributes = null) {

        return $this->tokens()->create($attributes);
    }

    public function userable(){

        return $this->morphTo();
    }

    public static function createUser($type, array $userAttributes, array $typeAttributes = []) {
        if (class_exists($type)) {
            $userType = $type::create($typeAttributes);
            $userType->user()->create($userAttributes);

            return $userType;
        }
        else {

            throw new Exception("Invalid user type");
        }
    }
}
