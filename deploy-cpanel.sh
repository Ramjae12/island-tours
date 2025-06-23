#!/bin/bash

# Island Tours cPanel Deployment Script
echo "🏝️  Deploying Island Tours to cPanel..."

# Check if we're in the right directory
if [ ! -f "artisan" ]; then
    echo "❌ Error: artisan file not found. Make sure you're in the Laravel root directory."
    exit 1
fi

# Install dependencies (production only)
echo "📦 Installing production dependencies..."
composer install --no-dev --optimize-autoloader --no-interaction

# Create .env if it doesn't exist
if [ ! -f ".env" ]; then
    echo "📝 Creating .env file..."
    cp .env.example .env
    echo "⚠️  Don't forget to configure your .env file with production settings!"
fi

# Generate application key if not set
echo "🔑 Generating application key..."
php artisan key:generate --force

# Set proper permissions
echo "🔒 Setting file permissions..."
chmod -R 755 storage
chmod -R 755 bootstrap/cache
chmod 644 .env

# Clear all caches
echo "🧹 Clearing caches..."
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Build production assets if node_modules exists
if [ -d "node_modules" ]; then
    echo "🎨 Building production assets..."
    npm run build
else
    echo "⚠️  Node modules not found. You may need to build assets locally and upload the build folder."
fi

# Cache configurations for production
echo "⚡ Caching configurations..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Create storage link
echo "🔗 Creating storage link..."
php artisan storage:link

# Run migrations (be careful with this in production)
read -p "Do you want to run database migrations? (y/N): " -n 1 -r
echo
if [[ $REPLY =~ ^[Yy]$ ]]; then
    echo "🗄️  Running migrations..."
    php artisan migrate --force
    
    read -p "Do you want to seed the database? (y/N): " -n 1 -r
    echo
    if [[ $REPLY =~ ^[Yy]$ ]]; then
        echo "🌱 Seeding database..."
        php artisan db:seed --force
    fi
fi

echo "✅ cPanel deployment complete!"
echo ""
echo "📋 Post-deployment checklist:"
echo "1. ✅ Configure your .env file with production database settings"
echo "2. ✅ Set up your domain to point to the 'public' folder"
echo "3. ✅ Upload the optimized .htaccess file to your public folder"
echo "4. ✅ Test your application"
echo "5. ✅ Set up SSL certificate if available"
echo ""
echo "🎉 Your Island Tours application should now be live!"
