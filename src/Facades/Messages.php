<?php

declare(strict_types=1);

namespace Centrex\Messages\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Centrex\Messages\Messages
 */
class Messages extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Centrex\Messages\Messages::class;
    }
}
