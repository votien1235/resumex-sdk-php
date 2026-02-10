<?php

namespace ResumeX\Resources;

use ResumeX\Exceptions\ResumeXException;

class CV extends Resource
{
    /**
     * Generate a new CV
     * 
     * @param array $data CV data including personalInfo, experience, education, etc.
     * @return array Response containing cvId, editorUrl, etc.
     * @throws ResumeXException
     * 
     * @example
     * $cv = $client->cv()->generate([
     *     'userId' => 'user_123',
     *     'personalInfo' => [
     *         'fullName' => 'Nguyen Van A',
     *         'email' => 'user@example.com',
     *         'phone' => '+84912345678',
     *     ],
     *     'experience' => [
     *         [
     *             'company' => 'ABC Company',
     *             'position' => 'Software Engineer',
     *             'startDate' => '2020-01',
     *             'endDate' => '2024-01',
     *             'description' => 'Developed web applications...',
     *         ]
     *     ],
     *     'education' => [...],
     *     'skills' => [...],
     *     'preferences' => [
     *         'language' => 'vi',
     *         'templateId' => 'modern-01',
     *     ],
     * ]);
     * 
     * // Returns:
     * // [
     * //     'cvId' => 'cv_xyz789abc123',
     * //     'editorUrl' => 'https://app.resumex.com/resumes/cv_xyz789abc123?token=...',
     * //     'createdAt' => '2026-02-10T10:00:00Z',
     * // ]
     */
    public function generate(array $data): array
    {
        return $this->client->request('POST', 'cv/generate', $data);
    }

    /**
     * Get CV details
     * 
     * @param string $cvId The CV ID
     * @return array CV details
     * @throws ResumeXException
     */
    public function get(string $cvId): array
    {
        return $this->client->request('GET', "cv/{$cvId}");
    }

    /**
     * Enhance CV with AI
     * 
     * @param string $cvId The CV ID
     * @param array $options Enhancement options
     * @return array Enhanced CV data
     * @throws ResumeXException
     * 
     * @example
     * $enhanced = $client->cv()->enhance('cv_xyz789', [
     *     'sections' => ['summary', 'experience'],
     *     'tone' => 'professional',
     *     'atsOptimization' => true,
     * ]);
     */
    public function enhance(string $cvId, array $options = []): array
    {
        return $this->client->request('POST', "cv/{$cvId}/enhance", $options);
    }

    /**
     * Get job status (for async processing)
     * 
     * @param string $jobId The job ID
     * @return array Job status
     * @throws ResumeXException
     */
    public function getJobStatus(string $jobId): array
    {
        return $this->client->request('GET', "cv/jobs/{$jobId}");
    }

    /**
     * Delete a CV
     * 
     * @param string $cvId The CV ID
     * @return array Response
     * @throws ResumeXException
     */
    public function delete(string $cvId): array
    {
        return $this->client->request('DELETE', "cv/{$cvId}");
    }
}
