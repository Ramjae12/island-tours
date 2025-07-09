@echo off
setlocal enabledelayedexpansion

echo 🏝️  Creating Island Tours Deployment Package...
echo.

REM Check if we're in the right directory
if not exist "artisan" (
    echo ❌ Error: artisan file not found. Make sure you're in the Laravel root directory.
    pause
    exit /b 1
)

REM Set deployment directory and package name
set DEPLOY_DIR=island-tours-deployment
set PACKAGE_NAME=island-tours-cpanel-package
set TIMESTAMP=%date:~-4,4%%date:~-10,2%%date:~-7,2%-%time:~0,2%%time:~3,2%%time:~6,2%
set TIMESTAMP=!TIMESTAMP: =0!

echo 📝 Creating deployment directory...
if exist "%DEPLOY_DIR%" rmdir /s /q "%DEPLOY_DIR%"
mkdir "%DEPLOY_DIR%"

echo 📦 Copying essential files...

REM Copy core Laravel files
xcopy "app" "%DEPLOY_DIR%\app\" /E /I /Q
xcopy "bootstrap" "%DEPLOY_DIR%\bootstrap\" /E /I /Q
xcopy "config" "%DEPLOY_DIR%\config\" /E /I /Q
xcopy "database" "%DEPLOY_DIR%\database\" /E /I /Q
xcopy "public" "%DEPLOY_DIR%\public\" /E /I /Q
xcopy "resources" "%DEPLOY_DIR%\resources\" /E /I /Q
xcopy "routes" "%DEPLOY_DIR%\routes\" /E /I /Q
xcopy "storage" "%DEPLOY_DIR%\storage\" /E /I /Q

REM Copy root files
copy "artisan" "%DEPLOY_DIR%\"
copy "composer.json" "%DEPLOY_DIR%\"
copy "composer.lock" "%DEPLOY_DIR%\"
copy ".env.example" "%DEPLOY_DIR%\"
copy "README.md" "%DEPLOY_DIR%\"
copy "package.json" "%DEPLOY_DIR%\"

REM Copy configuration files
if exist "phpunit.xml" copy "phpunit.xml" "%DEPLOY_DIR%\"
if exist "postcss.config.js" copy "postcss.config.js" "%DEPLOY_DIR%\"
if exist "tailwind.config.js" copy "tailwind.config.js" "%DEPLOY_DIR%\"
if exist "vite.config.js" copy "vite.config.js" "%DEPLOY_DIR%\"
if exist "vercel.json" copy "vercel.json" "%DEPLOY_DIR%\"

echo 🔧 Creating production .env file...
echo # Production Environment Configuration > "%DEPLOY_DIR%\.env"
echo APP_NAME="Island Tours" >> "%DEPLOY_DIR%\.env"
echo APP_ENV=production >> "%DEPLOY_DIR%\.env"
echo APP_KEY= >> "%DEPLOY_DIR%\.env"
echo APP_DEBUG=false >> "%DEPLOY_DIR%\.env"
echo APP_URL=https://yourdomain.com >> "%DEPLOY_DIR%\.env"
echo. >> "%DEPLOY_DIR%\.env"
echo LOG_CHANNEL=stack >> "%DEPLOY_DIR%\.env"
echo LOG_DEPRECATIONS_CHANNEL=null >> "%DEPLOY_DIR%\.env"
echo LOG_LEVEL=error >> "%DEPLOY_DIR%\.env"
echo. >> "%DEPLOY_DIR%\.env"
echo # Database Configuration >> "%DEPLOY_DIR%\.env"
echo DB_CONNECTION=mysql >> "%DEPLOY_DIR%\.env"
echo DB_HOST=127.0.0.1 >> "%DEPLOY_DIR%\.env"
echo DB_PORT=3306 >> "%DEPLOY_DIR%\.env"
echo DB_DATABASE=your_database_name >> "%DEPLOY_DIR%\.env"
echo DB_USERNAME=your_database_user >> "%DEPLOY_DIR%\.env"
echo DB_PASSWORD=your_database_password >> "%DEPLOY_DIR%\.env"
echo. >> "%DEPLOY_DIR%\.env"
echo # Cache Configuration >> "%DEPLOY_DIR%\.env"
echo CACHE_DRIVER=file >> "%DEPLOY_DIR%\.env"
echo FILESYSTEM_DISK=local >> "%DEPLOY_DIR%\.env"
echo QUEUE_CONNECTION=sync >> "%DEPLOY_DIR%\.env"
echo SESSION_DRIVER=file >> "%DEPLOY_DIR%\.env"
echo SESSION_LIFETIME=120 >> "%DEPLOY_DIR%\.env"
echo. >> "%DEPLOY_DIR%\.env"
echo # Mail Configuration >> "%DEPLOY_DIR%\.env"
echo MAIL_MAILER=smtp >> "%DEPLOY_DIR%\.env"
echo MAIL_HOST=mailpit >> "%DEPLOY_DIR%\.env"
echo MAIL_PORT=1025 >> "%DEPLOY_DIR%\.env"
echo MAIL_USERNAME=null >> "%DEPLOY_DIR%\.env"
echo MAIL_PASSWORD=null >> "%DEPLOY_DIR%\.env"
echo MAIL_ENCRYPTION=null >> "%DEPLOY_DIR%\.env"
echo MAIL_FROM_ADDRESS="hello@example.com" >> "%DEPLOY_DIR%\.env"
echo MAIL_FROM_NAME="${APP_NAME}" >> "%DEPLOY_DIR%\.env"

