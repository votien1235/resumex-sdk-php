# Migration Guide: v1.x to v2.0

## Breaking Changes

Version 2.0 introduces a **breaking change** in how dates are structured for work experience, education, projects, and additional information fields.

### What Changed?

The old free-text `date` field has been replaced with three structured fields:

- `startDate` (string, required) - Format: `YYYY-MM` or `YYYY`
- `endDate` (string|null, optional) - Format: `YYYY-MM` or `YYYY`, `null` if currently ongoing
- `isPresent` (boolean, required) - `true` if currently ongoing, `false` otherwise

### Why This Change?

✅ **Consistent format** - No more parsing various date formats  
✅ **Better sorting** - Easy to sort by start/end dates  
✅ **Clear status** - `isPresent` clearly indicates current positions  
✅ **Duration calculations** - Easy to calculate time periods  
✅ **ATS-friendly** - Structured data for better parsing

---

## Migration Steps

### Step 1: Update Work Experience

**Before (v1.x):**

```php
'workExperience' => [
    [
        'company' => 'ABC Corporation',
        'position' => 'Senior Engineer',
        'location' => 'Tokyo',
        'date' => 'Jan 2020 - Present',
        'description' => ['Led development team...'],
        'technologies' => ['PHP', 'Laravel'],
    ],
    [
        'company' => 'XYZ Inc',
        'position' => 'Engineer',
        'location' => 'Tokyo',
        'date' => 'Mar 2018 - Dec 2019',
        'description' => ['Developed web applications...'],
        'technologies' => ['JavaScript', 'React'],
    ],
],
```

**After (v2.0):**

```php
'workExperience' => [
    [
        'company' => 'ABC Corporation',
        'position' => 'Senior Engineer',
        'location' => 'Tokyo',
        'startDate' => '2020-01',
        'endDate' => null,
        'isPresent' => true,
        'description' => ['Led development team...'],
        'technologies' => ['PHP', 'Laravel'],
    ],
    [
        'company' => 'XYZ Inc',
        'position' => 'Engineer',
        'location' => 'Tokyo',
        'startDate' => '2018-03',
        'endDate' => '2019-12',
        'isPresent' => false,
        'description' => ['Developed web applications...'],
        'technologies' => ['JavaScript', 'React'],
    ],
],
```

### Step 2: Update Education

**Before (v1.x):**

```php
'education' => [
    [
        'school' => 'University of Tokyo',
        'degree' => 'Bachelor of Computer Science',
        'location' => 'Tokyo',
        'date' => 'Apr 2014 - Mar 2018',
        'gpa' => '3.8',
    ],
],
```

**After (v2.0):**

```php
'education' => [
    [
        'school' => 'University of Tokyo',
        'degree' => 'Bachelor of Computer Science',
        'location' => 'Tokyo',
        'startDate' => '2014-04',
        'endDate' => '2018-03',
        'isPresent' => false,
        'gpa' => '3.8',
    ],
],
```

### Step 3: Update Projects (if used)

**Before (v1.x):**

```php
'projects' => [
    [
        'name' => 'E-commerce Platform',
        'description' => ['Built scalable platform...'],
        'date' => 'Jan 2024 - Dec 2024',
        'technologies' => ['Laravel', 'React', 'AWS'],
        'url' => 'https://project.com',
    ],
],
```

**After (v2.0):**

```php
'projects' => [
    [
        'name' => 'E-commerce Platform',
        'description' => ['Built scalable platform...'],
        'startDate' => '2024-01',
        'endDate' => '2024-12',
        'isPresent' => false,
        'technologies' => ['Laravel', 'React', 'AWS'],
        'url' => 'https://project.com',
    ],
],
```

### Step 4: Update Additional Information (if used)

**Before (v1.x):**

```php
'additionalInformation' => [
    [
        'title' => 'Certifications',
        'items' => [
            [
                'name' => 'AWS Certified Solutions Architect',
                'organization' => 'Amazon Web Services',
                'date' => 'Mar 2024',
                'description' => 'Professional level certification',
            ],
        ],
    ],
],
```

**After (v2.0):**

```php
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
        ],
    ],
],
```

---

## Helper Function for Migration

If you have existing date strings, here's a helper function to convert them:

