#!/bin/bash

# ResumeX SDK - Release v1.2.0
# This script will commit changes and create a new release tag

set -e

echo "🚀 ResumeX SDK - Release v1.2.0"
echo "================================"
echo ""

# Check if we're in the right directory
if [ ! -f "composer.json" ]; then
    echo "❌ Error: composer.json not found. Please run this script from the SDK root directory."
    exit 1
fi

# Check if git is clean (except for our changes)
echo "📝 Checking git status..."
git status

echo ""
read -p "Continue with commit? (y/n) " -n 1 -r
echo ""
if [[ ! $REPLY =~ ^[Yy]$ ]]; then
    echo "❌ Aborted."
    exit 1
fi

# Add all changes
echo "📦 Adding changes to git..."
git add -A

# Commit changes
echo "💾 Committing changes..."
git commit -m "Release v1.2.0 - Add update() method for PATCH API

- Added update() method to CV resource
- Support for updating existing CVs via PATCH API
- Bidirectional sync capability for partners
- Comprehensive documentation and examples
- Updated README with update() examples
- Added examples/update-cv.php with 4 use cases
- Added QUICK_REFERENCE_UPDATE_API.md

Breaking Changes: None
Backward Compatible: Yes"

# Create git tag
echo "🏷️  Creating git tag v1.2.0..."
git tag -a v1.2.0 -m "Release v1.2.0 - PATCH API Support

New Features:
- update() method in CV resource
- Bidirectional sync support
- Partial update capability

Documentation:
- Updated README with update() examples
- Added comprehensive example file
- Added quick reference guide

Benefits:
- Always fresh data when opening CV editor
- No manual re-entry for users
- True bidirectional sync (ResumeX ↔️ Partner)
"

echo ""
echo "✅ Changes committed and tagged!"
echo ""
echo "Next steps:"
echo "1. Push to GitHub:"
echo "   git push origin main"
echo "   git push origin v1.2.0"
echo ""
echo "2. Create GitHub Release:"
echo "   - Go to: https://github.com/resumex/sdk-php/releases/new"
echo "   - Tag: v1.2.0"
echo "   - Title: v1.2.0 - PATCH API Support"
echo "   - Copy content from CHANGELOG.md"
echo ""
echo "3. Packagist will auto-update (if webhook is configured)"
echo "   - Or manually: https://packagist.org/packages/resumex/sdk"
echo ""
echo "4. Test installation:"
echo "   composer require resumex/sdk:^1.2.0"
echo ""
