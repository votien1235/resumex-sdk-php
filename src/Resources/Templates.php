<?php

namespace ResumeX\Resources;

use ResumeX\Exceptions\ResumeXException;

class Templates extends Resource
{
    /**
     * List all available templates
     * 
     * @param array $filters Filter options
     * @return array List of templates
     * @throws ResumeXException
     * 
     * @example
     * $templates = $client->templates()->list([
     *     'category' => 'tech',
     *     'language' => 'vi',
     * ]);
     */
    public function list(array $filters = []): array
    {
        $query = http_build_query($filters);
        $endpoint = 'cv/templates' . ($query ? "?{$query}" : '');
        
        return $this->client->request('GET', $endpoint);
    }

    /**
     * Get template details
     * 
     * @param string $templateId Template ID
     * @return array Template details
     * @throws ResumeXException
     */
    public function get(string $templateId): array
    {
        return $this->client->request('GET', "cv/templates/{$templateId}");
    }

    /**
     * Get template preview URL
     * 
     * @param string $templateId Template ID
     * @return string Preview URL
     * @throws ResumeXException
     */
    public function getPreviewUrl(string $templateId): string
    {
        $response = $this->get($templateId);
        return $response['preview'] ?? '';
    }
}
