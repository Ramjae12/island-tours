# Finding FTP Credentials in WHM/cPanel

## Method 1: Using cPanel (Recommended)

### Step 1: Access Your cPanel
1. **Login to your cPanel** (usually at one of these URLs):
   - `https://yourdomain.com/cpanel`
   - `https://yourdomain.com:2083`
   - `https://server.yourhost.com:2083`
   - Or through your hosting provider's client area

### Step 2: Find FTP Accounts Section
1. **Look for the "Files" section** in cPanel
2. **Click on "FTP Accounts"**
3. You'll see a list of existing FTP accounts

### Step 3: Get Your FTP Details
**Option A: Use Main cPanel Account**
- **FTP Host**: Usually `ftp.yourdomain.com` or your server's hostname
- **Username**: Your main cPanel username
- **Password**: Your cPanel password
- **Path**: `/public_html/` (for main domain)

**Option B: Create New FTP Account (Recommended)**
1. **Click "Create FTP Account"** in cPanel
2. **Enter details**:
   - Username: `deployment` (or any name you prefer)
   - Password: Create a strong password
   - Directory: `/public_html/` (or subdirectory if needed)
   - Quota: Unlimited (or sufficient space)
3. **Click "Create FTP Account"**

## Method 2: Using WHM (If You Have Admin Access)

### Step 1: Access WHM
1. **Login to WHM** (usually at):
   - `https://yourdomain.com:2087`
   - `https://server.yourhost.com:2087`

### Step 2: Find Account Information
1. **Go to "Account Information"** → **"List Accounts"**
2. **Find your domain** in the list
3. **Note the username** (this is your cPanel username)

### Step 3: Access cPanel from WHM
1. **Click the cPanel icon** next to your domain
2. **Follow Method 1 above** to get FTP details

## Quick Setup for GitHub Secrets

Once you have your details, here's what to enter in GitHub:

### FTP_HOST Examples:
```
ftp.yourdomain.com
yourdomain.com
server123.yourhost.com
```

### FTP_USERNAME Examples:
```
your_cpanel_username
deployment_user (if you created a new FTP account)
```

### FTP_PASSWORD:
- Your cPanel password, OR
- The password for the FTP account you created

### FTP_PATH Examples:
```
/public_html/                    (for main domain)
/public_html/subdomain/          (for subdomain)
/public_html/island-tours/       (for subfolder)
```

## Testing Your FTP Connection

Before adding to GitHub, test your FTP credentials:

### Using Windows Command Line:
```cmd
ftp ftp.yourdomain.com
# Enter username when prompted
# Enter password when prompted
# If successful, type: quit
```

### Using FileZilla (Free FTP Client):
1. Download FileZilla from: https://filezilla-project.org/
2. Enter your FTP details
3. Connect to test

## Common cPanel FTP Scenarios

### Scenario 1: Main Domain Deployment
- **FTP_PATH**: `/public_html/`
- **Result**: Site accessible at `https://yourdomain.com`

### Scenario 2: Subdirectory Deployment  
- **FTP_PATH**: `/public_html/island-tours/`
- **Result**: Site accessible at `https://yourdomain.com/island-tours`

### Scenario 3: Subdomain Deployment
- **FTP_PATH**: `/public_html/subdomain/`
- **Result**: Site accessible at `https://subdomain.yourdomain.com`

## Security Best Practice

**Create a dedicated FTP user** for deployment:
1. **In cPanel** → **FTP Accounts** → **Create FTP Account**
2. **Username**: `github-deploy`
3. **Password**: Strong password
4. **Directory**: `/public_html/` (or your target directory)
5. **Quota**: Set appropriate limit

This way, you're not using your main cPanel credentials for automated deployment.

## Need Help?

If you're having trouble:
1. **What's your domain name?** (helps identify the correct FTP host)
2. **Can you access cPanel?** If yes, follow Method 1
3. **Do you have WHM access?** If yes, you can use Method 2
4. **What's your server hostname?** (sometimes shown in your hosting welcome email)
