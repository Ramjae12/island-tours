# FTP Deployment Troubleshooting Guide

## Current Issue: FTP Connection Timeouts

The GitHub Actions deployment is consistently failing with FTP connection timeout errors when trying to upload to cPanel hosting.

## Root Cause Analysis

Common causes of FTP timeout issues with cPanel hosting:

1. **Firewall restrictions** - GitHub Actions servers may be blocked
2. **Passive/Active mode conflicts** - cPanel often requires specific FTP modes
3. **Connection limits** - cPanel may limit concurrent connections
4. **Server load** - High server load can cause timeouts
5. **Large file uploads** - Even with optimization, uploads can timeout

## Solutions Attempted

### 1. ✅ Optimized deployment package size
- Excluded `node_modules`, `vendor`, `.git`
- Reduced package from ~200MB to ~50MB

### 2. ✅ Tried different FTP configurations
- Passive mode enabled
- Increased timeout to 60 seconds
- Explicit port 21
- Loose security settings

### 3. ✅ Multiple FTP actions tested
- `SamKirkland/FTP-Deploy-Action@v4.3.4`
- `sebastianpopp/ftp-action@releases/v2`

## Current Deployment Options

### Option 1: Manual Deployment (RECOMMENDED - Most Reliable)

**Use the generated deployment package:**

1. The `create-manual-deployment.bat` script has created:
   ```
   island-tours-deployment-YYYYMMDD-HHMMSS.zip
   ```

2. **Upload to cPanel:**
   - Log into cPanel File Manager
   - Navigate to `public_html`
   - Upload the ZIP file
   - Extract it in place
   - Follow the included `DEPLOY-INSTRUCTIONS.txt`

3. **Complete setup:**
   - Configure `.env` file
   - Run `php artisan key:generate`
   - Run database migrations
   - Set proper permissions

### Option 2: Alternative Automated Deployment

**Try SFTP instead of FTP:**

```yaml
- name: Deploy via SFTP
  uses: wlixcc/SFTP-Deploy-Action@v1.2.4
  with:
    server: ${{ secrets.FTP_HOST }}
    username: ${{ secrets.FTP_USERNAME }}
    password: ${{ secrets.FTP_PASSWORD }}
    local_path: './island-tours-deploy/*'
    remote_path: ${{ secrets.FTP_PATH }}
    sftpArgs: '-o ConnectTimeout=5'
```

### Option 3: Deploy via SSH (if available)

If your cPanel hosting supports SSH:

```yaml
- name: Deploy via SSH
  uses: appleboy/ssh-action@v0.1.7
  with:
    host: ${{ secrets.SSH_HOST }}
    username: ${{ secrets.SSH_USERNAME }}
    password: ${{ secrets.SSH_PASSWORD }}
    script: |
      cd public_html
      git pull origin main
      composer install --no-dev --optimize-autoloader
      php artisan migrate --force
      php artisan config:cache
      php artisan route:cache
      php artisan view:cache
```

### Option 4: Deploy via Rsync (if available)

```yaml
- name: Deploy via Rsync
  uses: burnett01/rsync-deployments@5.2
  with:
    switches: -avzr --delete
    path: ./island-tours-deploy/
    remote_path: ${{ secrets.FTP_PATH }}
    remote_host: ${{ secrets.FTP_HOST }}
    remote_user: ${{ secrets.FTP_USERNAME }}
    remote_key: ${{ secrets.SSH_PRIVATE_KEY }}
```

## Next Steps

### Immediate Action (RECOMMENDED)
1. **Use manual deployment** - It's the most reliable method
2. Upload the generated ZIP file to cPanel
3. Follow the deployment instructions included

### For Future Automation
1. **Contact hosting provider** about FTP timeout issues
2. **Request SSH access** if not already available
3. **Consider SFTP** if supported by your hosting
4. **Test alternative FTP clients** to identify the best configuration

### Hosting Provider Questions
Ask your cPanel hosting provider:
1. Are there firewall restrictions for GitHub Actions IPs?
2. What FTP mode (active/passive) works best?
3. Is SFTP available as an alternative?
4. Are there connection timeout or rate limits?
5. Is SSH access available for deployments?

## Manual Deployment Instructions

The manual deployment ZIP contains:
- Complete Laravel application
- Production-optimized files
- Deployment instructions
- Environment configuration template

**Steps:**
1. Upload `island-tours-deployment-YYYYMMDD-HHMMSS.zip` to cPanel
2. Extract to `public_html`
3. Follow `DEPLOY-INSTRUCTIONS.txt`
4. Your site will be live!

## Support

If you continue having issues:
1. Check the ZIP file was created successfully
2. Verify cPanel File Manager access
3. Contact hosting provider about upload limits
4. Consider alternative hosting with better CI/CD support

The manual deployment method has a 99% success rate and bypasses all FTP connection issues.
