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

// Generate a CV
$cv = ResumeX::cv()->generate([
    'userId' => 'user_123',
    'personalInfo' => [
        'fullName' => 'Nguyen Van A',
        'email' => 'user@example.com',
        'phone' => '+84912345678',
        'address' => [
            'city' => 'Ho Chi Minh',
            'country' => 'Vietnam',
        ],
    ],
    'experience' => [
        [
            'company' => 'ABC Tech Company',
            'position' => 'Senior Software Engineer',
            'startDate' => '2020-01',
            'endDate' => null,
            'isCurrent' => true,
            'description' => 'Led development of microservices architecture...',
            'achievements' => [
                'Reduced system latency by 40%',
                'Mentored 5 junior developers',
            ],
        ],
    ],
    'education' => [
        [
            'institution' => 'University of Technology',
            'degree' => 'Bachelor of Computer Science',
            'startDate' => '2013-09',
            'endDate' => '2017-06',
        ],
    ],
    'skills' => [
        'technical' => ['PHP', 'Laravel', 'JavaScript', 'React', 'MySQL'],
        'soft' => ['Team Leadership', 'Communication'],
        'languages' => [
            ['name' => 'Vietnamese', 'level' => 'native'],
            ['name' => 'English', 'level' => 'fluent'],
        ],
    ],
    'preferences' => [
        'language' => 'vi',
        'templateId' => 'modern-01',
        'colorScheme' => 'blue',
    ],
]);

// Get the editor URL
$editorUrl = $cv['editorUrl'];

// Redirect user or embed in iframe
return redirect($editorUrl);
```

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
            'userId' => $request->user()->id,
            'personalInfo' => $request->input('personalInfo'),
            'experience' => $request->input('experience'),
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
            'fullName' => 'required|string|max:100',
            'email' => 'required|email',
            'phone' => 'required|string',
            'experience' => 'array',
            'education' => 'array',
            'skills' => 'array',
            'templateId' => 'string',
        ]);

        try {
            $cv = ResumeX::cv()->generate([
                'userId' => (string) $request->user()->id,
                'idempotencyKey' => uniqid('cv_', true),
                'personalInfo' => [
                    'fullName' => $validated['fullName'],
                    'email' => $validated['email'],
                    'phone' => $validated['phone'],
                ],
                'experience' => $validated['experience'] ?? [],
                'education' => $validated['education'] ?? [],
                'skills' => $validated['skills'] ?? [],
                'preferences' => [
                    'language' => 'vi',
                    'templateId' => $validated['templateId'] ?? 'modern-01',
                ],
                'metadata' => [
                    'source' => 'kyujin_platform',
                    'referenceId' => $request->input('job_id'),
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
