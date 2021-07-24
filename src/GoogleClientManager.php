<?php

namespace Redmix0901\GoogleToken;

class GoogleClientManager
{
    public function use($name)
    {
        return new GoogleClientService($name);
    }
}