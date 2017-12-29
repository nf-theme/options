<?php

namespace NightFury\Option\Facades;

use Illuminate\Support\Facades\Facade;

class ThemeOptionManager extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'ThemeOption';
    }
}
