<?php
/**
 * Created by PhpStorm.
 * User: lbhurtado
 * Date: 03/11/15
 * Time: 00:46
 */

namespace App\Classes\Transformers;


class TownTransformer extends Transformer
{
    public function transform($town)
    {
        return [
            'id'        => $town->id,
            'name'      => $town->name,
            'province'  => $town->province
        ];
    }
}