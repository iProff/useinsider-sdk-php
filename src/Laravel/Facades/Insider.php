<?php

namespace KaracaTech\UseInsider\Laravel\Facades;

use Illuminate\Support\Facades\Facade;
use KaracaTech\UseInsider\Client\InsiderClient;

/**
 * @method static \KaracaTech\UseInsider\Service\CustomerService customers()
 * @method static \KaracaTech\UseInsider\Service\EventService events()
 * 
 * @see \KaracaTech\UseInsider\Client\InsiderClient
 */
class Insider extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return InsiderClient::class;
    }
}
