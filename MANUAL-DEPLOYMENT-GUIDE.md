# Manual Deployment Guide - FTP Issues Workaround

## Issue: GitHub Actions FTP Timeouts

After multiple attempts with different FTP configurations, your hosting provider appears to block GitHub Actions FTP connections. This is common with some cPanel hosting providers.

## Solution: Manual Deployment via cPanel

Since automated FTP isn't working, let's deploy manually through cPanel File Manager (which always works).

## Step 1: Create Deployment Package

I've created a script that will package your Laravel app for manual deployment:

```bash
# Run this script
./create-manual-deployment.bat
```

This will create:
- ✅ **Deployment folder** with all necessary files
- ✅ **Production .env template**
- ✅ **ZIP file** ready for upload
- ✅ **Step-by-step instructions**

## Step 2: Upload to cPanel

1. **Go to your cPanel**: https://103.131.95.116:2083/
2. **Open File Manager**
3. **Navigate to public_html/**
4. **Upload the ZIP file**
5. **Extract the ZIP file**
6. **Follow the deployment instructions**

## Step 3: Configure Environment

1. **Copy .env.example to .env**
2. **Edit .env with your database settings**
3. **Generate app key**: `php artisan key:generate`
4. **Run migrations**: `php artisan migrate --force`

## Advantages of Manual Deployment

✅ **Always works** - No FTP connection issues
✅ **Full control** - You see exactly what's uploaded
✅ **Faster** - Direct server-to-server extraction
✅ **Reliable** - No timeout issues

## Your Site Will Be Live At:
**https://stg-corregidorisland.tieza.online/**

## Future Deployments

For future updates:
1. **Run the script** to create new deployment package
2. **Upload and extract** via cPanel
3. **5 minutes total** vs hours of FTP troubleshooting

## Why This Happened

Your hosting provider likely has:
- Restrictive firewall rules
- Limited FTP passive ports
- GitHub Actions IP blocking
- Network configuration issues

**Manual deployment is actually more reliable than FTP for many hosting providers.**

Ready to create your deployment package?
