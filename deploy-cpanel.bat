@echo off
echo 🏝️  Deploying Island Tours to cPanel...

REM Check if we're in the right directory
if not exist "artisan" (
    echo ❌ Error: artisan file not found. Make sure you're in the Laravel root directory.
    pause
    exit /b 1
)

REM Install dependencies (production only)
echo 📦 Installing production dependencies...
call composer install --no-dev --optimize-autoloader --no-interaction

REM Create .env if it doesn't exist
if not exist ".env" (
    echo 📝 Creating .env file...
    copy .env.example .env
    echo ⚠️  Don't forget to configure your .env file with production settings!
)

REM Generate application key if not set
echo 🔑 Generating application key...
call php artisan key:generate --force

REM Clear all caches
echo 🧹 Clearing caches...
call php artisan config:clear
call php artisan cache:clear
call php artisan route:clear
call php artisan view:clear

REM Build production assets if node_modules exists
if exist "node_modules" (
    echo 🎨 Building production assets...
    call npm run build
) else (
    echo ⚠️  Node modules not found. You may need to build assets locally and upload the build folder.
)

REM Cache configurations for production
echo ⚡ Caching configurations...
call php artisan config:cache
call php artisan route:cache
call php artisan view:cache

REM Create storage link
echo 🔗 Creating storage link...
call php artisan storage:link

REM Prompt for migrations
set /p migrate="Do you want to run database migrations? (y/N): "
if /i "%migrate%"=="y" (
    echo 🗄️  Running migrations...
    call php artisan migrate --force
    
    set /p seed="Do you want to seed the database? (y/N): "
    if /i "%seed%"=="y" (
        echo 🌱 Seeding database...
        call php artisan db:seed --force
    )
)

echo ✅ cPanel deployment complete!
echo.
echo 📋 Post-deployment checklist:
echo 1. ✅ Configure your .env file with production database settings
echo 2. ✅ Set up your domain to point to the 'public' folder
echo 3. ✅ Upload the optimized .htaccess file to your public folder
echo 4. ✅ Test your application
echo 5. ✅ Set up SSL certificate if available
echo.
echo 🎉 Your Island Tours application should now be live!
pause
