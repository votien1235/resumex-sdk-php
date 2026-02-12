# ResumeX PHP SDK

Official PHP SDK for ResumeX API - AI-powered CV generation platform.

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
            'date' => 'Jan 2020 - Present',
            'description' => ['Led development of microservices architecture...'],
            'technologies' => ['PHP', 'Laravel', 'React'],
        ],
    ],
    'education' => [
        [
            'school' => 'University of Technology',
            'degree' => 'Bachelor of Computer Science',
            'location' => 'Ho Chi Minh',
            'date' => 'Sep 2013 - Jun 2017',
        ],
    ],
    'skills' => [
        ['category' => 'Backend', 'items' => ['PHP', 'Laravel', 'Node.js']],
        ['category' => 'Frontend', 'items' => ['React', 'Vue.js', 'TypeScript']],
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

For Japanese CVs (履歴書), use the `professional-grid` template with `webCv` field:

```php
use ResumeX\Facades\ResumeX;

$cv = ResumeX::cv()->generate([
    // Required fields
    'userId' => 'user_123',
    'templateId' => 'professional-grid',
    'email' => 'user@example.com',

    // Japanese CV specific fields
    'webCv' => [
        // Basic Info
        'lastName' => '山田',
        'firstName' => '太郎',
        'lastNameFurigana' => 'ヤマダ',
        'firstNameFurigana' => 'タロウ',
        'birthDate' => '1990-05-15',
        'gender' => 'male',   // 'male' | 'female' | 'other'
        'email' => 'user@example.com',
        'phone' => '090-1234-5678',

        // Address
        'postalCode' => '100-0001',
        'prefecture' => '東京都',
        'city' => '千代田区',
        'address' => '丸の内1-1-1',
        'building' => 'ビル名101',

        // Photo (optional)
        'photoUrl' => 'https://example.com/photo.jpg',
        // or use base64: 'photoBase64' => 'data:image/jpeg;base64,...',

        // Career History
        'careerHistory' => [
            ['date' => '2015年4月', 'event' => '○○株式会社 入社'],
            ['date' => '2020年3月', 'event' => '○○株式会社 退社'],
            ['date' => '2020年4月', 'event' => '△△株式会社 入社'],
        ],

        // Licenses & Qualifications
        'licenses' => [
            ['date' => '2018年6月', 'name' => '普通自動車第一種運転免許'],
            ['date' => '2019年12月', 'name' => 'TOEIC 850点'],
        ],

        // Self PR & Motivation
        'selfPr' => '私の強みはチームワークとコミュニケーション能力です...',
        'motivation' => '御社の先進的な技術と企業文化に魅力を感じ...',

        // Commute & Dependents
        'commuteTime' => '45分',
        'dependents' => '2人',
        'spouse' => 'あり',
        'spouseSupportObligation' => 'なし',

        // Preferences
        'desiredSalary' => '500万円',
        'specialSkills' => 'TOEIC 850点、英語での業務経験あり',
        'requests' => '特になし',
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

#### Japanese CV Fields (professional-grid)

| Field                           | Type   | Description                     |
| ------------------------------- | ------ | ------------------------------- |
| `webCv.lastName`                | string | 姓 (Last name in kanji)         |
| `webCv.firstName`               | string | 名 (First name in kanji)        |
| `webCv.lastNameFurigana`        | string | ふりがな (Last name reading)    |
| `webCv.firstNameFurigana`       | string | ふりがな (First name reading)   |
| `webCv.birthDate`               | string | 生年月日 (YYYY-MM-DD format)    |
| `webCv.gender`                  | string | 性別: `male`, `female`, `other` |
| `webCv.email`                   | string | メールアドレス                  |
| `webCv.phone`                   | string | 電話番号                        |
| `webCv.postalCode`              | string | 郵便番号                        |
| `webCv.prefecture`              | string | 都道府県                        |
| `webCv.city`                    | string | 市区町村                        |
| `webCv.address`                 | string | 番地                            |
| `webCv.building`                | string | 建物名                          |
| `webCv.photoUrl`                | string | Photo URL                       |
| `webCv.photoBase64`             | string | Photo as base64 data URI        |
| `webCv.careerHistory`           | array  | 学歴・職歴                      |
| `webCv.licenses`                | array  | 免許・資格                      |
| `webCv.selfPr`                  | string | 自己PR                          |
| `webCv.motivation`              | string | 志望動機                        |
| `webCv.commuteTime`             | string | 通勤時間                        |
| `webCv.dependents`              | string | 扶養家族数                      |
| `webCv.spouse`                  | string | 配偶者: `あり` or `なし`        |
| `webCv.spouseSupportObligation` | string | 配偶者の扶養義務                |
| `webCv.desiredSalary`           | string | 希望給与                        |
| `webCv.specialSkills`           | string | 特技・趣味                      |
| `webCv.requests`                | string | 本人希望欄                      |

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
