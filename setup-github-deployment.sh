#!/bin/bash

# GitHub Deployment Setup Script for Island Tours
echo "🚀 Setting up GitHub Deployment for Island Tours"
echo "================================================="

# Check if we're in a git repository
if [ ! -d ".git" ]; then
    echo "❌ Error: Not in a git repository"
    echo "Please run this script from your project root directory"
    exit 1
fi

echo "✅ Git repository detected"

# Check if GitHub remote exists
if git remote get-url origin &> /dev/null; then
    REMOTE_URL=$(git remote get-url origin)
    echo "✅ GitHub remote found: $REMOTE_URL"
else
    echo "❌ No GitHub remote found"
    echo "Please add your GitHub repository as origin:"
    echo "git remote add origin https://github.com/yourusername/island-tours.git"
    exit 1
fi

# Check if workflow file exists
if [ -f ".github/workflows/deploy.yml" ]; then
    echo "✅ GitHub Actions workflow file exists"
else
    echo "❌ GitHub Actions workflow file not found"
    echo "The workflow file should be at .github/workflows/deploy.yml"
    exit 1
fi

# Stage and commit any pending changes
echo ""
echo "📝 Checking for uncommitted changes..."
if [ -n "$(git status --porcelain)" ]; then
    echo "⚠️  You have uncommitted changes. Would you like to commit them? (y/n)"
    read -r response
    if [[ "$response" =~ ^[Yy]$ ]]; then
        echo "Enter commit message:"
        read -r commit_message
        git add .
        git commit -m "$commit_message"
        echo "✅ Changes committed"
    else
        echo "⚠️  Skipping uncommitted changes"
    fi
else
    echo "✅ No uncommitted changes"
fi

# Check current branch
CURRENT_BRANCH=$(git branch --show-current)
echo "📍 Current branch: $CURRENT_BRANCH"

if [ "$CURRENT_BRANCH" != "main" ]; then
    echo "⚠️  You're not on the main branch. Deployment will only trigger from main branch."
    echo "Would you like to switch to main? (y/n)"
    read -r response
    if [[ "$response" =~ ^[Yy]$ ]]; then
        git checkout main
        echo "✅ Switched to main branch"
    fi
fi

echo ""
echo "🔑 NEXT STEPS:"
echo "=============="
echo ""
echo "1. Add these secrets to your GitHub repository:"
echo "   Go to: https://github.com/$(git remote get-url origin | sed 's/.*github.com[:/]//' | sed 's/.git$//')/settings/secrets/actions"
echo ""
echo "   Required secrets:"
echo "   - FTP_HOST: Your cPanel FTP hostname (e.g., ftp.yourdomain.com)"
echo "   - FTP_USERNAME: Your FTP username"
echo "   - FTP_PASSWORD: Your FTP password"
echo "   - FTP_PATH: Your web root path (e.g., /public_html/)"
echo ""
echo "2. Push to GitHub to trigger deployment:"
echo "   git push origin main"
echo ""
echo "3. Monitor deployment:"
echo "   Go to the 'Actions' tab in your GitHub repository"
echo ""
echo "📖 For detailed instructions, see: GITHUB-DEPLOYMENT-GUIDE.md"
echo ""
echo "🎉 Setup complete! Happy deploying!"
