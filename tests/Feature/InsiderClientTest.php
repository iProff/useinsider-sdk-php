<?php

namespace Tests\Feature;

use KaracaTech\UseInsider\Client\InsiderClient;
use KaracaTech\UseInsider\Service\CustomerService;
use KaracaTech\UseInsider\Service\EventService;
use PHPUnit\Framework\TestCase;

class InsiderClientTest extends TestCase
{
    private InsiderClient $client;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->client = new InsiderClient(
            partnerName: 'test-partner',
            apiKey: 'test-api-key',
            config: [
                'base_url' => 'https://api.useinsider.com',
                'timeout' => 30
            ]
        );
    }

    public function test_client_initialization(): void
    {
        $this->assertInstanceOf(InsiderClient::class, $this->client);
    }

    public function test_customer_service_access(): void
    {
        $customerService = $this->client->customers();
        $this->assertInstanceOf(CustomerService::class, $customerService);
    }

    public function test_event_service_access(): void
    {
        $eventService = $this->client->events();
        $this->assertInstanceOf(EventService::class, $eventService);
    }
} 