# ResumeX PHP SDK

Official PHP SDK for ResumeX API - AI-powered CV generation platform.

## ⚠️ Breaking Changes in v2.0.0

**Date field structure has changed for `workExperience`, `education`, `projects`, and `additionalInformation`.**

- **Before**: `'date' => 'Jan 2020 - Present'` (free-text string)
- **After**: Three structured fields:
  - `'startDate' => '2020-01'` (required, format: YYYY-MM or YYYY)
  - `'endDate' => null` (optional, null if ongoing)
  - `'isPresent' => true` (required, true if currently ongoing)

**📖 [Migration Guide](MIGRATION_V2.md)** - Complete guide with examples and helper functions  
**📋 [CHANGELOG](CHANGELOG.md)** - Full list of changes

## Requirements

- PHP 8.1 or higher
- Laravel 10.x or 11.x (for Laravel integration)
- Guzzle HTTP Client

## Installation

### Via Composer (Recommended)

```bash
composer require resumex/sdk
```

### Local Development (from this repository)

Add to your `composer.json`:

```json
{
  "repositories": [
    {
      "type": "path",
      "url": "../packages/resumex-sdk-php"
    }
  ],
  "require": {
    "resumex/sdk": "*"
  }
}
```

Then run:

```bash
composer update resumex/sdk
```

## Configuration

### Laravel Auto-Discovery

The package will automatically register its service provider and facade.

### Publish Config File

```bash
php artisan vendor:publish --tag=resumex-config
```

### Environment Variables

Add to your `.env` file:

```env
RESUMEX_API_KEY=rx_pub_your_api_key
RESUMEX_API_SECRET=your_api_secret
RESUMEX_ENVIRONMENT=production
```

## Usage

### Using the Facade (Recommended for Laravel)

```php
use ResumeX\Facades\ResumeX;

// Generate a CV (Standard templates: classic, basic, two-column-modern)
$cv = ResumeX::cv()->generate([
    'userId' => 'user_123',
    'templateId' => 'classic',
    'email' => 'user@example.com',
    'firstName' => 'NGUYEN VAN',
    'lastName' => 'A',
    'phoneNumber' => '0123-456-789',
    'location' => 'Japan',
    'linkedinUrl' => 'https://linkedin.com/in/username',
    'githubUrl' => 'https://github.com/username',
    'professionalSummary' => 'Senior Software Engineer with 5+ years experience...',
    'workExperience' => [
        [
            'company' => 'ABC Tech Company',
            'position' => 'Senior Software Engineer',
            'location' => 'Tokyo',
            'startDate' => '2020-01',
            'endDate' => null,
            'isPresent' => true,
            'description' => ['Led development of microservices architecture...'],
            'technologies' => ['PHP', 'Laravel', 'React'],
        ],
    ],
    'education' => [
        [
            'school' => 'University of Technology',
            'degree' => 'Bachelor of Computer Science',
            'location' => 'Ho Chi Minh',
            'startDate' => '2013-09',
            'endDate' => '2017-06',
            'isPresent' => false,
        ],
    ],
    'skills' => [
        ['category' => 'Backend', 'items' => ['PHP', 'Laravel', 'Node.js']],
        ['category' => 'Frontend', 'items' => ['React', 'Vue.js', 'TypeScript']],
    ],
    // Optional: Projects
    'projects' => [
        [
            'name' => 'E-commerce Platform',
            'description' => ['Built scalable microservices architecture', 'Handled 10k+ daily transactions'],
            'startDate' => '2024-01',
            'endDate' => '2024-12',
            'isPresent' => false,
            'technologies' => ['Laravel', 'React', 'AWS', 'Docker'],
            'url' => 'https://project-demo.com',
        ],
    ],
    // Optional: Additional Information (Certifications, Awards, Publications, etc.)
    'additionalInformation' => [
        [
            'title' => 'Certifications',
            'items' => [
                [
                    'name' => 'AWS Certified Solutions Architect',
                    'organization' => 'Amazon Web Services',
                    'startDate' => '2024-03',
                    'endDate' => null,
                    'isPresent' => false,
                    'description' => 'Professional level certification',
                ],
                [
                    'name' => 'Laravel Certified Developer',
                    'organization' => 'Laravel',
                    'startDate' => '2023-06',
                    'endDate' => null,
                    'isPresent' => false,
                ],
            ],
        ],
        [
            'title' => 'Publications',
            'items' => [
                [
                    'name' => 'Building Scalable APIs with Laravel',
                    'organization' => 'Medium',
                    'startDate' => '2023-11',
                    'endDate' => null,
                    'isPresent' => false,
                    'description' => 'Technical article with 5k+ views',
                ],
            ],
        ],
    ],
    'preferences' => [
        'language' => 'en',
    ],
]);

// Get the editor URL
$editorUrl = $cv['editorUrl'];

// Redirect user or embed in iframe
return redirect($editorUrl);
```

