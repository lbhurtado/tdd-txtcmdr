<?php
/**
 * Created by PhpStorm.
 * User: lbhurtado
 * Date: 27/03/16
 * Time: 00:55
 */

namespace App\Classes;

use Illuminate\Support\Facades\Validator;

trait MobileTrait
{
    protected static $autoValidate = true;

    public static $defaultCountryCode = "63";

    public static $mobileRegex = "/^(?<country>0|63|\+63)(?<telco>9\d{2})(?<number>\d{7})$/";

    public static function formalize($mobile)
    {
        if (preg_match(static::$mobileRegex, $mobile, $matches))
            $mobile = static::$defaultCountryCode . $matches['telco'] . $matches['number'];

        return $mobile;
    }

    protected static function bootMobileTrait()
    {
        static::creating(function ($model)
        {

            if ($model::$autoValidate)
            {
                if ($model->validate())
                {
                    $model->mobile = self::formalize($model->mobile);

                    return true;
                }

                return false;
            }
        });
    }

    public function validate()
    {
        $validator = Validator::make(['mobile' => $this->mobile], ['mobile' => array('regex:' . static::$mobileRegex)]);

        return ! $validator->fails();
    }

    public function scopeHasMobile($query, $mobile)
    {
        $mobile = self::formalize($mobile);

        return $query->where(function($q) use ($mobile)
        {
            $q->where('mobile', '=', $mobile);
        });
    }
}