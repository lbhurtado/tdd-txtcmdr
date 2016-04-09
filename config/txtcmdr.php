<?php
/**
 * Created by PhpStorm.
 * User: lbhurtado
 * Date: 09/04/16
 * Time: 21:46
 */

return [
    'sms' => [
        'relays' => array_filter(explode(",", env("TXTCMDR_RELAYS"))),
        'signature' => "HQ"
    ]
];