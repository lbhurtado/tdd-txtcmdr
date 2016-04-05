<?php
/**
 * Created by PhpStorm.
 * User: lbhurtado
 * Date: 02/11/15
 * Time: 22:49
 */

namespace App\Classes\Transformers;

use Illuminate\Database\Eloquent\Collection;

abstract class Transformer
{
    public function transformCollection(Collection $items)
    {
        return array_map([$this, 'transform'], $items->all());
    }

    abstract function transform($items);
}