<?php

namespace Elsayed85\Notion;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Elsayed85\Notion\Notion
 */
class NotionFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'notion';
    }
}
