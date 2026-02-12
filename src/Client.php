<?php

namespace ResumeX;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\GuzzleException;
use ResumeX\Exceptions\ResumeXException;
use ResumeX\Resources\CV;
use ResumeX\Resources\Partner;
use ResumeX\Resources\Templates;

class Client
{
    protected HttpClient $httpClient;
    protected string $apiKey;
    protected string $apiSecret;
    protected string $baseUrl;

    // Resource instances
    protected ?CV $cv = null;
    protected ?Partner $partner = null;
    protected ?Templates $templates = null;

    public function __construct(array $config = [])
    {
        $this->apiKey = $config['api_key'] ?? config('resumex.api_key') ?? '';
        $this->apiSecret = $config['api_secret'] ?? config('resumex.api_secret') ?? '';
        
        $environment = $config['environment'] ?? config('resumex.environment', 'production');
        $this->baseUrl = $environment === 'sandbox' 
            ? ($config['sandbox_url'] ?? config('resumex.sandbox_url', 'https://sandbox-api.resumex.com'))
            : ($config['base_url'] ?? config('resumex.base_url', 'https://api.resumex.com'));

        $this->httpClient = new HttpClient([
            'base_uri' => rtrim($this->baseUrl, '/') . '/',
            'timeout' => $config['timeout'] ?? 30,
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ],
        ]);
    }

    /**
     * CV resource
     */
    public function cv(): CV
    {
        if ($this->cv === null) {
            $this->cv = new CV($this);
        }
        return $this->cv;
    }

    /**
     * Partner resource
     */
    public function partner(): Partner
    {
        if ($this->partner === null) {
            $this->partner = new Partner($this);
        }
        return $this->partner;
    }

    /**
     * Templates resource
     */
    public function templates(): Templates
    {
        if ($this->templates === null) {
            $this->templates = new Templates($this);
        }
        return $this->templates;
    }

    /**
     * Make an authenticated request to the API
     *
     * @param string $method HTTP method
     * @param string $endpoint API endpoint
     * @param array $data Request data
     * @return array Response data
     * @throws ResumeXException
     */
    public function request(string $method, string $endpoint, array $data = []): array
    {
        $timestamp = time();
        $url = '/api/v1/' . ltrim($endpoint, '/');
        
        // IMPORTANT: Use the same JSON string for both signature and request body
        // to ensure consistency. Use JSON_UNESCAPED_UNICODE to match how NestJS parses the body
        $body = empty($data) ? '' : json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        // Generate HMAC signature
        $signature = $this->generateSignature($method, $url, $timestamp, $body);

        $headers = [
            'X-API-Key' => $this->apiKey,
            'X-Signature' => $signature,
            'X-Timestamp' => (string) $timestamp,
        ];

        $options = [
            'headers' => $headers,
        ];

        // Use 'body' instead of 'json' to send the exact same string used for signature
        if (!empty($data)) {
            $options['body'] = $body;
            $options['headers']['Content-Type'] = 'application/json';
        }

        try {
            $response = $this->httpClient->request($method, $url, $options);
            $responseBody = $response->getBody()->getContents();
            
            return json_decode($responseBody, true) ?? [];
        } catch (GuzzleException $e) {
            throw ResumeXException::fromGuzzleException($e);
        }
    }

    /**
     * Generate HMAC-SHA256 signature
     */
    protected function generateSignature(string $method, string $url, int $timestamp, string $body): string
    {
        $message = strtoupper($method) . $url . $timestamp . $body;
        return hash_hmac('sha256', $message, $this->apiSecret);
    }

    /**
     * Get the API key
     */
    public function getApiKey(): string
    {
        return $this->apiKey;
    }

    /**
     * Get the base URL
     */
    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }
}
