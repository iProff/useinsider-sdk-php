<?php

namespace Tests\Unit\Service;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use KaracaTech\UseInsider\Exception\InsiderException;
use KaracaTech\UseInsider\Model\Customer;
use KaracaTech\UseInsider\Service\CustomerService;
use PHPUnit\Framework\TestCase;

class CustomerServiceTest extends TestCase
{
    private MockHandler $mockHandler;
    private Client $client;
    private CustomerService $customerService;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->mockHandler = new MockHandler();
        $handlerStack = HandlerStack::create($this->mockHandler);
        $this->client = new Client(['handler' => $handlerStack]);
        $this->customerService = new CustomerService($this->client);
    }

    public function test_customer_upsert_successful(): void
    {
        $mockResponse = [
            'data' => [[
                'id' => '12345',
                'email' => 'test@example.com',
                'name' => 'Test User'
            ]]
        ];

        $this->mockHandler->append(
            new Response(200, [], json_encode($mockResponse))
        );

        $customer = $this->customerService->upsert(
            identifiers: [
                'email' => 'test@example.com'
            ],
            attributes: [
                'name' => 'Test User'
            ]
        );
        
        $this->assertInstanceOf(Customer::class, $customer);
        $this->assertEquals('12345', $customer->getId());
        $this->assertEquals('test@example.com', $customer->getEmail());
    }

    public function test_customer_upsert_without_identifiers(): void
    {
        $this->expectException(InsiderException::class);
        $this->expectExceptionMessage('Identifiers array is required');

        $this->customerService->upsert(
            identifiers: [],
            attributes: ['name' => 'Test User']
        );
    }

    public function test_customer_upsert_without_valid_identifier(): void
    {
        $this->expectException(InsiderException::class);
        $this->expectExceptionMessage('At least one identifier (email, phone_number, or custom.*) is required');

        $customerData = [
            'identifiers' => [],
            'attributes' => [
                'name' => 'Ahmet Yılmaz'
            ]
        ];

        $this->customerService->upsert($customerData);
    }

    public function test_customer_upsert_api_error(): void
    {
        $this->mockHandler->append(
            new Response(500, [], json_encode(['error' => 'Internal Server Error']))
        );

        $this->expectException(InsiderException::class);
        $this->expectExceptionMessage('Failed to upsert customer');

        $customerData = [
            'identifiers' => [
                'email' => 'ornek@email.com'
            ],
            'attributes' => [
                'name' => 'Ahmet Yılmaz'
            ]
        ];

        $this->customerService->upsert($customerData);
    }
} 