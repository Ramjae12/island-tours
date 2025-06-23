@echo off
echo 🏝️  Deploying Island Tours...

echo 📦 Building production assets...
call npm run build

echo 🧹 Clearing caches...
call php artisan config:clear
call php artisan cache:clear
call php artisan route:clear
call php artisan view:clear

echo ⚡ Optimizing for production...
call php artisan config:cache
call php artisan route:cache
call php artisan view:cache

echo 🗄️  Running migrations...
call php artisan migrate --force

echo ✅ Deployment complete!
pause
