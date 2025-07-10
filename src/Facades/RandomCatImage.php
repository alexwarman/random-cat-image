<?php

namespace Alexwarman\RandomCatImage\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static string get()
 * 
 * @see \Alexwarman\RandomCatImage\RandomCatImage
 */
class RandomCatImage extends Facade
{
    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor(): string
    {
        return 'random-cat-image';
    }
}
