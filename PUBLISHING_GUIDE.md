# 📦 Publishing ResumeX SDK v1.2.0 to Packagist

## ✅ Checklist Before Publishing

- [x] Code changes completed
  - [x] Added `update()` method to `CV.php`
  - [x] Updated `README.md`
  - [x] Updated `CHANGELOG.md`
  - [x] Added examples
  - [x] Updated `composer.json` version to 1.2.0
  
- [ ] Testing
  - [ ] Test `update()` method locally
  - [ ] Test with Laravel project
  - [ ] Test error handling
  
- [ ] Git repository
  - [ ] All changes committed
  - [ ] Tagged with v1.2.0
  - [ ] Pushed to GitHub
  
- [ ] Packagist
  - [ ] Package updated on Packagist
  - [ ] New version shows on Packagist

---

## 📋 Step-by-Step Publishing Guide

### Step 1: Run the Release Script

```bash
cd /Users/mscmini/Documents/resume/packages/resumex-sdk-php
./release-v1.2.0.sh
```

This will:
- Add all changes to git
- Commit with detailed message
- Create git tag v1.2.0

---

### Step 2: Push to GitHub

```bash
# Push commits
git push origin main

# Push tag
git push origin v1.2.0
```

---

### Step 3: Create GitHub Release

1. Go to: https://github.com/resumex/sdk-php/releases/new
2. Select tag: `v1.2.0`
3. Release title: `v1.2.0 - PATCH API Support`
4. Description:

```markdown
## 🎉 ResumeX SDK v1.2.0 - PATCH API Support

### ✨ New Features

- **`update()` method in CV resource** - Update existing CVs via PATCH API
  - Supports both standard CVs (classic, basic, two-column-modern) and Japanese CVs (professional-grid)
  - Same data structure as `generate()` for consistency
  - Supports partial updates (only changed fields)
  - Example: `ResumeX::cv()->update($cvId, ['firstName' => 'Updated Name'])`

### 🔄 Bidirectional Sync Support

Partners can now push updates from their systems to ResumeX:
- Always fresh data when users open the CV editor
- No need for users to re-enter data in ResumeX
- Enables true bidirectional sync (ResumeX ↔️ Partner System)
- Flexible updates (full or partial)

### 📚 Documentation

- Updated API Reference section with `update()` method examples
- Added `examples/update-cv.php` with 4 real-world use cases:
  1. Update standard CV
  2. Update Japanese CV
  3. Partial update
  4. Bidirectional sync integration
- Added `QUICK_REFERENCE_UPDATE_API.md` - Quick reference guide

### 🚀 Usage Example

```php
use ResumeX\Facades\ResumeX;

// Update CV
$updatedCv = ResumeX::cv()->update('cv_xyz789', [
    'firstName' => 'NGUYEN VAN',
    'lastName' => 'B',
    'phoneNumber' => '090-1234-5678',
    'professionalSummary' => 'Updated summary...',
]);
```

### 📖 Full Changelog

See [CHANGELOG.md](CHANGELOG.md) for complete list of changes.

### ⬆️ Upgrade Instructions

```bash
# Update via Composer
composer update resumex/sdk

# Or specify version
composer require resumex/sdk:^1.2.0
```

### 🔗 Links

- [Documentation](README.md)
- [Quick Reference](QUICK_REFERENCE_UPDATE_API.md)
- [Examples](examples/update-cv.php)
- [Packagist](https://packagist.org/packages/resumex/sdk)

### 💡 Benefits for Partners

1. ✅ Always fresh data when users open the CV editor
2. ✅ No need for users to re-enter data in ResumeX
3. ✅ Bidirectional sync (ResumeX ↔️ Partner System)
4. ✅ Flexible updates (full or partial)
5. ✅ Type support (works with both standard and Japanese CVs)
6. ✅ Error handling (comprehensive exception handling built-in)
7. ✅ Well documented (clear examples and API reference)

---

**Breaking Changes:** None  
**Backward Compatible:** Yes  
**Minimum PHP Version:** 8.1
```

5. Click **Publish release**

---