### Japanese CV (professional-grid template)

For Japanese CVs (履歴書・職務経歴書), use the `professional-grid` template:

```php
use ResumeX\Facades\ResumeX;

$cv = ResumeX::cv()->generate([
    // ============================================
    // Required fields (top-level)
    // ============================================
    'userId' => 'user_123',
    'templateId' => 'professional-grid',
    'email' => 'user@example.com',

    // ============================================
    // Basic Info (top-level for Japanese CV)
    // ============================================
    'firstName' => '太郎',
    'lastName' => '山田',
    'firstNameKatana' => 'タロウ',
    'lastNameKatana' => 'ヤマダ',
    'phoneNumber' => '090-1234-5678',
    'postCode' => '100-0001',
    'location' => '東京都千代田区丸の内1-1-1',

    // Birth Date (split into year, month, day)
    'birthYear' => '1990',
    'birthMonth' => '5',
    'birthDay' => '15',
    'gender' => 'male',   // 'male' | 'female' | 'other'

    // Profile Photo
    'profilePhoto' => 'https://example.com/photo.jpg',

    // ============================================
    // Standard CV sections (if you have them)
    // ============================================
    'workExperience' => [
        [
            'company' => '株式会社ABC',
            'position' => 'システムエンジニア',
            'location' => '東京',
            'startDate' => '2020-04',
            'endDate' => null,
            'isPresent' => true,
            'description' => ['Webアプリケーションの設計・開発'],
            'technologies' => ['PHP', 'Laravel', 'React'],
        ],
    ],
    'education' => [
        [
            'school' => '東京大学',
            'degree' => '学士',
            'field' => '情報工学',
            'location' => '東京',
            'startDate' => '2012-04',
            'endDate' => '2016-03',
            'isPresent' => false,
            'gpa' => '',
            'achievements' => [],
        ],
    ],
    'skills' => [],

    // ============================================
    // Japanese CV specific fields (webCv)
    // ============================================
    'webCv' => [
        // Qualifications list (資格一覧)
        'qualificationList' => [
            ['date' => '2018年6月', 'qualification_name' => '普通自動車第一種運転免許'],
            ['date' => '2019年12月', 'qualification_name' => 'TOEIC 850点'],
        ],

        // Detailed work experience for 職務経歴書
        'cv_work_experience' => [
            [
                'company_name' => '株式会社○○',
                'business_description' => 'Webサービス開発',
                'capital' => '1000万円',
                'employee_number' => '50',
                'classification' => '1',  // 1=正社員
                'job_type' => 'エンジニア',
                'job_detail' => 'システム開発・保守',
                'sales' => '5億円',
                'retirement' => '0',  // 0=在職中, 1=退職済み
                'affiliation_period_year' => '2020',
                'affiliation_period_month' => '4',
                'affiliation_period_day' => '1',
                'affiliation_period_end_year' => '',
                'affiliation_period_end_month' => '',
                'affiliation_period_end_day' => '',
            ],
        ],

        // Japanese CV text sections
        'applying_info' => '御社の先進的な技術と企業文化に魅力を感じ...',
        'experience_info' => '私の強みはチームワークとコミュニケーション能力です...',
        'personal_info' => '特になし',
        'cv_job_summary' => 'IT業界で10年以上の経験を持つエンジニア',
        'cv_experience_skill_knowledge' => 'PHP, Laravel, React, AWS',
        'cv_qualifications_held' => '普通自動車免許、TOEIC 850点',
        'cv_self_promotion' => '新しい技術への学習意欲が高く...',

        // Family info
        'spouse' => 1,  // 0=なし, 1=あり
        'spouse_support' => 0,  // 0=なし, 1=あり
        'commuting_time' => '45分',
    ],

    'preferences' => [
        'language' => 'ja',
    ],
]);
```

