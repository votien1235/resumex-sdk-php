<?php

namespace ResumeX\Resources;

use ResumeX\Exceptions\ResumeXException;

class CV extends Resource
{
    /**
     * Generate a new CV
     * 
     * @param array $data CV data including userId, templateId, email, and CV content
     * @return array Response containing cvId, editorUrl, etc.
     * @throws ResumeXException
     * 
     * Required fields:
     * - userId: Unique ID of the user in your system
     * - templateId: 'classic' | 'basic' | 'two-column-modern' | 'professional-grid'
     * - email: User's email address
     * 
     * @example Standard CV (classic, basic, two-column-modern)
     * $cv = $client->cv()->generate([
     *     // Required fields
     *     'userId' => 'user_123',
     *     'templateId' => 'classic',
     *     'email' => 'example@example.com',
     *     
     *     // Basic info (optional - user can fill in editor)
     *     'firstName' => 'NGUYEN VAN',
     *     'lastName' => 'A',
     *     'phoneNumber' => '0123-456-789',
     *     'location' => 'Japan',
     *     'linkedinUrl' => 'https://linkedin.com/in/username',
     *     'githubUrl' => 'https://github.com/username',
     *     
     *     // CV Content (optional)
     *     'professionalSummary' => 'Senior QA Engineer with 5+ years...',
     *     'workExperience' => [
     *         [
     *             'company' => '1Bitlab Technology JSC',
     *             'position' => 'Senior QA Engineer',
     *             'location' => 'Japan',
     *             'date' => 'Oct 2025 - Present',
     *             'description' => ['Led QA team...'],
     *             'technologies' => ['React', 'Node.js'],
     *         ],
     *     ],
     *     'education' => [...],
     *     'skills' => [
     *         ['category' => 'Testing', 'items' => ['Manual', 'Automation']],
     *     ],
     *     
     *     // Preferences (optional)
     *     'preferences' => [
     *         'language' => 'ja', // 'ja' | 'en'
     *     ],
     * ]);
     * 
     * @example Japanese CV (professional-grid template)
     * $cv = $client->cv()->generate([
     *     // Required fields
     *     'userId' => 'user_123',
     *     'templateId' => 'professional-grid',
     *     'email' => 'example@example.com',
     *     
     *     // Japanese CV specific fields
     *     'webCv' => [
     *         // Basic Info
     *         'lastName' => '山田',
     *         'firstName' => '太郎',
     *         'lastNameFurigana' => 'ヤマダ',
     *         'firstNameFurigana' => 'タロウ',
     *         'birthDate' => '1990-05-15',
     *         'gender' => 'male',       // 'male' | 'female' | 'other'
     *         'email' => 'example@example.com',
     *         'phone' => '090-1234-5678',
     *         
     *         // Address
     *         'postalCode' => '100-0001',
     *         'prefecture' => '東京都',
     *         'city' => '千代田区',
     *         'address' => '丸の内1-1-1',
     *         'building' => 'ビル名101',
     *         
     *         // Photo
     *         'photoUrl' => 'https://example.com/photo.jpg',
     *         'photoBase64' => 'data:image/jpeg;base64,...', // or base64
     *         
     *         // Career
     *         'careerHistory' => [
     *             [
     *                 'date' => '2015年4月',
     *                 'event' => '○○株式会社 入社',
     *             ],
     *             [
     *                 'date' => '2020年3月',
     *                 'event' => '○○株式会社 退社',
     *             ],
     *         ],
     *         
     *         // Licenses & Qualifications
     *         'licenses' => [
     *             [
     *                 'date' => '2018年6月',
     *                 'name' => '普通自動車第一種運転免許',
     *             ],
     *         ],
     *         
     *         // Self PR & Motivation
     *         'selfPr' => '私の強みは...',
     *         'motivation' => '御社を志望した理由は...',
     *         
     *         // Commute & Dependents
     *         'commuteTime' => '45分',
     *         'dependents' => '2人',
     *         'spouse' => 'あり',
     *         'spouseSupportObligation' => 'なし',
     *         
     *         // Preferences
     *         'desiredSalary' => '500万円',
     *         'specialSkills' => 'TOEIC 850点、英語での業務経験あり',
     *         'requests' => '特になし',
     *     ],
     *     
     *     // Preferences (optional)
     *     'preferences' => [
     *         'language' => 'ja',
     *     ],
     * ]);
     * 
     * // Returns:
     * // [
     * //     'cvId' => 'cv_xyz789abc123',
     * //     'editorUrl' => 'https://app.resumex.com/resumes/cv_xyz789abc123?token=...',
     * //     'status' => 'ready',
     * //     'expiresAt' => '2026-03-12T10:00:00Z',
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
