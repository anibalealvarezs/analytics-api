<?php

namespace Anibalealvarezs\AnalyticsApi;

use Anibalealvarezs\ApiSkeleton\Clients\ApiKeyClient;
use Anibalealvarezs\ApiSkeleton\Enums\DelayUnit;
use Psr\Http\Message\ResponseInterface;

class AnalyticsApi extends ApiKeyClient
{
    public function __construct(string $baseUrl = 'http://localhost', string $apiKey = 'dev_secret_key')
    {
        parent::__construct(
            baseUrl: $baseUrl,
            apiKey: $apiKey,
            authSettings: [
                'location' => 'header',
                'name' => 'X-Admin-API-Key',
            ],
            defaultHeaders: [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ],
            delayHeader: null,
            delayUnit: DelayUnit::second,
            guzzleClient: null,
            debugMode: false
        );
    }

    /**
     * Set the Base URL for the Centralized Python Analytics Engine
     * 
     * @param string $host
     */
    public function setHost(string $host): void
    {
        $this->setBaseUrl(rtrim($host, '/') . '/');
    }

    /**
     * Send a time-series payload for Pearson Correlation
     * 
     * @param array $payload
     * @return array
     */
    public function calculateCorrelation(array $payload): array
    {
        $response = $this->post('api/v1/stats/correlation', [
            'json' => $payload
        ]);
        return json_decode($response->getBody()->getContents(), true) ?? [];
    }

    /**
     * Send a time-series payload for Multiple Linear Regression
     * 
     * @param array $payload
     * @return array
     */
    public function calculateRegression(array $payload): array
    {
        $response = $this->post('api/v1/stats/regression', [
            'json' => $payload
        ]);
        return json_decode($response->getBody()->getContents(), true) ?? [];
    }

    /**
     * Generic POST method mimicking Guzzle's signature
     * 
     * @param string $endpoint
     * @param array $options
     * @return ResponseInterface
     */
    public function post(string $endpoint, array $options = []): ResponseInterface
    {
        $headers = $options['headers'] ?? [];
        $body = isset($options['json']) ? json_encode($options['json']) : ($options['body'] ?? '');
        
        return $this->performRequest(
            method: 'POST',
            endpoint: ltrim($endpoint, '/'),
            query: $options['query'] ?? [],
            body: $body,
            headers: $headers
        );
    }
}
