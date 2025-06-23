#!/bin/bash

# Island Tours Deployment Script
echo "🏝️  Deploying Island Tours..."

# Build production assets
echo "📦 Building production assets..."
npm run build

# Clear caches
echo "🧹 Clearing caches..."
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Optimize for production
echo "⚡ Optimizing for production..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Run migrations
echo "🗄️  Running migrations..."
php artisan migrate --force

echo "✅ Deployment complete!"
