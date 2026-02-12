<?php

/**
 * ResumeX SDK - Update CV Example
 * 
 * This example demonstrates how to update an existing CV using the PATCH API.
 * Use this when you need to sync changes from your system to ResumeX.
 * 
 * Use Case: Bidirectional Sync
 * ----------------------------
 * When a user updates their profile in your system, you can push the changes
 * to ResumeX so that their CV is always up-to-date before they open the editor.
 */

require_once __DIR__ . '/vendor/autoload.php';

use ResumeX\Client;
use ResumeX\Exceptions\ResumeXException;

// Initialize client
$client = new Client([
    'api_key' => 'rx_pub_your_api_key',
    'api_secret' => 'your_api_secret',
    'environment' => 'production',
]);

// ============================================================================
// Example 1: Update Standard CV (classic, basic, two-column-modern)
// ============================================================================

try {
    $cvId = 'cv_xyz789abc123'; // The CV ID you want to update
    
    $updatedCv = $client->cv()->update($cvId, [
        // Update basic info
        'firstName' => 'NGUYEN VAN',
        'lastName' => 'B',
        'email' => 'updated@example.com',
        'phoneNumber' => '0987-654-321',
        'location' => 'Tokyo, Japan',
        'linkedinUrl' => 'https://linkedin.com/in/newusername',
        'githubUrl' => 'https://github.com/newusername',
        
        // Update professional summary
        'professionalSummary' => 'Senior Full-Stack Engineer with 8+ years of experience...',
        
        // Update work experience (replaces all existing work experience)
        'workExperience' => [
            [
                'company' => 'New Tech Company',
                'position' => 'Lead Engineer',
                'location' => 'Tokyo',
                'date' => 'Jan 2026 - Present',
                'description' => [
                    'Leading a team of 5 engineers',
                    'Architecting microservices using Laravel and NestJS',
                    'Improved system performance by 40%',
                ],
                'technologies' => ['PHP', 'Laravel', 'NestJS', 'React', 'AWS'],
            ],
            [
                'company' => '1Bitlab Technology JSC',
                'position' => 'Senior Software Engineer',
                'location' => 'Tokyo',
                'date' => 'Oct 2020 - Dec 2025',
                'description' => [
                    'Developed and maintained multiple web applications',
                    'Implemented CI/CD pipelines',
                ],
                'technologies' => ['PHP', 'Laravel', 'Vue.js'],
            ],
        ],
        
        // Update education
        'education' => [
            [
                'school' => 'University of Technology',
                'degree' => 'Master of Computer Science',
                'location' => 'Tokyo',
                'date' => 'Sep 2018 - Jun 2020',
            ],
            [
                'school' => 'University of Technology',
                'degree' => 'Bachelor of Computer Science',
                'location' => 'Ho Chi Minh',
                'date' => 'Sep 2013 - Jun 2017',
            ],
        ],
        
        // Update skills
        'skills' => [
            ['category' => 'Backend', 'items' => ['PHP', 'Laravel', 'NestJS', 'Node.js']],
            ['category' => 'Frontend', 'items' => ['React', 'Vue.js', 'TypeScript', 'Next.js']],
            ['category' => 'DevOps', 'items' => ['Docker', 'AWS', 'CI/CD']],
        ],
    ]);
    
    echo "CV updated successfully!\n";
    echo "CV ID: " . $updatedCv['id'] . "\n";
    echo "Updated at: " . $updatedCv['updatedAt'] . "\n";
    
} catch (ResumeXException $e) {
    echo "Error updating CV: " . $e->getMessage() . "\n";
    echo "Error code: " . $e->getErrorCode() . "\n";
    
    if ($e->isValidationError()) {
        print_r($e->getErrors());
    }
}

// ============================================================================
// Example 2: Update Japanese CV (professional-grid template)
// ============================================================================

