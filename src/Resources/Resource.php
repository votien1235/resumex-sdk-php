<?php

namespace ResumeX\Resources;

use ResumeX\Client;

abstract class Resource
{
    protected Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }
}
