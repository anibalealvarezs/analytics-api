<?php

namespace Anibalealvarezs\AnalyticsApi;

use Anibalealvarezs\ApiClientSkeleton\ApiClient;

class AnalyticsApi extends ApiClient
{
    /**
     * Set the Base URL for the Centralized Python Analytics Engine
     * 
     * @param string $host
     */
    public function setHost(string $host): void
    {
        $this->host = $host;
    }

    /**
     * Send a time-series payload for Pearson Correlation
     * 
     * @param array $payload
     * @return array
     */
    public function calculateCorrelation(array $payload): array
    {
        return $this->post('/api/v1/stats/correlation', [
            'json' => $payload
        ]);
    }

    /**
     * Send a time-series payload for Multiple Linear Regression
     * 
     * @param array $payload
     * @return array
     */
    public function calculateRegression(array $payload): array
    {
        return $this->post('/api/v1/stats/regression', [
            'json' => $payload
        ]);
    }
}
