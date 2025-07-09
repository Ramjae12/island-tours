# GitHub Deployment Guide for Island Tours

This guide will help you set up automatic deployment from GitHub to your cPanel hosting whenever you push code changes.

## Prerequisites

1. ✅ GitHub repository (already configured)
2. ✅ cPanel hosting account
3. ✅ FTP access credentials for your hosting

## Step 1: Configure GitHub Secrets

You need to add your FTP credentials as secrets in your GitHub repository:

1. Go to your GitHub repository: https://github.com/Ramjae12/island-tours
2. Click on **Settings** (in the repository menu)
3. In the left sidebar, click **Secrets and variables** → **Actions**
4. Click **New repository secret** for each of the following:

### Required Secrets:

| Secret Name | Description | Example Value |
|------------|-------------|---------------|
| `FTP_HOST` | Your cPanel FTP hostname | `ftp.yourdomain.com` or `yourhosting.com` |
| `FTP_USERNAME` | Your cPanel FTP username | `yourftpuser@yourdomain.com` |
| `FTP_PASSWORD` | Your cPanel FTP password | `your_ftp_password` |
| `FTP_PATH` | Path to web root (optional) | `/public_html/` or `/public_html/subdomain/` |

### How to Add Secrets:
1. Click **New repository secret**
2. Enter the **Name** (e.g., `FTP_HOST`)
3. Enter the **Value** (e.g., `ftp.yourdomain.com`)
4. Click **Add secret**
5. Repeat for all four secrets

## Step 2: Get Your FTP Credentials

### From cPanel:
1. Log into your cPanel
2. Look for **FTP Accounts** or **File Manager**
3. Use your main cPanel credentials or create a new FTP account
4. Note down:
   - **FTP Host**: Usually `ftp.yourdomain.com` or your server's hostname
   - **Username**: Your cPanel username or FTP account username
   - **Password**: Your cPanel password or FTP account password

### Common FTP Host Formats:
- `ftp.yourdomain.com`
- `yourdomain.com`
- `server123.hostingprovider.com`
- Your hosting provider's FTP server

## Step 3: Test the Deployment

1. Make a small change to your code (e.g., edit a comment in a file)
2. Commit and push to GitHub:
   ```bash
   git add .
   git commit -m "Test GitHub deployment"
   git push origin main
   ```
3. Go to your GitHub repository
4. Click on the **Actions** tab
5. Watch the deployment process

## Step 4: What Happens During Deployment

The GitHub Action will:

1. **Run Tests**: Execute your test suite to ensure code quality
2. **Install Dependencies**: Download PHP and Node.js dependencies
3. **Build Assets**: Compile CSS and JavaScript files
4. **Create Package**: Prepare files for deployment
5. **Deploy via FTP**: Upload files to your cPanel hosting

## Step 5: Post-Deployment Setup (First Time Only)

After the first successful deployment, you need to:

1. **Configure Environment File**:
   - Access your cPanel File Manager
   - Navigate to your website's root directory
   - Rename `.env.example` to `.env`
   - Edit `.env` with your production settings:
     ```
     APP_NAME="Island Tours"
     APP_ENV=production
     APP_KEY=
     APP_DEBUG=false
     APP_URL=https://yourdomain.com
     
     DB_CONNECTION=mysql
     DB_HOST=127.0.0.1
     DB_PORT=3306
     DB_DATABASE=your_database_name
     DB_USERNAME=your_database_user
     DB_PASSWORD=your_database_password
     ```

2. **Generate Application Key**:
   - In cPanel Terminal or via Artisan command:
   ```bash
   php artisan key:generate
   ```

3. **Run Database Migrations**:
   ```bash
   php artisan migrate --force
   ```

4. **Set File Permissions**:
   - Ensure `/storage` and `/bootstrap/cache` are writable (755 or 775)

## Step 6: Workflow Summary

### Development Process:
1. Make changes to your code locally
2. Test your changes
3. Commit changes: `git commit -m "Your change description"`
4. Push to GitHub: `git push origin main`
5. GitHub automatically deploys to your hosting

### Benefits:
- ✅ Automatic deployment on every push
- ✅ Runs tests before deployment
- ✅ Builds production assets
- ✅ No manual file uploads needed
- ✅ Version control for all changes

## Troubleshooting

### Common Issues:

1. **FTP Connection Failed**:
   - Double-check FTP credentials
   - Ensure FTP is enabled in cPanel
   - Try passive FTP mode

2. **Permission Denied**:
   - Check file permissions in cPanel
   - Ensure storage/ and bootstrap/cache/ are writable

3. **Environment Configuration**:
   - Verify `.env` file exists and is configured
   - Check database credentials
   - Ensure APP_KEY is generated

4. **Assets Not Loading**:
   - Verify CSS/JS files are built during deployment
   - Check file paths in your templates
   - Clear browser cache

### Getting Help:
- Check the **Actions** tab in GitHub for deployment logs
- Review error messages in the workflow output
- Verify FTP connection details with your hosting provider

## Security Notes

- Never commit `.env` files to GitHub
- Use strong passwords for FTP accounts
- Regularly update your dependencies
- Keep your hosting environment updated

## Next Steps

Once deployment is working:
1. Set up staging environment (optional)
2. Configure domain and SSL certificates
3. Set up database backups
4. Monitor application performance

---

Your Island Tours application is now set up for automatic GitHub deployment! 🚀
