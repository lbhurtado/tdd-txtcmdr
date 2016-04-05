<?php
/**
 * Created by PhpStorm.
 * User: lbhurtado
 * Date: 02/11/15
 * Time: 22:51
 */

namespace App\Classes\Transformers;


class RegionTransformer extends Transformer
{
    public function transform($region)
    {
        return [
//            'id'        => $region['id'],
//            'name'      => $region['name'],
//            'key'       => $region['code'],
//            'provinces' => $region['provinces']
            'id'            => $region->id,
            'name'          => $region->name,
            'key'           => $region->code,
//            'island group'  => $region->island_group,
//            'provinces'     => $region->provinces
        ];
    }
}