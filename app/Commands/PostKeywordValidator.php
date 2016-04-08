<?php
/**
 * Created by PhpStorm.
 * User: lbhurtado
 * Date: 07/04/16
 * Time: 12:56
 */

namespace App\Commands;

use Illuminate\Support\Facades\Validator;

class PostKeywordValidator
{
    static $rules = [
        'mobile'  => ['required', 'regex: /^(?<country>0|63|\+63)(?<telco>9\d{2})(?<number>\d{7})$/'],
        'keyword' => ['required', 'regex: /^(start|here)$/i'],
    ];

    public function validate(PostKeywordCommand $command) {
        $validator = Validator::make(
            [
                'mobile'  => $command->mobile,
                'keyword' => $command->keyword,
            ],
            self::$rules
        );

        if ($validator->fails()) {
            throw new \Exception('Validation failed');
        }
    }
}