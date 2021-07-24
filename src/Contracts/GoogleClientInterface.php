<?php

namespace Redmix0901\GoogleToken\Contracts;

interface GoogleClientInterface
{
    /**
     * @return \Google_Client
     */
    public function getClient();

    /**
     * @return mixed
     */
    public function getOptionsConfig();
}
