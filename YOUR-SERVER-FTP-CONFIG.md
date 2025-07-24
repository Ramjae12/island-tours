# FTP Credentials for stg-corregidorisland.tieza.online

## Your Server Details

**cPanel URL**: https://103.131.95.116:2083/
**Domain**: https://stg-corregidorisland.tieza.online/
**Server IP**: 103.131.95.116

## GitHub Secrets Configuration

Based on your server setup, here are the exact values to add to GitHub Secrets:

### Secret #1: FTP_HOST
**Name**: `FTP_HOST`
**Value**: `103.131.95.116`
*Alternative values to try if first doesn't work:*
- `ftp.tieza.online`
- `stg-corregidorisland.tieza.online`

### Secret #2: FTP_USERNAME
**Name**: `FTP_USERNAME`
**Value**: Your cPanel username (found in cPanel)

### Secret #3: FTP_PASSWORD
**Name**: `FTP_PASSWORD`
**Value**: Your cPanel password

### Secret #4: FTP_PATH
**Name**: `FTP_PATH`
**Value**: `/public_html/`
*Alternative paths if needed:*
- `/public_html/stg-corregidorisland/`
- `/public_html/tieza.online/public_html/`

## Step-by-Step Setup

### Step 1: Get Your cPanel Username
1. **Go to**: https://103.131.95.116:2083/
2. **Login with your credentials**
3. **Look for "Account Information"** or check the top-right corner for your username

### Step 2: Find FTP Details in cPanel
1. **In cPanel, go to "Files" section**
2. **Click "FTP Accounts"**
3. **Note your main FTP account details**

### Step 3: Add Secrets to GitHub
1. **Go to**: https://github.com/Ramjae12/island-tours/settings/secrets/actions
2. **Click "New repository secret"** for each:

| Secret Name | Value |
|------------|--------|
| `FTP_HOST` | `103.131.95.116` |
| `FTP_USERNAME` | `[Your cPanel username]` |
| `FTP_PASSWORD` | `[Your cPanel password]` |
| `FTP_PATH` | `/public_html/` |

## Testing Your Setup

### Option 1: Test FTP Connection
```cmd
ftp 103.131.95.116
# Enter your username when prompted
# Enter your password when prompted
# Type 'ls' to list files
# Type 'quit' to exit
```

### Option 2: Check Your Current Site
Visit: https://stg-corregidorisland.tieza.online/
- If you see a website, note what's currently there
- After deployment, this will show your Laravel Island Tours app

## Deployment Path Options

**For main domain deployment:**
- **FTP_PATH**: `/public_html/`
- **Result**: Site accessible at https://stg-corregidorisland.tieza.online/

**For subdirectory deployment:**
- **FTP_PATH**: `/public_html/island-tours/`  
- **Result**: Site accessible at https://stg-corregidorisland.tieza.online/island-tours/

## What Happens After Setup

Once you add the GitHub secrets:
1. **Push any change** to your main branch
2. **GitHub Actions will automatically**:
   - Run tests
   - Build production assets
   - Deploy to your server via FTP
3. **Your Laravel app will be live** at https://stg-corregidorisland.tieza.online/

## Need to Find Your cPanel Username?

1. **Login to**: https://103.131.95.116:2083/
2. **Look for**: Account information, usually displayed in the interface
3. **Or check**: The email you received when the hosting was set up

## Common Issues & Solutions

**If FTP_HOST doesn't work with IP:**
- Try: `ftp.tieza.online`
- Try: `stg-corregidorisland.tieza.online`

**If path doesn't work:**
- Check cPanel File Manager to see the exact directory structure
- Look for where your domain's files should be placed

**Ready to proceed?** 
Do you have your cPanel username and password? If yes, we can add these secrets to GitHub right now!
