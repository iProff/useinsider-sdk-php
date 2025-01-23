<?php

namespace KaracaTech\UseInsider\Service;

use GuzzleHttp\Client;
use KaracaTech\UseInsider\Exception\InsiderException;
use KaracaTech\UseInsider\Model\Customer;

class CustomerService
{
    private const API_VERSION = 'v1';
    private const BASE_PATH = '/api/user';

    public function __construct(
        private Client $client
    ) {}

    /**
     * Kullanıcı oluştur veya güncelle
     * 
     * @param array $identifiers Kullanıcı tanımlayıcıları (email, phone_number, custom.*)
     * @param array $attributes Kullanıcı özellikleri
     * @return Customer
     * @throws InsiderException
     */
    public function upsert(array $identifiers, array $attributes = [])
    {
        if (empty($identifiers)) {
            throw new InsiderException('Identifiers array is required');
        }

        try {
            $endpoint = sprintf('%s/%s/upsert', self::BASE_PATH, self::API_VERSION);
            
            $response = $this->client->post($endpoint, [
                'json' => [
                    'users' => [[
                        'identifiers' => $identifiers,
                        'attributes' => $attributes
                    ]]
                ]
            ]);

            $responseData = json_decode($response->getBody()->getContents(), true);
            
            if (!isset($responseData['data'])) {
                throw new InsiderException('Invalid response from Insider API');
            }

            return $responseData['data'];
        } catch (\Exception $e) {
            throw new InsiderException('Failed to upsert customer: ' . $e->getMessage());
        }
    }

    /**
     * Kullanıcı verilerini API formatına dönüştür
     */
    private function prepareUserData(array $data): array
    {
        return [
            'identifiers' => $data['identifiers'] ?? [],
            'attributes' => $data['attributes'] ?? [],
            // 'platform' => $data['platform'] ?? 'API',
            // 'email_permission' => $data['email_permission'] ?? false,
            // 'sms_permission' => $data['sms_permission'] ?? false,
            // 'whatsapp_permission' => $data['whatsapp_permission'] ?? false,
            // 'push_permission' => $data['push_permission'] ?? false,
            // 'web_push_permission' => $data['web_push_permission'] ?? false,
            // 'gsm_permission' => $data['gsm_permission'] ?? false,
            // 'language' => $data['language'] ?? null,
            // 'timezone' => $data['timezone'] ?? null,
            // 'currency' => $data['currency'] ?? null,
            // 'segments' => $data['segments'] ?? [],
            // 'tags' => $data['tags'] ?? []
        ];
    }

    /**
     * Kullanıcı sil
     * 
     * @param array $identifiers
     * @return bool
     * @throws InsiderException
     */
    public function delete(array $identifiers): bool
    {
        try {
            $endpoint = sprintf('%s/%s/delete', self::BASE_PATH, self::API_VERSION);
            
            $response = $this->client->post($endpoint, [
                'json' => [
                    'identifiers' => $identifiers
                ]
            ]);

            $responseData = json_decode($response->getBody()->getContents(), true);
            return $responseData['success'] ?? false;
        } catch (\Exception $e) {
            throw new InsiderException('Failed to delete customer: ' . $e->getMessage());
        }
    }

    /**
     * Kullanıcı verilerini getir
     * 
     * @param array $identifiers
     * @return Customer
     * @throws InsiderException
     */
    public function get(array $identifiers): Customer
    {
        try {
            $endpoint = sprintf('%s/%s/get', self::BASE_PATH, self::API_VERSION);
            
            $response = $this->client->post($endpoint, [
                'json' => [
                    'identifiers' => $identifiers
                ]
            ]);

            $responseData = json_decode($response->getBody()->getContents(), true);
            
            if (!isset($responseData['data'])) {
                throw new InsiderException('User not found');
            }

            return new Customer($responseData['data']);
        } catch (\Exception $e) {
            throw new InsiderException('Failed to get customer: ' . $e->getMessage());
        }
    }
}
