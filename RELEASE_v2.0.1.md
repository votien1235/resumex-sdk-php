# ResumeX SDK v2.0.1 Released - Date Format Documentation Fix

## 🎉 Release Summary

**Version**: v2.0.1  
**Date**: February 13, 2026  
**Type**: Documentation Fix (Non-breaking)

## ✅ What Was Fixed

### Problem

The SDK documentation and examples were showing **incorrect date format**:

- ❌ Documentation showed: `'startDate' => '2020-01'` (YYYY-MM)
- ✅ Actual API expects: `'startDate' => '01/2020'` (MM/YYYY)

### Solution

Updated all documentation and examples to use the correct **MM/YYYY** format.

## 📝 Files Updated

1. ✅ **README.md** - All date examples corrected
2. ✅ **MIGRATION_V2.md** - Migration guide examples fixed
3. ✅ **examples/update-cv.php** - All code examples corrected
4. ✅ **QUICK_REFERENCE_UPDATE_API.md** - API reference updated
5. ✅ **SDK_UPDATE_SUMMARY.md** - Summary document updated
6. ✅ **src/Resources/CV.php** - PHPDoc examples corrected
7. ✅ **CHANGELOG.md** - Added v2.0.1 release notes

## 🔧 Changes Made

### Before (v2.0.0 - INCORRECT in docs)

```php
'workExperience' => [
    [
        'company' => 'Tech Corp',
        'position' => 'Engineer',
        'startDate' => '2020-01',  // ❌ WRONG FORMAT
        'endDate' => '2023-12',    // ❌ WRONG FORMAT
        'isPresent' => false,
    ],
],
```

### After (v2.0.1 - CORRECT)

```php
'workExperience' => [
    [
        'company' => 'Tech Corp',
        'position' => 'Engineer',
        'startDate' => '01/2020',  // ✅ CORRECT FORMAT
        'endDate' => '12/2023',    // ✅ CORRECT FORMAT
        'isPresent' => false,
    ],
],
```

## 📊 Format Specification

According to the **ResumeX API Backend Specification**:

```typescript
"startDate": "string (optional, format: MM/YYYY or YYYY)"
"endDate": "string (optional, format: MM/YYYY or YYYY)"
```

### Valid Examples:

- ✅ `"01/2020"` - Full date (January 2020)
- ✅ `"12/2023"` - Full date (December 2023)
- ✅ `"2020"` - Year only
- ✅ `"2023"` - Year only

### Invalid Examples:

- ❌ `"2020-01"` - YYYY-MM format (WRONG)
- ❌ `"2023-12"` - YYYY-MM format (WRONG)
- ❌ `"01-2020"` - MM-YYYY with dash (WRONG)

## ⚠️ Important Notes

### No Code Changes

- **The API already worked correctly** with MM/YYYY format
- Only documentation was incorrect
- **No breaking changes** in this release
- **No migration needed** if you were already using MM/YYYY

### If You Were Using YYYY-MM

If you followed the old (incorrect) documentation and used YYYY-MM format:

1. Update your code to use MM/YYYY format
2. Example conversion:
   - `'2020-01'` → `'01/2020'`
   - `'2023-12'` → `'12/2023'`

## 🚀 Installation

```bash
composer require resumex/sdk:^2.0
```

This will install the latest v2.0.x version (currently v2.0.1).

## 📦 Packagist Status

✅ **Available on Packagist**: https://packagist.org/packages/resumex/sdk

```bash
$ composer show resumex/sdk --available
versions : v2.0.1, v2.0.0, 1.2.0, v1.1.1, v1.1.0, v1.0.0
```

## 🔗 Links

- **GitHub Repository**: https://github.com/votien1235/resumex-sdk-php
- **Packagist**: https://packagist.org/packages/resumex/sdk
- **Documentation**: See README.md
- **Migration Guide**: See MIGRATION_V2.md

## 📋 Version History

| Version | Date       | Type  | Description                                            |
| ------- | ---------- | ----- | ------------------------------------------------------ |
| v2.0.1  | 2026-02-13 | Fix   | Date format documentation corrected to MM/YYYY         |
| v2.0.0  | 2026-02-13 | Major | Structured date fields (startDate, endDate, isPresent) |
| v1.2.0  | -          | Minor | PATCH API support with update() method                 |
| v1.1.1  | -          | Patch | Fix Japanese CV fields and error handling              |
| v1.1.0  | -          | Minor | Japanese CV support                                    |
| v1.0.0  | -          | Major | Initial release                                        |

## 🎯 Summary

This is a **documentation-only fix** to ensure all examples and guides show the correct date format (MM/YYYY) that the API expects. No code changes were made to the SDK itself.

If you were already using the correct MM/YYYY format, **you don't need to change anything**. If you followed the old documentation with YYYY-MM format, simply update your date strings to MM/YYYY format.

---

**Questions or Issues?**

- GitHub Issues: https://github.com/votien1235/resumex-sdk-php/issues
- Email: tech@resumex.com
