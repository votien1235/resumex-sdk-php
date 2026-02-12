# ResumeX SDK - Quick Reference: Update CV API

## 🚀 Quick Start

```php
use ResumeX\Facades\ResumeX;

// Update CV
$updatedCv = ResumeX::cv()->update('cv_xyz789', [
    'firstName' => 'NGUYEN VAN',
    'lastName' => 'B',
    'phoneNumber' => '090-1234-5678',
]);
```

---

## 📖 Method Signature

```php
public function update(string $cvId, array $data): array
```

**Parameters:**
- `$cvId` (string) - The CV ID to update (e.g., `cv_xyz789abc123`)
- `$data` (array) - CV data to update (same structure as `generate()`)

**Returns:**
- `array` - Updated CV details including `id`, `userId`, `updatedAt`, etc.

**Throws:**
- `ResumeXException` - On validation errors, authentication errors, or API errors

---

## 📋 Common Use Cases

### 1. Update Basic Info Only

```php
ResumeX::cv()->update($cvId, [
    'firstName' => 'John',
    'lastName' => 'Doe',
    'email' => 'john@example.com',
    'phoneNumber' => '090-1111-2222',
    'location' => 'Tokyo, Japan',
]);
```

### 2. Update Work Experience

```php
ResumeX::cv()->update($cvId, [
    'workExperience' => [
        [
            'company' => 'New Company',
            'position' => 'Senior Engineer',
            'location' => 'Tokyo',
            'date' => 'Jan 2026 - Present',
            'description' => ['Leading team of 5 engineers'],
            'technologies' => ['PHP', 'Laravel', 'React'],
        ],
    ],
]);
```

### 3. Update Professional Summary

```php
ResumeX::cv()->update($cvId, [
    'professionalSummary' => 'Senior Full-Stack Engineer with 8+ years of experience...',
]);
```

### 4. Update Japanese CV

```php
ResumeX::cv()->update($cvId, [
    'firstName' => '太郎',
    'lastName' => '山田',
    'webCv' => [
        'careerHistory' => [
            ['date' => '2015年4月', 'event' => '○○株式会社 入社'],
        ],
        'selfPr' => '私の強みは...',
    ],
]);
```

---

## 🔄 Bidirectional Sync Pattern

### Laravel Controller Example

```php
use ResumeX\Facades\ResumeX;
use ResumeX\Exceptions\ResumeXException;

class MyPageWebResumeController extends Controller
{
    public function openEditor($candidateId)
    {
        // 1. Get candidate from database
        $candidate = Candidate::findOrFail($candidateId);
        
        // 2. Get CV mapping
        $webCv = CandidatesWebCv::where('candidate_id', $candidateId)->first();
        
        if (!$webCv || !$webCv->resumex_cv_id) {
            // No CV yet, need to generate first
            return $this->generateNewCV($candidate);
        }
        
        try {
            // 3. Sync latest data to ResumeX BEFORE opening editor
            ResumeX::cv()->update($webCv->resumex_cv_id, [
                'firstName' => $candidate->first_name_en,
                'lastName' => $candidate->last_name_en,
                'email' => $candidate->email,
                'phoneNumber' => $candidate->phone,
                'location' => $candidate->location,
                'professionalSummary' => $candidate->summary,
                // Map other fields...
            ]);
            
            // 4. Get fresh editor URL with synced data
            $cv = ResumeX::cv()->get($webCv->resumex_cv_id);
            
            // 5. Redirect to editor
            return redirect($cv['editorUrl']);
            
        } catch (ResumeXException $e) {
            Log::error('Failed to sync CV to ResumeX', [
                'cv_id' => $webCv->resumex_cv_id,
                'error' => $e->getMessage(),
            ]);
            
            // Fallback: still open editor with old data
            $cv = ResumeX::cv()->get($webCv->resumex_cv_id);
            return redirect($cv['editorUrl']);
        }
    }
}
```

---

## 🎯 Field Mapping Reference

### Standard CV Fields

| Your Database Field | ResumeX Field         | Type   |
| ------------------- | --------------------- | ------ |
| `first_name_en`     | `firstName`           | string |
| `last_name_en`      | `lastName`            | string |
| `email`             | `email`               | string |
| `phone`             | `phoneNumber`         | string |
| `location`          | `location`            | string |
| `linkedin_url`      | `linkedinUrl`         | string |
| `github_url`        | `githubUrl`           | string |
| `summary`           | `professionalSummary` | string |

### Japanese CV Fields (Top-Level)

| Your Database Field | ResumeX Field       | Type   |
| ------------------- | ------------------- | ------ |
| `first_name_ja`     | `firstName`         | string |
| `last_name_ja`      | `lastName`          | string |
| `first_name_kana`   | `firstNameKatana`   | string |
| `last_name_kana`    | `lastNameKatana`    | string |
| `birth_year`        | `birthYear`         | string |
| `birth_month`       | `birthMonth`        | string |
| `birth_day`         | `birthDay`          | string |
| `gender`            | `gender`            | string |
| `postal_code`       | `postCode`          | string |
| `phone`             | `phoneNumber`       | string |
| `email`             | `email`             | string |
| `location`          | `location`          | string |
| `profile_photo_url` | `profilePhoto`      | string |

