<?php

namespace KaracaTech\UseInsider\Client;

use GuzzleHttp\Client as HttpClient;
use KaracaTech\UseInsider\Service\CustomerService;
use KaracaTech\UseInsider\Service\EventService;
use KaracaTech\UseInsider\Exception\InsiderException;

class InsiderClient
{
    private HttpClient $httpClient;
    private CustomerService $customerService;
    private EventService $eventService;

    public function __construct(
        private string $partnerName,
        private string $apiKey,
        private array $config = []
    ) {
        $this->httpClient = new HttpClient([
            'base_uri' => $config['base_url'] ?? 'https://api.useinsider.com',
            'timeout' => $config['timeout'] ?? 30,
            'headers' => [
                'X-Request-Token' => $this->apiKey,
                'X-Partner-Name' => $this->partnerName,
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ]
        ]);

        $this->customerService = new CustomerService($this->httpClient);
        $this->eventService = new EventService($this->httpClient);
    }

    public function customers(): CustomerService
    {
        return $this->customerService;
    }

    public function events(): EventService
    {
        return $this->eventService;
    }
}