### Field Reference

#### Required Fields (All Templates)

| Field        | Type   | Description                                                     |
| ------------ | ------ | --------------------------------------------------------------- |
| `userId`     | string | Unique user ID in your system                                   |
| `templateId` | string | `classic`, `basic`, `two-column-modern`, or `professional-grid` |
| `email`      | string | User's email address                                            |

#### Standard CV Fields (classic, basic, two-column-modern)

| Field                 | Type   | Description                |
| --------------------- | ------ | -------------------------- |
| `firstName`           | string | First name                 |
| `lastName`            | string | Last name                  |
| `phoneNumber`         | string | Phone number               |
| `location`            | string | City/Country               |
| `linkedinUrl`         | string | LinkedIn profile URL       |
| `githubUrl`           | string | GitHub profile URL         |
| `portfolioUrl`        | string | Portfolio URL              |
| `professionalSummary` | string | Summary or objective       |
| `workExperience`      | array  | Work experience entries    |
| `education`           | array  | Education entries          |
| `skills`              | array  | Skills grouped by category |
| `certifications`      | array  | Certifications list        |
| `projects`            | array  | Project entries            |
| `awards`              | array  | Awards and achievements    |

#### Date Field Structure (workExperience, education, projects, additionalInformation)

All array items in `workExperience`, `education`, `projects`, and `additionalInformation` now use this structured date format:

| Field       | Type         | Required | Description                                         | Example               |
| ----------- | ------------ | -------- | --------------------------------------------------- | --------------------- |
| `startDate` | string       | Yes      | Start date in YYYY-MM or YYYY format                | `'2020-01'`           |
| `endDate`   | string\|null | No       | End date in YYYY-MM or YYYY format, null if current | `'2023-12'` or `null` |
| `isPresent` | boolean      | Yes      | true if currently ongoing, false otherwise          | `true` or `false`     |

**Examples:**

```php
// Current position
[
    'company' => 'ABC Corp',
    'position' => 'Senior Engineer',
    'startDate' => '2020-01',
    'endDate' => null,
    'isPresent' => true,
    // ...
}

// Past position
[
    'company' => 'XYZ Inc',
    'position' => 'Engineer',
    'startDate' => '2018-03',
    'endDate' => '2019-12',
    'isPresent' => false,
    // ...
]

// Education (completed)
[
    'school' => 'University of Tokyo',
    'degree' => 'Bachelor of Science',
    'startDate' => '2014-04',
    'endDate' => '2018-03',
    'isPresent' => false,
    // ...
]

// Project (ongoing)
[
    'name' => 'E-commerce Platform',
    'startDate' => '2025-06',
    'endDate' => null,
    'isPresent' => true,
    'description' => ['Building scalable platform...'],
    // ...
]
```

#### Japanese CV Fields (professional-grid)

**Top-level fields:**