```php
/**
 * Convert old date format to new structured format
 *
 * @param string $dateString Old format: "Jan 2020 - Present" or "Mar 2018 - Dec 2019"
 * @return array New format with startDate, endDate, isPresent
 */
function convertDateFormat(string $dateString): array
{
    // Check if currently ongoing
    $isPresent = str_contains(strtolower($dateString), 'present')
              || str_contains(strtolower($dateString), '現在');

    // Split the date string
    $parts = preg_split('/\s*-\s*/', $dateString);

    // Parse start date
    $startDate = parseDate($parts[0] ?? '');

    // Parse end date
    $endDate = null;
    if (!$isPresent && isset($parts[1])) {
        $endDate = parseDate($parts[1]);
    }

    return [
        'startDate' => $startDate,
        'endDate' => $endDate,
        'isPresent' => $isPresent,
    ];
}

/**
 * Parse a date string to YYYY-MM format
 */
function parseDate(string $dateStr): string
{
    // Map month names to numbers
    $months = [
        'jan' => '01', 'feb' => '02', 'mar' => '03', 'apr' => '04',
        'may' => '05', 'jun' => '06', 'jul' => '07', 'aug' => '08',
        'sep' => '09', 'oct' => '10', 'nov' => '11', 'dec' => '12',
    ];

    // Clean up the string
    $dateStr = strtolower(trim($dateStr));

    // Extract year (4 digits)
    preg_match('/\d{4}/', $dateStr, $yearMatch);
    $year = $yearMatch[0] ?? '';

    // Extract month
    $month = '';
    foreach ($months as $name => $num) {
        if (str_contains($dateStr, $name)) {
            $month = $num;
            break;
        }
    }

    // If no month found, try to extract numeric month
    if (!$month) {
        preg_match('/\b(\d{1,2})\b/', $dateStr, $monthMatch);
        if (isset($monthMatch[1])) {
            $month = str_pad($monthMatch[1], 2, '0', STR_PAD_LEFT);
        }
    }

    return $month ? "$year-$month" : $year;
}

// Example usage:
$oldWorkExperience = [
    [
        'company' => 'ABC Corp',
        'position' => 'Engineer',
        'date' => 'Jan 2020 - Present',
        // other fields...
    ],
];

// Convert to new format
$newWorkExperience = array_map(function ($item) {
    $dateFields = convertDateFormat($item['date']);
    unset($item['date']); // Remove old field

    return array_merge($item, $dateFields);
}, $oldWorkExperience);

// Result:
// [
//     [
//         'company' => 'ABC Corp',
//         'position' => 'Engineer',
//         'startDate' => '2020-01',
//         'endDate' => null,
//         'isPresent' => true,
//         // other fields...
//     ],
// ]
```

---

## Date Format Guidelines

### Recommended Formats

✅ **YYYY-MM** (e.g., `2020-01`, `2024-12`) - Preferred  
✅ **YYYY** (e.g., `2020`, `2024`) - For year-only dates

### Examples

```php
// Current position
'startDate' => '2020-01',
'endDate' => null,
'isPresent' => true,

// Past position
'startDate' => '2018-03',
'endDate' => '2019-12',
'isPresent' => false,

// Year-only dates
'startDate' => '2015',
'endDate' => '2019',
'isPresent' => false,

// Ongoing education
'startDate' => '2023-04',
'endDate' => null,
'isPresent' => true,
```

---

## Testing Your Migration

After updating your code, test with a few CVs:

```php
use ResumeX\Facades\ResumeX;

// Test generate with new format
$cv = ResumeX::cv()->generate([
    'userId' => 'test_user_123',
    'templateId' => 'classic',
    'email' => 'test@example.com',
    'workExperience' => [
        [
            'company' => 'Test Company',
            'position' => 'Test Position',
            'startDate' => '2020-01',
            'endDate' => null,
            'isPresent' => true,
            'description' => ['Test description'],
        ],
    ],
]);

echo "CV created: " . $cv['cvId'] . "\n";
echo "Editor URL: " . $cv['editorUrl'] . "\n";

// Test update with new format
$updated = ResumeX::cv()->update($cv['cvId'], [
    'workExperience' => [
        [
            'company' => 'Updated Company',
            'position' => 'Updated Position',
            'startDate' => '2021-06',
            'endDate' => null,
            'isPresent' => true,
            'description' => ['Updated description'],
        ],
    ],
]);

echo "CV updated successfully\n";
```

---

## Need Help?

If you encounter any issues during migration:

1. Check [CHANGELOG.md](CHANGELOG.md) for complete list of changes
2. Review examples in [examples/](examples/) directory
3. Contact support: support@resumex.com

---

## Timeline

- **v1.x** - Old format with `date` field (deprecated)
- **v2.0.0** - New format with `startDate`, `endDate`, `isPresent` (current)
- All partners should migrate by **June 2026**
