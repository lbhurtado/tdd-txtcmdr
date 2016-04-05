<?php
/**
 * Created by PhpStorm.
 * User: lbhurtado
 * Date: 19/11/15
 * Time: 08:25
 */

namespace App\Classes\Transformers;

class SettingTransformer extends Transformer
{

    public function transform($setting)
    {
        return [
            'key' => $setting->code,
            'value' => json_decode($setting->json),
            'description' => $setting->description
        ];
    }
}