echo 📋 Creating deployment instructions...
echo # Island Tours - cPanel Deployment Instructions > "%DEPLOY_DIR%\DEPLOYMENT_INSTRUCTIONS.md"
echo. >> "%DEPLOY_DIR%\DEPLOYMENT_INSTRUCTIONS.md"
echo ## 🚀 Quick Deployment Steps >> "%DEPLOY_DIR%\DEPLOYMENT_INSTRUCTIONS.md"
echo. >> "%DEPLOY_DIR%\DEPLOYMENT_INSTRUCTIONS.md"
echo ### 1. Upload Files >> "%DEPLOY_DIR%\DEPLOYMENT_INSTRUCTIONS.md"
echo - Extract this ZIP package to your cPanel public_html directory >> "%DEPLOY_DIR%\DEPLOYMENT_INSTRUCTIONS.md"
echo - Or upload to a subdirectory if not using main domain >> "%DEPLOY_DIR%\DEPLOYMENT_INSTRUCTIONS.md"
echo. >> "%DEPLOY_DIR%\DEPLOYMENT_INSTRUCTIONS.md"
echo ### 2. Configure Environment >> "%DEPLOY_DIR%\DEPLOYMENT_INSTRUCTIONS.md"
echo - Edit the .env file with your actual database credentials >> "%DEPLOY_DIR%\DEPLOYMENT_INSTRUCTIONS.md"
echo - Update APP_URL to your actual domain >> "%DEPLOY_DIR%\DEPLOYMENT_INSTRUCTIONS.md"
echo - Generate APP_KEY by running: `php artisan key:generate` >> "%DEPLOY_DIR%\DEPLOYMENT_INSTRUCTIONS.md"
echo. >> "%DEPLOY_DIR%\DEPLOYMENT_INSTRUCTIONS.md"
echo ### 3. Install Dependencies >> "%DEPLOY_DIR%\DEPLOYMENT_INSTRUCTIONS.md"
echo Run via SSH or cPanel Terminal: >> "%DEPLOY_DIR%\DEPLOYMENT_INSTRUCTIONS.md"
echo ```bash >> "%DEPLOY_DIR%\DEPLOYMENT_INSTRUCTIONS.md"
echo composer install --no-dev --optimize-autoloader >> "%DEPLOY_DIR%\DEPLOYMENT_INSTRUCTIONS.md"
echo php artisan key:generate >> "%DEPLOY_DIR%\DEPLOYMENT_INSTRUCTIONS.md"
echo php artisan migrate --force >> "%DEPLOY_DIR%\DEPLOYMENT_INSTRUCTIONS.md"
echo php artisan config:cache >> "%DEPLOY_DIR%\DEPLOYMENT_INSTRUCTIONS.md"
echo php artisan route:cache >> "%DEPLOY_DIR%\DEPLOYMENT_INSTRUCTIONS.md"
echo php artisan view:cache >> "%DEPLOY_DIR%\DEPLOYMENT_INSTRUCTIONS.md"
echo php artisan storage:link >> "%DEPLOY_DIR%\DEPLOYMENT_INSTRUCTIONS.md"
echo ``` >> "%DEPLOY_DIR%\DEPLOYMENT_INSTRUCTIONS.md"
echo. >> "%DEPLOY_DIR%\DEPLOYMENT_INSTRUCTIONS.md"
echo ### 4. Set Permissions >> "%DEPLOY_DIR%\DEPLOYMENT_INSTRUCTIONS.md"
echo - storage/ directory: 755 >> "%DEPLOY_DIR%\DEPLOYMENT_INSTRUCTIONS.md"
echo - storage/logs/: 755 >> "%DEPLOY_DIR%\DEPLOYMENT_INSTRUCTIONS.md"
echo - bootstrap/cache/: 755 >> "%DEPLOY_DIR%\DEPLOYMENT_INSTRUCTIONS.md"
echo. >> "%DEPLOY_DIR%\DEPLOYMENT_INSTRUCTIONS.md"
echo ### 5. Domain Configuration >> "%DEPLOY_DIR%\DEPLOYMENT_INSTRUCTIONS.md"
echo - Point your domain to the 'public' folder >> "%DEPLOY_DIR%\DEPLOYMENT_INSTRUCTIONS.md"
echo - Or move contents of 'public' to root if using main domain >> "%DEPLOY_DIR%\DEPLOYMENT_INSTRUCTIONS.md"

echo 🗜️  Creating ZIP package...
cd "%DEPLOY_DIR%"
powershell -command "Compress-Archive -Path '.\*' -DestinationPath '..\%PACKAGE_NAME%-%TIMESTAMP%.zip' -Force"
cd ..

echo 🧹 Cleaning up temporary files...
rmdir /s /q "%DEPLOY_DIR%"

echo ✅ Deployment package created successfully!
echo.
echo 📦 Package location: %PACKAGE_NAME%-%TIMESTAMP%.zip
echo 📁 Size: 
dir "%PACKAGE_NAME%-%TIMESTAMP%.zip" | findstr ".zip"
echo.
echo 🎯 Next steps:
echo 1. Upload %PACKAGE_NAME%-%TIMESTAMP%.zip to your cPanel File Manager
echo 2. Extract the ZIP file to your desired directory
echo 3. Follow the instructions in DEPLOYMENT_INSTRUCTIONS.md
echo 4. Configure your database settings in .env
echo 5. Run the setup commands via SSH or cPanel Terminal
echo.
echo 🚀 Ready for deployment!
pause