| Field              | Type   | Description                     |
| ------------------ | ------ | ------------------------------- |
| `firstName`        | string | 名 (First name in kanji)        |
| `lastName`         | string | 姓 (Last name in kanji)         |
| `firstNameKatana`  | string | ふりがな (First name reading)   |
| `lastNameKatana`   | string | ふりがな (Last name reading)    |
| `phoneNumber`      | string | 電話番号                        |
| `postCode`         | string | 郵便番号                        |
| `location`         | string | 住所 (Full address)             |
| `birthYear`        | string | 生年月日 - 年                   |
| `birthMonth`       | string | 生年月日 - 月                   |
| `birthDay`         | string | 生年月日 - 日                   |
| `gender`           | string | 性別: `male`, `female`, `other` |
| `profilePhoto`     | string | Photo URL                       |
| `workExperience[]` | array  | 職歴 (simple format for 履歴書) |
| `education[]`      | array  | 学歴 (simple format for 履歴書) |

**webCv object (Japanese-specific fields):**

| Field                                                 | Type   | Description                          |
| ----------------------------------------------------- | ------ | ------------------------------------ |
| `webCv.qualificationList[]`                           | array  | 資格一覧 (Licenses & Qualifications) |
| `webCv.qualificationList[].date`                      | string | 取得年月 (e.g., "2018年6月")         |
| `webCv.qualificationList[].qualification_name`        | string | 資格名                               |
| `webCv.cv_work_experience[]`                          | array  | 職務経歴詳細 (Detailed work history) |
| `webCv.cv_work_experience[].company_name`             | string | 会社名                               |
| `webCv.cv_work_experience[].business_description`     | string | 事業内容                             |
| `webCv.cv_work_experience[].capital`                  | string | 資本金                               |
| `webCv.cv_work_experience[].employee_number`          | string | 従業員数                             |
| `webCv.cv_work_experience[].classification`           | string | 雇用形態 (1=正社員, etc.)            |
| `webCv.cv_work_experience[].job_type`                 | string | 職種                                 |
| `webCv.cv_work_experience[].job_detail`               | string | 職務内容                             |
| `webCv.cv_work_experience[].sales`                    | string | 売上高                               |
| `webCv.cv_work_experience[].retirement`               | string | 0=在職中, 1=退職済み                 |
| `webCv.cv_work_experience[].affiliation_period_year`  | string | 入社年                               |
| `webCv.cv_work_experience[].affiliation_period_month` | string | 入社月                               |
| `webCv.cv_work_experience[].affiliation_period_day`   | string | 入社日                               |
| `webCv.applying_info`                                 | string | 志望動機                             |
| `webCv.experience_info`                               | string | 自己PR・特技・長所など               |
| `webCv.personal_info`                                 | string | 本人希望記入欄                       |
| `webCv.cv_job_summary`                                | string | 職務要約                             |
| `webCv.cv_experience_skill_knowledge`                 | string | 活かせる経験・スキル・知識           |
| `webCv.cv_qualifications_held`                        | string | 保有資格                             |
| `webCv.cv_self_promotion`                             | string | 自己PR                               |
| `webCv.spouse`                                        | int    | 配偶者: 0=なし, 1=あり               |
| `webCv.spouse_support`                                | int    | 配偶者の扶養義務: 0=なし, 1=あり     |
| `webCv.commuting_time`                                | string | 通勤時間                             |

### Using Dependency Injection

```php
use ResumeX\Client;

class CVController extends Controller
{
    public function __construct(
        protected Client $resumex
    ) {}

    public function generate(Request $request)
    {
        $cv = $this->resumex->cv()->generate([
            'userId' => (string) $request->user()->id,
            'templateId' => $request->input('templateId', 'classic'),
            'email' => $request->user()->email,
            'firstName' => $request->input('firstName'),
            'lastName' => $request->input('lastName'),
            'workExperience' => $request->input('workExperience', []),
            // ...
        ]);

        return response()->json([
            'cvId' => $cv['cvId'],
            'editorUrl' => $cv['editorUrl'],
        ]);
    }
}
```

### Standalone Usage (Without Laravel)

```php
use ResumeX\Client;

$client = new Client([
    'api_key' => 'rx_pub_your_api_key',
    'api_secret' => 'your_api_secret',
    'environment' => 'production', // or 'sandbox'
]);

// Generate CV
$cv = $client->cv()->generate([...]);

// Get CV details
$cvDetails = $client->cv()->get($cv['cvId']);

// Get quota
$quota = $client->partner()->getQuota();
```

