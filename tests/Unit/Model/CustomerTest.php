<?php

namespace Tests\Unit\Model;

use KaracaTech\UseInsider\Model\Customer;
use PHPUnit\Framework\TestCase;

class CustomerTest extends TestCase
{
    public function test_customer_creation(): void
    {
        $data = [
            'id' => '12345',
            'email' => 'test@example.com',
            'name' => 'Test User',
            'custom_field' => 'custom value'
        ];

        $customer = new Customer($data);

        $this->assertEquals('12345', $customer->getId());
        $this->assertEquals('test@example.com', $customer->getEmail());
        $this->assertEquals('Test User', $customer->getName());
        $this->assertEquals($data, $customer->toArray());
    }

    public function test_customer_without_optional_fields(): void
    {
        $data = [
            'id' => '12345',
            'email' => 'test@example.com'
        ];

        $customer = new Customer($data);

        $this->assertEquals('12345', $customer->getId());
        $this->assertEquals('test@example.com', $customer->getEmail());
        $this->assertNull($customer->getName());
    }
} 