### Step 4: Update Packagist

#### Option A: Automatic (Recommended)

If GitHub webhook is configured:
1. Go to: https://packagist.org/packages/resumex/sdk
2. The package will update automatically within a few minutes
3. Verify the new version appears

#### Option B: Manual Update

If webhook is not configured:
1. Go to: https://packagist.org/packages/resumex/sdk
2. Click **Update** button
3. Wait for Packagist to fetch the new version

---

### Step 5: Verify Installation

Test that the new version can be installed:

```bash
# Create test directory
mkdir /tmp/test-resumex-sdk
cd /tmp/test-resumex-sdk

# Initialize composer
composer init -n

# Require the package
composer require resumex/sdk:^1.2.0

# Verify version
composer show resumex/sdk
```

Expected output:
```
name     : resumex/sdk
descrip. : Official PHP SDK for ResumeX API - AI-powered CV generation platform
keywords : resumex, cv, resume, api, sdk, laravel
versions : * 1.2.0
```

---

### Step 6: Update Laravel Project

In your Leisure-ist project:

```bash
cd /Users/mscmini/Documents/resume/kyujin-leisureist-2

# Remove local path reference (if using)
composer remove resumex/sdk

# Install from Packagist
composer require resumex/sdk:^1.2.0

# Verify
composer show resumex/sdk
```

---

## 🧪 Testing After Publish

### Test 1: Basic Update

```php
use ResumeX\Facades\ResumeX;

try {
    $cv = ResumeX::cv()->update('cv_xyz789', [
        'firstName' => 'Test',
        'lastName' => 'User',
    ]);
    
    echo "✅ Update works!\n";
    print_r($cv);
} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
```

### Test 2: Bidirectional Sync

```php
// In WebResumeController
$response = ResumeX::cv()->update($webCV->resumex_cv_id, $cvData);
echo "✅ Sync works! CV ID: " . $response['id'] . "\n";
```

---

## 📊 Post-Publish Checklist

- [ ] Version 1.2.0 appears on Packagist
- [ ] GitHub release created
- [ ] Documentation is accessible
- [ ] Can install via `composer require resumex/sdk:^1.2.0`
- [ ] Laravel project updated to use Packagist version
- [ ] Update method works in Laravel
- [ ] Bidirectional sync tested
- [ ] Error handling tested

---

## 📝 Notify Partners

After publishing, notify partners about the update:

### Email Template

```
Subject: ResumeX SDK v1.2.0 Released - PATCH API Support 🎉

Hi Partners,

We're excited to announce ResumeX SDK v1.2.0 with PATCH API support!

🆕 What's New:
- Update existing CVs programmatically
- Bidirectional sync capability
- Always fresh data in CV editor

📦 Update Now:
composer update resumex/sdk

📖 Documentation:
- Quick Reference: QUICK_REFERENCE_UPDATE_API.md
- Examples: examples/update-cv.php
- Full Guide: README.md

💡 Benefits:
- No more manual data re-entry for users
- CV always shows latest data
- Seamless sync between systems

Questions? Reply to this email or check our docs.

Happy coding! 🚀
ResumeX Team
```

---

## 🔗 Important Links

- **GitHub Repo:** https://github.com/resumex/sdk-php
- **Packagist:** https://packagist.org/packages/resumex/sdk
- **Releases:** https://github.com/resumex/sdk-php/releases
- **Issues:** https://github.com/resumex/sdk-php/issues

---

## ⚠️ Troubleshooting

### Issue: Packagist not updating

**Solution:**
1. Check webhook configuration: https://packagist.org/packages/resumex/sdk/settings
2. Manually click "Update" button
3. Wait 5-10 minutes for cache to clear

### Issue: Composer can't find new version

**Solution:**
```bash
composer clear-cache
composer require resumex/sdk:^1.2.0
```

### Issue: Laravel still using old version

**Solution:**
```bash
# Remove vendor
rm -rf vendor

# Clear composer cache
composer clear-cache

# Reinstall
composer install
```

---

**Ready to publish?** Run `./release-v1.2.0.sh` to start! 🚀