## API Reference

### CV Resource

```php
// Generate new CV
$cv = ResumeX::cv()->generate([...]);

// Get CV details
$cv = ResumeX::cv()->get('cv_xyz789');

// Update existing CV (same structure as generate())
$updatedCv = ResumeX::cv()->update('cv_xyz789', [
    'firstName' => 'NGUYEN VAN',
    'lastName' => 'B',
    'phoneNumber' => '0987-654-321',
    'location' => 'Tokyo, Japan',
    'professionalSummary' => 'Updated summary...',
    'workExperience' => [
        [
            'company' => 'New Company',
            'position' => 'Lead Engineer',
            'location' => 'Tokyo',
            'startDate' => '2026-01',
            'endDate' => null,
            'isPresent' => true,
            'description' => ['Leading team of 5...'],
        ],
    ],
    // Or for Japanese CV:
    'webCv' => [
        'lastName' => '山田',
        'firstName' => '太郎',
        'careerHistory' => [
            ['date' => '2015年4月', 'event' => '○○株式会社 入社'],
            ['date' => '2020年3月', 'event' => '○○株式会社 退社'],
        ],
        'selfPr' => '更新された自己PR...',
    ],
]);

// Enhance CV with AI
$enhanced = ResumeX::cv()->enhance('cv_xyz789', [
    'sections' => ['summary', 'experience'],
    'tone' => 'professional',
    'atsOptimization' => true,
]);

// Delete CV
ResumeX::cv()->delete('cv_xyz789');
```

### Partner Resource

```php
// Get quota information
$quota = ResumeX::partner()->getQuota();

// Get usage statistics
$usage = ResumeX::partner()->getUsage('current_month');

// Get analytics dashboard
$dashboard = ResumeX::partner()->getDashboard('last_30_days');
```

### Templates Resource

```php
// List all templates
$templates = ResumeX::templates()->list([
    'category' => 'tech',
    'language' => 'vi',
]);

// Get template details
$template = ResumeX::templates()->get('modern-01');
```

## Error Handling

```php
use ResumeX\Exceptions\ResumeXException;
use ResumeX\Facades\ResumeX;

try {
    $cv = ResumeX::cv()->generate([...]);
} catch (ResumeXException $e) {
    // Get error details
    $message = $e->getMessage();
    $errorCode = $e->getErrorCode();
    $statusCode = $e->getStatusCode();

    // Check error type
    if ($e->isRateLimitError()) {
        // Handle rate limiting - wait and retry
    } elseif ($e->isAuthenticationError()) {
        // Invalid API credentials
    } elseif ($e->isValidationError()) {
        // Get validation errors
        $errors = $e->getErrors();
    }

    Log::error('ResumeX API Error', [
        'message' => $message,
        'code' => $errorCode,
        'status' => $statusCode,
    ]);
}
```

## Complete Integration Example

### Controller

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use ResumeX\Facades\ResumeX;
use ResumeX\Exceptions\ResumeXException;

