<?php


namespace Redmix0901\GoogleToken\Facades;


use Illuminate\Support\Facades\Facade;
use Redmix0901\GoogleToken\GoogleClientManager;

class Goten extends Facade
{
    protected static function getFacadeAccessor()
    {
        return GoogleClientManager::class;
    }
}
