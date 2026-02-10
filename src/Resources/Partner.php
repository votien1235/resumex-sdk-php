<?php

namespace ResumeX\Resources;

use ResumeX\Exceptions\ResumeXException;

class Partner extends Resource
{
    /**
     * Get partner quota information
     * 
     * @return array Quota data
     * @throws ResumeXException
     * 
     * @example
     * $quota = $client->partner()->getQuota();
     * // Returns:
     * // [
     * //     'tier' => 'STARTER',
     * //     'quota' => 1000,
     * //     'used' => 342,
     * //     'remaining' => 658,
     * //     'resetDate' => '2026-03-01T00:00:00Z',
     * // ]
     */
    public function getQuota(): array
    {
        return $this->client->request('GET', 'partners/quota');
    }

    /**
     * Get usage statistics
     * 
     * @param string $period Period: 'current_month', 'last_month', 'last_7_days', etc.
     * @return array Usage statistics
     * @throws ResumeXException
     */
    public function getUsage(string $period = 'current_month'): array
    {
        return $this->client->request('GET', "partners/usage?period={$period}");
    }

    /**
     * Get analytics dashboard data
     * 
     * @param string $period Period for analytics
     * @return array Dashboard metrics
     * @throws ResumeXException
     */
    public function getDashboard(string $period = 'last_30_days'): array
    {
        return $this->client->request('GET', "partners/analytics/dashboard?period={$period}");
    }

    /**
     * Update partner profile
     * 
     * @param array $data Profile data to update
     * @return array Updated profile
     * @throws ResumeXException
     */
    public function updateProfile(array $data): array
    {
        return $this->client->request('PATCH', 'partners/profile', $data);
    }

    /**
     * Regenerate API credentials
     * 
     * @param string $type 'api_key', 'api_secret', or 'both'
     * @return array New credentials
     * @throws ResumeXException
     */
    public function regenerateCredentials(string $type = 'api_secret'): array
    {
        return $this->client->request('POST', 'partners/credentials/regenerate', [
            'type' => $type,
        ]);
    }
}
