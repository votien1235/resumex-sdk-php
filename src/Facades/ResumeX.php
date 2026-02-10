<?php

namespace ResumeX\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \ResumeX\Resources\CV cv()
 * @method static \ResumeX\Resources\Partner partner()
 * @method static \ResumeX\Resources\Templates templates()
 * @method static array request(string $method, string $endpoint, array $data = [])
 * 
 * @see \ResumeX\Client
 */
class ResumeX extends Facade
{
    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor(): string
    {
        return 'resumex';
    }
}
