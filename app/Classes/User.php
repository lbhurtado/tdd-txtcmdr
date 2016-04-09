<?php

namespace App\Classes;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Exception;

class User extends Authenticatable
{
    use MobileTrait;

    protected $fillable = [
        'name', 'mobile', 'email', 'password', 'handle'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $attributes = array(
        'verified' => false,
        'notify' => false,
        'password' => "4321"
    );

    protected static function defaultHandleToMobile(array &$attributes)
    {
        if ( ! array_has($attributes, 'handle') && array_has($attributes, 'mobile'))
        {
            array_set($attributes, 'handle', formalizeMobile($attributes['mobile']));
        }
    }

    protected static function generatePassword(array &$attributes)
    {
        $last_4_digits = substr($attributes['mobile'], -4);

        $hash = \Hash::make($last_4_digits);

        array_set($attributes, 'password', $hash);

        if (is_null($attributes['password']))
        {
            throw new \Exception('no password was generated');
        }
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
        if (class_exists($type))
        {
            $userType = $type::create($typeAttributes);

            $userType->user()->create($userAttributes);

            return $userType;
        }
        else {

            throw new Exception("Invalid user type");
        }
    }

    public function activity() {
        return $this->hasMany(Activity::class)->with(['user', 'subject'])->latest();
    }

    public function recordActivity($name, $related) {
        if ( ! method_exists($related, 'recordActivity')) {
            throw new \Exception('..');
        }

        return $related->recordActivity($name);
    }

    public static function create(array $attributes = [])
    {
        self::defaultHandleToMobile($attributes);

        self::generatePassword($attributes);

        $model = parent::create($attributes);

        return $model;
    }

    public function updateCredentials($input)
    {
        $this->notify = isset($input['notify']) ? 1 : 0;

        $this->save();
    }
}
