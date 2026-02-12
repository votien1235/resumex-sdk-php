<?php

namespace ResumeX\Exceptions;

use Exception;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;

class ResumeXException extends Exception
{
    protected ?string $errorCode = null;
    protected ?array $errors = null;
    protected ?int $statusCode = null;

    public function __construct(
        string $message = '',
        int $code = 0,
        ?Exception $previous = null,
        ?string $errorCode = null,
        ?array $errors = null,
        ?int $statusCode = null
    ) {
        parent::__construct($message, $code, $previous);
        $this->errorCode = $errorCode;
        $this->errors = $errors;
        $this->statusCode = $statusCode;
    }

    /**
     * Create exception from Guzzle exception
     */
    public static function fromGuzzleException(GuzzleException $e): self
    {
        $message = $e->getMessage();
        $statusCode = null;
        $errorCode = null;
        $errors = null;

        if ($e instanceof ClientException || $e instanceof ServerException) {
            $statusCode = $e->getResponse()->getStatusCode();
            $body = $e->getResponse()->getBody()->getContents();
            $data = json_decode($body, true);

            if (is_array($data)) {
                // Handle message - could be string or array
                if (isset($data['message'])) {
                    if (is_array($data['message'])) {
                        // If message is array, convert to string
                        $message = json_encode($data['message']);
                    } else {
                        $message = $data['message'];
                    }
                }
                
                $errorCode = $data['errorCode'] ?? null;
                $errors = $data['errors'] ?? null;
            }
        }

        return new self(
            $message,
            $e->getCode(),
            $e,
            $errorCode,
            $errors,
            $statusCode
        );
    }

    /**
     * Get the error code from API response
     */
    public function getErrorCode(): ?string
    {
        return $this->errorCode;
    }

    /**
     * Get validation errors
     */
    public function getErrors(): ?array
    {
        return $this->errors;
    }

    /**
     * Get HTTP status code
     */
    public function getStatusCode(): ?int
    {
        return $this->statusCode;
    }

    /**
     * Check if this is a rate limit error
     */
    public function isRateLimitError(): bool
    {
        return $this->statusCode === 429;
    }

    /**
     * Check if this is an authentication error
     */
    public function isAuthenticationError(): bool
    {
        return $this->statusCode === 401;
    }

    /**
     * Check if this is a validation error
     */
    public function isValidationError(): bool
    {
        return $this->statusCode === 400 || $this->statusCode === 422;
    }
}
