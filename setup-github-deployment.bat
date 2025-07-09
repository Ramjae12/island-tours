@echo off
echo 🚀 Setting up GitHub Deployment for Island Tours
echo =================================================
echo.

REM Check if we're in a git repository
if not exist ".git" (
    echo ❌ Error: Not in a git repository
    echo Please run this script from your project root directory
    pause
    exit /b 1
)

echo ✅ Git repository detected

REM Check if GitHub remote exists
git remote get-url origin >nul 2>&1
if %errorlevel% equ 0 (
    echo ✅ GitHub remote found
    for /f %%i in ('git remote get-url origin') do set REMOTE_URL=%%i
    echo Remote: %REMOTE_URL%
) else (
    echo ❌ No GitHub remote found
    echo Please add your GitHub repository as origin:
    echo git remote add origin https://github.com/yourusername/island-tours.git
    pause
    exit /b 1
)

REM Check if workflow file exists
if exist ".github\workflows\deploy.yml" (
    echo ✅ GitHub Actions workflow file exists
) else (
    echo ❌ GitHub Actions workflow file not found
    echo The workflow file should be at .github\workflows\deploy.yml
    pause
    exit /b 1
)

echo.
echo 📝 Checking for uncommitted changes...

REM Check for uncommitted changes
git status --porcelain > temp_status.txt
set /p status_check= < temp_status.txt
del temp_status.txt

if "%status_check%" neq "" (
    echo ⚠️ You have uncommitted changes. Would you like to commit them? (y/n)
    set /p response=
    if /i "%response%"=="y" (
        set /p commit_message=Enter commit message: 
        git add .
        git commit -m "%commit_message%"
        echo ✅ Changes committed
    ) else (
        echo ⚠️ Skipping uncommitted changes
    )
) else (
    echo ✅ No uncommitted changes
)

REM Get current branch
for /f %%i in ('git branch --show-current') do set CURRENT_BRANCH=%%i
echo 📍 Current branch: %CURRENT_BRANCH%

if "%CURRENT_BRANCH%" neq "main" (
    echo ⚠️ You're not on the main branch. Deployment will only trigger from main branch.
    echo Would you like to switch to main? (y/n)
    set /p response=
    if /i "%response%"=="y" (
        git checkout main
        echo ✅ Switched to main branch
    )
)

echo.
echo 🔑 NEXT STEPS:
echo ==============
echo.
echo 1. Add these secrets to your GitHub repository:
echo    Go to your repository settings ^> Secrets and variables ^> Actions
echo.
echo    Required secrets:
echo    - FTP_HOST: Your cPanel FTP hostname (e.g., ftp.yourdomain.com)
echo    - FTP_USERNAME: Your FTP username  
echo    - FTP_PASSWORD: Your FTP password
echo    - FTP_PATH: Your web root path (e.g., /public_html/)
echo.
echo 2. Push to GitHub to trigger deployment:
echo    git push origin main
echo.
echo 3. Monitor deployment:
echo    Go to the 'Actions' tab in your GitHub repository
echo.
echo 📖 For detailed instructions, see: GITHUB-DEPLOYMENT-GUIDE.md
echo.
echo 🎉 Setup complete! Happy deploying!
echo.
pause
