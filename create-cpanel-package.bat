@echo off
echo 🏝️  Creating cPanel deployment package...

REM Create deployment directory
if exist "cpanel-deployment" rmdir /s /q "cpanel-deployment"
mkdir "cpanel-deployment"

echo 📦 Copying application files...

REM Copy main application files
xcopy "app" "cpanel-deployment\app" /E /I /Q
xcopy "bootstrap" "cpanel-deployment\bootstrap" /E /I /Q
xcopy "config" "cpanel-deployment\config" /E /I /Q
xcopy "database" "cpanel-deployment\database" /E /I /Q
xcopy "public" "cpanel-deployment\public" /E /I /Q
xcopy "resources" "cpanel-deployment\resources" /E /I /Q
xcopy "routes" "cpanel-deployment\routes" /E /I /Q
xcopy "storage" "cpanel-deployment\storage" /E /I /Q

REM Copy vendor (production dependencies only)
if exist "vendor" (
    echo 📚 Copying vendor dependencies...
    xcopy "vendor" "cpanel-deployment\vendor" /E /I /Q
)

REM Copy configuration files
copy "composer.json" "cpanel-deployment\"
copy "composer.lock" "cpanel-deployment\"
copy "artisan" "cpanel-deployment\"
copy "webpack.mix.js" "cpanel-deployment\"
copy "package.json" "cpanel-deployment\"
copy "tailwind.config.js" "cpanel-deployment\"
copy "postcss.config.js" "cpanel-deployment\"

REM Copy environment template
copy "env-production-template.txt" "cpanel-deployment\"

REM Copy documentation
copy "CPANEL-DEPLOYMENT-GUIDE.md" "cpanel-deployment\"
copy "README.md" "cpanel-deployment\" 2>nul

REM Create .htaccess for public folder
echo Creating optimized .htaccess...
(
echo ^<IfModule mod_rewrite.c^>
echo     ^<IfModule mod_negotiation.c^>
echo         Options -MultiViews -Indexes
echo     ^</IfModule^>
echo.
echo     RewriteEngine On
echo.
echo     # Handle Authorization Header
echo     RewriteCond %%{HTTP:Authorization} .
echo     RewriteRule .* - [E=HTTP_AUTHORIZATION:%%{HTTP:Authorization}]
echo.
echo     # Redirect Trailing Slashes If Not A Folder...
echo     RewriteCond %%{REQUEST_FILENAME} !-d
echo     RewriteCond %%{REQUEST_URI} ^(.+^)/$ 
echo     RewriteRule ^(.+^)/$ /$1 [R=301,L]
echo.
echo     # Send Requests To Front Controller...
echo     RewriteCond %%{REQUEST_FILENAME} !-d
echo     RewriteCond %%{REQUEST_FILENAME} !-f
echo     RewriteRule ^ index.php [L]
echo ^</IfModule^>
) > "cpanel-deployment\public\.htaccess"

REM Create directory structure for storage
echo 📁 Creating storage directories...
mkdir "cpanel-deployment\storage\app\public" 2>nul
mkdir "cpanel-deployment\storage\framework\cache\data" 2>nul
mkdir "cpanel-deployment\storage\framework\sessions" 2>nul
mkdir "cpanel-deployment\storage\framework\views" 2>nul
mkdir "cpanel-deployment\storage\logs" 2>nul

REM Create empty log file
echo. > "cpanel-deployment\storage\logs\laravel.log"

REM Set proper permissions info file
(
echo # File Permissions for cPanel
echo.
echo ## Required Permissions:
echo chmod 755 storage/
echo chmod 755 bootstrap/cache/
echo chmod 644 .env
echo chmod -R 755 storage/
echo chmod -R 755 bootstrap/cache/
echo.
echo ## For all files:
echo find . -type f -exec chmod 644 {} \;
echo find . -type d -exec chmod 755 {} \;
) > "cpanel-deployment\FILE-PERMISSIONS.txt"

REM Create quick setup script
(
echo #!/bin/bash
echo # Quick setup script for cPanel
echo echo "🏝️ Setting up Island Tours..."
echo.
echo echo "📝 Setting file permissions..."
echo chmod 755 storage
echo chmod 755 bootstrap/cache
echo chmod -R 755 storage
echo chmod -R 755 bootstrap/cache
echo.
echo echo "🔧 Installing dependencies..."
echo composer install --no-dev --optimize-autoloader
echo.
echo echo "🧹 Clearing caches..."
echo php artisan config:clear
echo php artisan cache:clear
echo php artisan route:clear
echo php artisan view:clear
echo.
echo echo "⚡ Caching for production..."
echo php artisan config:cache
echo php artisan route:cache
echo php artisan view:cache
echo.
echo echo "🔗 Creating storage link..."
echo php artisan storage:link
echo.
echo echo "🗄️ Running migrations..."
echo read -p "Run database migrations? (y/N): " migrate
echo if [[ $migrate == "y" ]]; then
echo     php artisan migrate --force
echo fi
echo.
echo echo "✅ Setup complete!"
echo echo "Don't forget to configure your .env file!"
) > "cpanel-deployment\setup.sh"

echo ✅ Deployment package created in 'cpanel-deployment' folder!
echo.
echo 📋 Next steps:
echo 1. Compress the 'cpanel-deployment' folder to ZIP
echo 2. Upload ZIP file to your cPanel File Manager
echo 3. Extract in your desired directory
echo 4. Follow the CPANEL-DEPLOYMENT-GUIDE.md
echo.
echo 🎯 Ready for upload to cPanel!
pause
