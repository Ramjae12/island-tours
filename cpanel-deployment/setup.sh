#!/bin/bash
# Quick setup script for cPanel
echo "🏝️ Setting up Island Tours..."

echo "📝 Setting file permissions..."
chmod 755 storage
chmod 755 bootstrap/cache
chmod -R 755 storage
chmod -R 755 bootstrap/cache

echo "🔧 Installing dependencies..."
composer install --no-dev --optimize-autoloader

echo "🧹 Clearing caches..."
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

echo "⚡ Caching for production..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "🔗 Creating storage link..."
php artisan storage:link

echo "🗄️ Running migrations..."
read -p "Run database migrations? (y/N): " migrate
if [[ $migrate == "y" ]]; then
    php artisan migrate --force
fi

echo "✅ Setup complete!"
echo "Don't forget to configure your .env file!"
