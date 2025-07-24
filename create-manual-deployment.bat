@echo off
echo Creating Island Tours deployment package...

REM Create deployment directory
if exist "island-tours-manual-deploy" rmdir /s /q "island-tours-manual-deploy"
mkdir "island-tours-manual-deploy"

REM Copy application files
echo Copying application files...
xcopy "app" "island-tours-manual-deploy\app\" /E /I /H /Y
xcopy "bootstrap" "island-tours-manual-deploy\bootstrap\" /E /I /H /Y
xcopy "config" "island-tours-manual-deploy\config\" /E /I /H /Y
xcopy "database" "island-tours-manual-deploy\database\" /E /I /H /Y
xcopy "public" "island-tours-manual-deploy\public\" /E /I /H /Y
xcopy "resources" "island-tours-manual-deploy\resources\" /E /I /H /Y
xcopy "routes" "island-tours-manual-deploy\routes\" /E /I /H /Y
xcopy "storage" "island-tours-manual-deploy\storage\" /E /I /H /Y

REM Copy essential files
echo Copying essential files...
copy "artisan" "island-tours-manual-deploy\"
copy "composer.json" "island-tours-manual-deploy\"
copy "composer.lock" "island-tours-manual-deploy\"

REM Create production .env template
echo Creating production .env template...
echo # Production Environment Configuration > "island-tours-manual-deploy\.env.example"
echo APP_NAME="Island Tours" >> "island-tours-manual-deploy\.env.example"
echo APP_ENV=production >> "island-tours-manual-deploy\.env.example"
echo APP_KEY= >> "island-tours-manual-deploy\.env.example"
echo APP_DEBUG=false >> "island-tours-manual-deploy\.env.example"
echo APP_URL=https://stg-corregidorisland.tieza.online >> "island-tours-manual-deploy\.env.example"
echo. >> "island-tours-manual-deploy\.env.example"
echo DB_CONNECTION=mysql >> "island-tours-manual-deploy\.env.example"
echo DB_HOST=127.0.0.1 >> "island-tours-manual-deploy\.env.example"
echo DB_PORT=3306 >> "island-tours-manual-deploy\.env.example"
echo DB_DATABASE=your_database_name >> "island-tours-manual-deploy\.env.example"
echo DB_USERNAME=your_db_user >> "island-tours-manual-deploy\.env.example"
echo DB_PASSWORD=your_db_password >> "island-tours-manual-deploy\.env.example"

REM Create deployment instructions
echo Creating deployment instructions...
echo # Manual Deployment Instructions > "island-tours-manual-deploy\DEPLOY-INSTRUCTIONS.txt"
echo. >> "island-tours-manual-deploy\DEPLOY-INSTRUCTIONS.txt"
echo 1. Upload all files to your cPanel public_html directory >> "island-tours-manual-deploy\DEPLOY-INSTRUCTIONS.txt"
echo 2. Copy .env.example to .env and configure database settings >> "island-tours-manual-deploy\DEPLOY-INSTRUCTIONS.txt"
echo 3. Generate application key: php artisan key:generate >> "island-tours-manual-deploy\DEPLOY-INSTRUCTIONS.txt"
echo 4. Run migrations: php artisan migrate --force >> "island-tours-manual-deploy\DEPLOY-INSTRUCTIONS.txt"
echo 5. Set storage permissions: chmod -R 775 storage/ >> "island-tours-manual-deploy\DEPLOY-INSTRUCTIONS.txt"
echo 6. Set bootstrap/cache permissions: chmod -R 775 bootstrap/cache/ >> "island-tours-manual-deploy\DEPLOY-INSTRUCTIONS.txt"
echo 7. Your site should be live at: https://stg-corregidorisland.tieza.online/ >> "island-tours-manual-deploy\DEPLOY-INSTRUCTIONS.txt"

REM Create ZIP file with timestamp
for /f "tokens=2 delims==" %%a in ('wmic OS Get localdatetime /value') do set "dt=%%a"
set "YY=%dt:~2,2%" & set "YYYY=%dt:~0,4%" & set "MM=%dt:~4,2%" & set "DD=%dt:~6,2%"
set "HH=%dt:~8,2%" & set "Min=%dt:~10,2%" & set "Sec=%dt:~12,2%"
set "datestamp=%YYYY%%MM%%DD%-%HH%%Min%%Sec%"

echo Creating deployment ZIP file...
powershell Compress-Archive -Path "island-tours-manual-deploy\*" -DestinationPath "island-tours-deployment-%datestamp%.zip" -Force

echo.
echo ========================================
echo DEPLOYMENT PACKAGE CREATED SUCCESSFULLY!
echo ========================================
echo.
echo ZIP File: island-tours-deployment-%datestamp%.zip
echo.
echo NEXT STEPS:
echo 1. Upload the ZIP file to your cPanel File Manager
echo 2. Extract it in the public_html directory
echo 3. Follow the instructions in DEPLOY-INSTRUCTIONS.txt
echo.
echo Your Island Tours app will be live at:
echo https://stg-corregidorisland.tieza.online/
echo.
pause
