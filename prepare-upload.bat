@echo off
echo 🏝️  Preparing Island Tours for cPanel Upload...

REM Create a deployment directory
if exist "cpanel-deployment" rmdir /s /q "cpanel-deployment"
mkdir "cpanel-deployment"

echo 📁 Creating deployment package...

REM Copy essential files and folders
xcopy /E /I /Y "app" "cpanel-deployment\app"
xcopy /E /I /Y "bootstrap" "cpanel-deployment\bootstrap"
xcopy /E /I /Y "config" "cpanel-deployment\config"
xcopy /E /I /Y "database" "cpanel-deployment\database"
xcopy /E /I /Y "public" "cpanel-deployment\public"
xcopy /E /I /Y "resources" "cpanel-deployment\resources"
xcopy /E /I /Y "routes" "cpanel-deployment\routes"
xcopy /E /I /Y "storage" "cpanel-deployment\storage"
xcopy /E /I /Y "vendor" "cpanel-deployment\vendor"

REM Copy important files
copy "artisan" "cpanel-deployment\"
copy "composer.json" "cpanel-deployment\"
copy "composer.lock" "cpanel-deployment\"
copy ".env.example" "cpanel-deployment\"
if exist ".env.cpanel" copy ".env.cpanel" "cpanel-deployment\.env"

REM Set proper permissions for storage and cache
echo 📝 Setting up storage permissions...
attrib -R "cpanel-deployment\storage\*.*" /S
attrib -R "cpanel-deployment\bootstrap\cache\*.*" /S

echo ✅ Deployment package created in 'cpanel-deployment' folder!
echo 📋 Next steps:
echo 1. Zip the 'cpanel-deployment' folder contents
echo 2. Upload to your cPanel hosting account
echo 3. Configure your .env file with production settings
echo 4. Set up your domain document root

pause
