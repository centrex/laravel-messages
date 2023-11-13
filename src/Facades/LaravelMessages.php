<?php

declare(strict_types=1);

namespace Centrex\LaravelMessages\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Centrex\LaravelMessages\LaravelMessages
 */
class LaravelMessages extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Centrex\LaravelMessages\LaravelMessages::class;
    }
}
