<?php

namespace KaracaTech\UseInsider\Service;

use GuzzleHttp\Client;
use KaracaTech\UseInsider\Exception\InsiderException;

class EventService
{
    public function __construct(private Client $client) {}

    public function track(string $eventName, array $data): bool
    {
        try {
            $this->client->post('/api/v1/events', [
                'json' => [
                    'name' => $eventName,
                    'data' => $data
                ]
            ]);

            return true;
        } catch (\Exception $e) {
            throw new InsiderException('Failed to track event: ' . $e->getMessage());
        }
    }
}
