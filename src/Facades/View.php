<?php

namespace NightFury\Option\Facades;

use Illuminate\Support\Facades\Facade;

class View extends Facade
{
    protected static function getFacadeAccessor()
    {
        return new \NightFury\Option\Services\View;
    }
}
