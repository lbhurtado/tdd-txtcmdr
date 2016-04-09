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
    public function validate(PostKeywordCommand $command) {

        $keywordClasses = getKeywordClasses();

        $classes = [];

        foreach($keywordClasses as $keywordClass)
        {
            $keywordObject = (new \ReflectionClass($keywordClass))->newInstance();

            $classes[] = strtolower($keywordObject->getKeyword());
        }

        $regexKeywordClasses = "/^(" . implode("|", $classes) . ")$/i";

        $validator = Validator::make(
            [
                'mobile'  => $command->mobile,
                'keyword' => $command->keyword,
            ],
            [
                'mobile'  => ['required', 'regex: ' . MOBILE_REGEX],
                'keyword' => ['required', 'regex: ' . $regexKeywordClasses]
            ]
        );

        if ($validator->fails()) {
            throw new \Exception('Validation failed');
        }
    }
}