### Japanese CV Fields (webCv)

| Your Database Field | ResumeX Field (webCv)      | Type  |
| ------------------- | -------------------------- | ----- |
| Career history      | `careerHistory`            | array |
| Licenses            | `qualificationList`        | array |
| Detailed experience | `cv_work_experience`       | array |
| Motivation          | `applying_info`            | text  |
| Experience info     | `experience_info`          | text  |
| Personal info       | `personal_info`            | text  |
| Job summary         | `cv_job_summary`           | text  |
| Skills              | `cv_experience_skill_knowledge` | text  |
| Qualifications      | `cv_qualifications_held`   | text  |
| Self PR             | `cv_self_promotion`        | text  |
| Spouse              | `spouse`                   | int   |
| Spouse support      | `spouse_support`           | int   |
| Commute time        | `commuting_time`           | text  |

---

## ⚠️ Error Handling

```php
use ResumeX\Exceptions\ResumeXException;

try {
    $updatedCv = ResumeX::cv()->update($cvId, $data);
    
} catch (ResumeXException $e) {
    // Check error type
    if ($e->isValidationError()) {
        // Invalid data format
        $errors = $e->getErrors(); // Get detailed validation errors
        
    } elseif ($e->isAuthenticationError()) {
        // Invalid API credentials
        Log::error('ResumeX authentication failed');
        
    } elseif ($e->isRateLimitError()) {
        // Rate limit exceeded - wait and retry
        sleep(60);
        
    } else {
        // Other errors (network, server, etc.)
        Log::error('ResumeX API error', [
            'message' => $e->getMessage(),
            'code' => $e->getErrorCode(),
            'status' => $e->getStatusCode(),
        ]);
    }
}
```

---

## ✅ Response Format

### Success Response

```php
[
    'id' => 'cv_xyz789abc123',
    'userId' => 'user_123',
    'templateId' => 'classic',
    'firstName' => 'NGUYEN VAN',
    'lastName' => 'B',
    'email' => 'user@example.com',
    'phoneNumber' => '090-1234-5678',
    'location' => 'Tokyo, Japan',
    'professionalSummary' => 'Updated summary...',
    'workExperience' => [...],
    'education' => [...],
    'skills' => [...],
    'webCv' => [...], // For Japanese CVs
    'updatedAt' => '2026-03-12T11:00:00Z',
    'createdAt' => '2026-03-01T10:00:00Z',
]
```

---

## 🔍 Debugging

### Enable Debug Logging

```php
// config/resumex.php
return [
    'debug' => env('RESUMEX_DEBUG', false),
];

// .env
RESUMEX_DEBUG=true
```

### Check Request/Response

```php
try {
    $updatedCv = ResumeX::cv()->update($cvId, $data);
    
} catch (ResumeXException $e) {
    // Log the request that failed
    Log::debug('ResumeX update request', [
        'cv_id' => $cvId,
        'data' => $data,
        'error' => $e->getMessage(),
        'status' => $e->getStatusCode(),
    ]);
}
```

---

## 📚 Related Documentation

- **Full SDK README:** `packages/resumex-sdk-php/README.md`
- **Complete Examples:** `packages/resumex-sdk-php/examples/update-cv.php`
- **Implementation Guide:** `RESUMEX_SDK_PATCH_API_COMPLETE.md`
- **Bidirectional Sync Plan:** `SIMPLE_BIDIRECTIONAL_SYNC.md`

---

## 🆘 Common Issues

### Issue: "CV not found"
**Solution:** Check that `resumex_cv_id` exists in `candidates_web_cv` table

```php
$webCv = CandidatesWebCv::where('candidate_id', $candidateId)->first();
if (!$webCv || !$webCv->resumex_cv_id) {
    // Need to generate CV first
    $cv = ResumeX::cv()->generate([...]);
    
    // Save CV ID
    $webCv->resumex_cv_id = $cv['cvId'];
    $webCv->save();
}
```

### Issue: "Authentication failed"
**Solution:** Check API credentials in `.env`

```env
RESUMEX_API_KEY=rx_pub_your_api_key
RESUMEX_API_SECRET=your_api_secret
RESUMEX_ENVIRONMENT=production
```

### Issue: "Validation error"
**Solution:** Check field names and data types

```php
catch (ResumeXException $e) {
    if ($e->isValidationError()) {
        $errors = $e->getErrors();
        foreach ($errors as $field => $messages) {
            echo "$field: " . implode(', ', $messages) . "\n";
        }
    }
}
```

---

## 💡 Pro Tips

1. **Always sync before opening editor** - Ensures user sees latest data
2. **Use partial updates** - Only send changed fields to save bandwidth
3. **Handle errors gracefully** - Don't block user from opening editor if sync fails
4. **Log sync operations** - Helps debugging sync issues
5. **Cache CV ID** - Store `resumex_cv_id` in your database for fast lookups

---

**Last Updated:** March 12, 2026  
**SDK Version:** 1.2.0+
