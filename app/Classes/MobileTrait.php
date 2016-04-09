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

    protected static function bootMobileTrait()
    {
        static::creating(function ($model)
        {

            if ($model::$autoValidate)
            {
                if ($model->validate())
                {
                    $model->mobile = formalizeMobile($model->mobile);

                    return true;
                }

                return false;
            }
        });
    }

    public function validate()
    {
        $validator = Validator::make(['mobile' => $this->mobile], ['mobile' => array('regex:' . MOBILE_REGEX)]);

        return ! $validator->fails();
    }

    public function scopeHasMobile($query, $mobile)
    {
        $mobile = formalizeMobile($mobile);

        return $query->where(function($q) use ($mobile)
        {
            $q->where('mobile', '=', $mobile);
        });
    }
}