<?php

namespace AtakanAtici\EDM\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \AtakanAtici\EDM\EDM
 */
class EDM extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \AtakanAtici\EDM\EDM::class;
    }
}
