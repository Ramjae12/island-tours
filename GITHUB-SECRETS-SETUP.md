# GitHub Secrets Setup for Island Tours Deployment

## Quick Setup Checklist

### Step 1: Go to GitHub Repository
🔗 **URL**: https://github.com/Ramjae12/island-tours/settings/secrets/actions

### Step 2: Add These 4 Secrets

| Secret Name | What It Is | YOUR EXACT VALUE |
|------------|------------|------------------|
| `FTP_HOST` | Your FTP server address | `103.131.95.116` |
| `FTP_USERNAME` | Your FTP login username | `stgcorregidorisl` |
| `FTP_PASSWORD` | Your FTP login password | `[Your cPanel password]` |
| `FTP_PATH` | Where to deploy files | `/public_html/` |

### Step 3: How to Add Each Secret

1. Click **"New repository secret"**
2. Enter the **Name** (exactly as shown above)
3. Enter your **Value** 
4. Click **"Add secret"**
5. Repeat for all 4 secrets

### Step 4: Test the Deployment

After adding all secrets:
1. Make a small change to any file (like this README)
2. Commit and push to GitHub
3. Go to Actions tab to watch deployment succeed! ✅

## Finding Your FTP Credentials

### Method 1: cPanel
1. Log into your cPanel
2. Look for "FTP Accounts" section
3. Use your main cPanel credentials or create new FTP account

### Method 2: Hosting Provider Email
Check your hosting welcome email for FTP details

### Method 3: Contact Your Host
If unsure, ask your hosting provider for:
- FTP hostname
- FTP username  
- FTP password
- Web root directory path

## Common FTP Paths by Host

| Hosting Provider | Common FTP_PATH |
|-----------------|----------------|
| cPanel (most) | `/public_html/` |
| Hostgator | `/public_html/` |
| Bluehost | `/public_html/` |
| GoDaddy | `/public_html/` |
| SiteGround | `/public_html/` |

## After Setup - Your Site Will Be Live!

Once secrets are added, every push to `main` branch will:
1. ✅ Run tests
2. ✅ Build production assets
3. ✅ Deploy to your cPanel hosting
4. ✅ Your Island Tours app will be live at: https://stg-corregidorisland.tieza.online/

## UPDATED: GitHub Secrets Added! 🎉

## Need Help?

If you get stuck:
1. Check the Actions tab for error messages
2. Verify your FTP credentials work in an FTP client
3. Make sure FTP_PATH exists on your server
