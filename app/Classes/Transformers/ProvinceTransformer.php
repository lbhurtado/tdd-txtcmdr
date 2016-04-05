<?php
/**
 * Created by PhpStorm.
 * User: lbhurtado
 * Date: 03/11/15
 * Time: 00:26
 */

namespace App\Classes\Transformers;


class ProvinceTransformer extends Transformer
{
    public function transform($setting)
    {
        return [
            'id'    => $setting->id,
            'name'  => $setting->name,
            'region'=> $setting->region,
            'municipalities' => $setting->towns
        ];
    }
}