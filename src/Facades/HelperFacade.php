<?php

namespace BhuVidya\BladeHelper\Facades;

use Illuminate\Support\Facades\Facade;

class HelperFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return config('blade_helper.instance');
    }
}
