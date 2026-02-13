# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

### ⚠️ BREAKING CHANGES

- **Date field structure changed for `workExperience`, `education`, `projects`, and `additionalInformation`**
  - **OLD**: Single `date` field with free-text string (e.g., `'date' => 'Jan 2020 - Present'`)
  - **NEW**: Three structured fields:
    - `startDate` (string, required) - Format: `MM/YYYY` or `YYYY`
    - `endDate` (string|null, optional) - Format: `MM/YYYY` or `YYYY`, `null` if currently ongoing
    - `isPresent` (boolean, required) - `true` if currently ongoing, `false` otherwise

### Migration Guide

**Before (v1.2.0 and earlier):**

```php
'workExperience' => [
    [
        'company' => 'ABC Corp',
        'position' => 'Engineer',
        'date' => 'Jan 2020 - Present',
        // ...
    ],
],
'education' => [
    [
        'school' => 'University',
        'degree' => 'Bachelor',
        'date' => 'Sep 2015 - Jun 2019',
        // ...
    ],
],
```

**After (v2.0.0+):**

```php
'workExperience' => [
    [
        'company' => 'ABC Corp',
        'position' => 'Engineer',
        'startDate' => '01/2020',
        'endDate' => null,
        'isPresent' => true,
        // ...
    ],
],
'education' => [
    [
        'school' => 'University',
        'degree' => 'Bachelor',
        'startDate' => '2015-09',
        'endDate' => '2019-06',
        'isPresent' => false,
        // ...
    ],
],
```

### Benefits of New Structure

- ✅ **Consistent date format** across all sections
- ✅ **Better sorting** and filtering capabilities
- ✅ **Clear indication** of ongoing positions/education
- ✅ **Easier date calculations** (duration, gaps, etc.)
- ✅ **ATS-friendly** structured data

## [2.0.1] - 2026-02-13

### Fixed
- **Date format documentation corrected to MM/YYYY**
  - All examples and documentation now use correct `MM/YYYY` format (e.g., `'01/2020'`)
  - Previously showed incorrect `YYYY-MM` format (e.g., `'2020-01'`)
  - Updated files: README.md, MIGRATION_V2.md, examples/update-cv.php, QUICK_REFERENCE_UPDATE_API.md, SDK_UPDATE_SUMMARY.md, src/Resources/CV.php
  - No code changes - API already accepted MM/YYYY format correctly

## [2.0.0] - 2026-02-13

### ⚠️ BREAKING CHANGES

- **Date field structure changed for `workExperience`, `education`, `projects`, and `additionalInformation`**
  - **OLD**: Single `date` field with free-text string (e.g., `'date' => 'Jan 2020 - Present'`)
  - **NEW**: Three structured fields:
    - `startDate` (string, required) - Format: `MM/YYYY` or `YYYY`
    - `endDate` (string|null, optional) - Format: `MM/YYYY` or `YYYY`, `null` if currently ongoing
    - `isPresent` (boolean, required) - `true` if currently ongoing, `false` otherwise

### Migration Guide

**Before (v1.2.0 and earlier):**

```php
'workExperience' => [
    [
        'company' => 'ABC Corp',
        'position' => 'Engineer',
        'date' => 'Jan 2020 - Present',
        // ...
    ],
],
'education' => [
    [
        'school' => 'University',
        'degree' => 'Bachelor',
        'date' => 'Sep 2015 - Jun 2019',
        // ...
    ],
],
```

**After (v2.0.0+):**

```php
'workExperience' => [
    [
        'company' => 'ABC Corp',
        'position' => 'Engineer',
        'startDate' => '01/2020',
        'endDate' => null,
        'isPresent' => true,
        // ...
    ],
],
'education' => [
    [
        'school' => 'University',
        'degree' => 'Bachelor',
        'startDate' => '2015-09',
        'endDate' => '2019-06',
        'isPresent' => false,
        // ...
    ],
],
```

### Benefits of New Structure

- ✅ **Consistent date format** across all sections
- ✅ **Better sorting** and filtering capabilities
- ✅ **Clear indication** of ongoing positions/education
- ✅ **Easier date calculations** (duration, gaps, etc.)
- ✅ **ATS-friendly** structured data

## [1.2.0] - 2026-03-12

### Added

- **`update()` method in CV resource** - Update existing CVs via PATCH API
  - Supports both standard CVs (classic, basic, two-column-modern) and Japanese CVs (professional-grid)
  - Same data structure as `generate()` for consistency
  - Supports partial updates (only changed fields)
  - Example: `ResumeX::cv()->update($cvId, ['firstName' => 'Updated Name'])`
- **Bidirectional sync support** - Partners can now push updates from their systems to ResumeX
- **Comprehensive example file** - Added `examples/update-cv.php` with 4 real-world use cases:
  1. Update standard CV
  2. Update Japanese CV
  3. Partial update
  4. Bidirectional sync integration

### Documentation

- Updated API Reference section with `update()` method examples
- Added update examples for both standard and Japanese CVs
- Documented bidirectional sync use case

### Benefits for Partners

- Always fresh data when users open the CV editor
- No need for users to re-enter data in ResumeX
- Enables true bidirectional sync (ResumeX ↔️ Partner System)
- Flexible updates (full or partial)

## [1.1.1] - 2026-02-12

### Fixed

- **BREAKING DOC FIX**: Corrected Japanese CV field names in documentation to match actual API
  - Basic info fields moved to top-level (firstName, lastName, birthYear, etc.)
  - Updated webCv field structure with correct names:
    - `qualificationList` instead of `licenses`
    - `cv_work_experience` instead of `careerHistory`
    - `applying_info`, `experience_info`, `personal_info`, etc. instead of old names
  - Spouse/spouse_support now use numeric values (0/1) instead of strings
- Fixed `ResumeXException` to handle array messages from API validation errors

### Documentation

- Updated all Japanese CV examples to use correct field structure
- Added complete field reference table matching backend API
- Clarified top-level vs webCv field organization

## [1.1.0] - 2026-02-12

### Added

- Support for Japanese CV template (`professional-grid`) with `webCv` field
- Comprehensive field reference documentation for all templates
- Example code for Japanese CV (履歴書) generation

### Changed

- Updated API payload structure to flat format (non-breaking, backwards compatible)
- Improved documentation with separate examples for standard CV and Japanese CV
- Updated Complete Integration Example with modern payload structure

### Fixed

- Fixed HMAC signature generation for Unicode characters (Japanese text)
- Use `JSON_UNESCAPED_UNICODE` flag for consistent signature calculation

### Documentation

- Added Field Reference section with tables for all supported fields
- Added Japanese CV specific fields documentation (webCv)
- Updated code examples throughout README

## [1.0.0] - 2026-02-11

### Added

- Initial release
- `Client` class with HMAC-SHA256 signature authentication
- `CV` resource: generate, get, enhance, delete methods
- `Partner` resource: getQuota, getUsage, getDashboard methods
- `Templates` resource: list, get methods
- Laravel Service Provider with auto-discovery
- Laravel Facade for easy usage
- Comprehensive error handling with `ResumeXException`
- Configuration file for Laravel
- Full documentation and examples
