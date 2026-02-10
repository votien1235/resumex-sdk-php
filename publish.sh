#!/bin/bash

# ResumeX PHP SDK - Publish to Packagist Script
# Run this script after setting up your GitHub repository

set -e

echo "🚀 ResumeX PHP SDK - Publish Helper"
echo "===================================="

# Check if git is initialized
if [ ! -d ".git" ]; then
    echo "📁 Initializing git repository..."
    git init
fi

# Check for uncommitted changes
if [ -n "$(git status --porcelain)" ]; then
    echo "📝 Adding all files..."
    git add .
    
    read -p "Enter commit message [Initial release v1.0.0]: " commit_msg
    commit_msg=${commit_msg:-"Initial release v1.0.0"}
    
    git commit -m "$commit_msg"
fi

# Get version from composer.json or prompt
read -p "Enter version tag [v1.0.0]: " version
version=${version:-"v1.0.0"}

# Check if remote exists
if ! git remote | grep -q "origin"; then
    echo ""
    echo "⚠️  No remote 'origin' found."
    echo ""
    echo "Please create a GitHub repository first:"
    echo "1. Go to https://github.com/new"
    echo "2. Create repository named: resumex-sdk-php"
    echo "3. Copy the repository URL"
    echo ""
    read -p "Enter GitHub repository URL: " repo_url
    
    if [ -n "$repo_url" ]; then
        git remote add origin "$repo_url"
        echo "✅ Remote added: $repo_url"
    else
        echo "❌ No URL provided. Exiting."
        exit 1
    fi
fi

# Push to GitHub
echo ""
echo "📤 Pushing to GitHub..."
git branch -M main
git push -u origin main

# Create and push tag
echo ""
echo "🏷️  Creating tag: $version"
git tag -a "$version" -m "Release $version"
git push origin "$version"

echo ""
echo "✅ Successfully pushed to GitHub!"
echo ""
echo "📦 Next steps to publish on Packagist:"
echo "======================================="
echo "1. Go to: https://packagist.org/packages/submit"
echo "2. Login with your Packagist account (or create one)"
echo "3. Enter your GitHub repository URL"
echo "4. Click 'Submit'"
echo ""
echo "After publishing, users can install with:"
echo "  composer require resumex/sdk"
echo ""
echo "🎉 Done!"