try {
    $cvId = 'cv_japanese_123'; // The Japanese CV ID you want to update
    
    $updatedCv = $client->cv()->update($cvId, [
        // Update top-level basic info
        'firstName' => '太郎',
        'lastName' => '山田',
        'firstNameKatana' => 'タロウ',
        'lastNameKatana' => 'ヤマダ',
        'email' => 'yamada.taro@example.com',
        'phoneNumber' => '090-1234-5678',
        'postCode' => '100-0002',
        'location' => '東京都千代田区丸の内2-2-2 マンション202',
        
        // Birth date
        'birthYear' => '1990',
        'birthMonth' => '5',
        'birthDay' => '15',
        'gender' => 'male',
        
        // Update profile photo
        'profilePhoto' => 'https://example.com/new-photo.jpg',
        
        // Update Japanese CV specific data
        'webCv' => [
            // Update career history (職歴)
            'careerHistory' => [
                [
                    'date' => '2015年4月',
                    'event' => '○○株式会社 入社',
                ],
                [
                    'date' => '2020年3月',
                    'event' => '○○株式会社 退社',
                ],
                [
                    'date' => '2020年4月',
                    'event' => '△△株式会社 入社（現在に至る）',
                ],
            ],
            
            // Update qualifications (資格)
            'qualificationList' => [
                [
                    'date' => '2018年6月',
                    'qualification_name' => '普通自動車第一種運転免許',
                ],
                [
                    'date' => '2019年12月',
                    'qualification_name' => 'TOEIC 850点',
                ],
                [
                    'date' => '2021年3月',
                    'qualification_name' => '応用情報技術者試験',
                ],
            ],
            
            // Update detailed work experience (職務経歴書)
            'cv_work_experience' => [
                [
                    'company_name' => '△△株式会社',
                    'business_description' => 'Webサービス開発',
                    'capital' => '5000万円',
                    'employee_number' => '100',
                    'classification' => '1',
                    'job_type' => 'システムエンジニア',
                    'job_detail' => 'Laravel/React/AWSを用いたWebアプリケーションの設計・開発・保守',
                    'sales' => '10億円',
                    'retirement' => '0',
                    'affiliation_period_year' => '2020',
                    'affiliation_period_month' => '4',
                    'affiliation_period_day' => '1',
                    'affiliation_period_end_year' => '',
                    'affiliation_period_end_month' => '',
                    'affiliation_period_end_day' => '',
                ],
                [
                    'company_name' => '○○株式会社',
                    'business_description' => 'システム開発',
                    'capital' => '1000万円',
                    'employee_number' => '50',
                    'classification' => '1',
                    'job_type' => 'プログラマー',
                    'job_detail' => 'PHP/MySQLを用いた業務システム開発',
                    'sales' => '3億円',
                    'retirement' => '1',
                    'affiliation_period_year' => '2015',
                    'affiliation_period_month' => '4',
                    'affiliation_period_day' => '1',
                    'affiliation_period_end_year' => '2020',
                    'affiliation_period_end_month' => '3',
                    'affiliation_period_end_day' => '31',
                ],
            ],
            
            // Update text sections
            'applying_info' => '御社の先進的な技術と企業文化に強く魅力を感じ、応募させていただきました...',
            'experience_info' => '私の強みはチームワークとコミュニケーション能力です。前職では...',
            'personal_info' => '趣味は読書と登山です。',
            'cv_job_summary' => 'IT業界で10年以上の経験を持ち、様々なWebアプリケーションの開発に携わってきました...',
            'cv_experience_skill_knowledge' => 'PHP, Laravel, JavaScript, React, AWS, Docker, Git',
            'cv_qualifications_held' => '普通自動車免許、TOEIC 850点、応用情報技術者',
            'cv_self_promotion' => '新しい技術への学習意欲が高く、常にスキルアップを心がけています...',
            
            // Family info
            'spouse' => 1,
            'spouse_support' => 0,
            'commuting_time' => '45分',
        ],
    ]);
    
    echo "Japanese CV updated successfully!\n";
    echo "CV ID: " . $updatedCv['id'] . "\n";
    echo "Updated at: " . $updatedCv['updatedAt'] . "\n";
    
} catch (ResumeXException $e) {
    echo "Error updating Japanese CV: " . $e->getMessage() . "\n";
}

// ============================================================================
// Example 3: Partial Update (only update specific fields)
// ============================================================================

try {
    $cvId = 'cv_xyz789';
    
    // You can update only the fields you need to change
    $updatedCv = $client->cv()->update($cvId, [
        'phoneNumber' => '090-9999-8888',
        'location' => 'Osaka, Japan',
        'professionalSummary' => 'Updated professional summary...',
    ]);
    
    echo "CV partially updated successfully!\n";
    
} catch (ResumeXException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

// ============================================================================
// Example 4: Bidirectional Sync - Update before opening editor
// ============================================================================

try {
    // Step 1: Get candidate data from your system
    $candidate = [
        'id' => 123,
        'first_name' => 'NGUYEN VAN',
        'last_name' => 'C',
        'email' => 'candidate@example.com',
        'phone' => '090-8888-7777',
        'location' => 'Tokyo',
        // ... other fields from your database
    ];
    
    // Step 2: Check if CV exists in candidates_web_cv table
    // (assuming you have a mapping table with cv_id)
    $cvId = 'cv_from_database'; // Get from your candidates_web_cv table
    
    if ($cvId) {
        // Step 3: Update CV with latest data from your system
        $client->cv()->update($cvId, [
            'firstName' => $candidate['first_name'],
            'lastName' => $candidate['last_name'],
            'email' => $candidate['email'],
            'phoneNumber' => $candidate['phone'],
            'location' => $candidate['location'],
            // Map other fields...
        ]);
        
        echo "CV synced successfully! Ready to open editor.\n";
    } else {
        echo "No CV found. Need to generate a new one first.\n";
    }
    
} catch (ResumeXException $e) {
    echo "Sync error: " . $e->getMessage() . "\n";
}