class ResumeController extends Controller
{
    public function create(Request $request)
    {
        $validated = $request->validate([
            'firstName' => 'required|string|max:50',
            'lastName' => 'required|string|max:50',
            'email' => 'required|email',
            'phoneNumber' => 'nullable|string',
            'templateId' => 'required|string|in:classic,basic,two-column-modern,professional-grid',
            'workExperience' => 'array',
            'education' => 'array',
            'skills' => 'array',
        ]);

        try {
            $payload = [
                'userId' => (string) $request->user()->id,
                'templateId' => $validated['templateId'],
                'email' => $validated['email'],
                'firstName' => $validated['firstName'],
                'lastName' => $validated['lastName'],
                'phoneNumber' => $validated['phoneNumber'] ?? '',
                'workExperience' => $validated['workExperience'] ?? [],
                'education' => $validated['education'] ?? [],
                'skills' => $validated['skills'] ?? [],
                'preferences' => [
                    'language' => 'en',
                ],
            ];

            $cv = ResumeX::cv()->generate($payload);

            return response()->json([
                'success' => true,
                'cvId' => $cv['cvId'],
                'editorUrl' => $cv['editorUrl'],
            ]);

        } catch (ResumeXException $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
                'errorCode' => $e->getErrorCode(),
            ], $e->getStatusCode() ?? 500);
        }
    }

    /**
     * Create Japanese CV (履歴書)
     */
    public function createJapaneseCv(Request $request)
    {
        $validated = $request->validate([
            'lastName' => 'required|string',
            'firstName' => 'required|string',
            'lastNameFurigana' => 'nullable|string',
            'firstNameFurigana' => 'nullable|string',
            'birthDate' => 'nullable|date',
            'email' => 'required|email',
            'phone' => 'nullable|string',
        ]);

        try {
            $cv = ResumeX::cv()->generate([
                'userId' => (string) $request->user()->id,
                'templateId' => 'professional-grid',
                'email' => $validated['email'],
                'webCv' => [
                    'lastName' => $validated['lastName'],
                    'firstName' => $validated['firstName'],
                    'lastNameFurigana' => $validated['lastNameFurigana'] ?? '',
                    'firstNameFurigana' => $validated['firstNameFurigana'] ?? '',
                    'birthDate' => $validated['birthDate'] ?? '',
                    'email' => $validated['email'],
                    'phone' => $validated['phone'] ?? '',
                    // Add more fields as needed
                ],
                'preferences' => [
                    'language' => 'ja',
                ],
            ]);

            return response()->json([
                'success' => true,
                'cvId' => $cv['cvId'],
                'editorUrl' => $cv['editorUrl'],
            ]);

        } catch (ResumeXException $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
                'errorCode' => $e->getErrorCode(),
            ], $e->getStatusCode() ?? 500);
        }
    }

    public function quota()
    {
        $quota = ResumeX::partner()->getQuota();

        return response()->json([
            'tier' => $quota['tier'],
            'used' => $quota['used'],
            'remaining' => $quota['remaining'],
            'resetDate' => $quota['resetDate'],
        ]);
    }
}
```

### Routes

```php
// routes/api.php
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/resume/create', [ResumeController::class, 'create']);
    Route::get('/resume/quota', [ResumeController::class, 'quota']);
});
```

### Frontend Integration (Blade/Inertia)

```html
<!-- Embed CV Editor in iframe -->
<iframe
  src="{{ $editorUrl }}"
  width="100%"
  height="800px"
  frameborder="0"
  allow="clipboard-write"
></iframe>

<!-- Or redirect to editor -->
<script>
  window.location.href = "{{ $editorUrl }}";
</script>
```

## Testing

### Sandbox Environment

Use sandbox mode for testing:

```env
RESUMEX_ENVIRONMENT=sandbox
```

Or per-request:

```php
$client = new Client([
    'api_key' => 'rx_test_sandbox_key',
    'api_secret' => 'sandbox_secret',
    'environment' => 'sandbox',
]);
```

### Mock in Tests

```php
use ResumeX\Facades\ResumeX;

public function test_cv_generation()
{
    ResumeX::shouldReceive('cv->generate')
        ->once()
        ->with(\Mockery::type('array'))
        ->andReturn([
            'cvId' => 'cv_test_123',
            'editorUrl' => 'https://app.resumex.com/resumes/cv_test_123?token=xxx',
        ]);

    $response = $this->postJson('/api/resume/create', [
        'fullName' => 'Test User',
        'email' => 'test@example.com',
        'phone' => '+84912345678',
    ]);

    $response->assertStatus(200)
        ->assertJsonPath('cvId', 'cv_test_123');
}
```

## Support

- **Documentation**: https://docs.resumex.com
- **Partner Dashboard**: https://partners.resumex.com
- **Support Email**: support@resumex.com
- **GitHub Issues**: https://github.com/resumex/sdk-php/issues

## License

MIT License. See [LICENSE](LICENSE) for details.
