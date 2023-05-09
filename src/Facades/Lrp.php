<?php

namespace NovatoPro\Lrp\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \NovatoPro\Lrp\Lrp
 */
class Lrp extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \NovatoPro\Lrp\Lrp::class;
    }
}
