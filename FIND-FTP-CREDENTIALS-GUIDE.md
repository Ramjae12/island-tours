# How to Find Your cPanel FTP Credentials

## Method 1: Check Your Hosting Provider's Welcome Email

Look for an email from your hosting provider with subject lines like:
- "Welcome to [HostingProvider]"
- "Your Hosting Account Details"
- "cPanel Login Information"
- "FTP Account Details"

**Look for these details in the email:**
- **FTP Host/Server**: Usually `ftp.yourdomain.com` or `server123.hostingprovider.com`
- **Username**: Your cPanel username or email
- **Password**: Your cPanel password
- **Control Panel URL**: Link to your cPanel

## Method 2: Login to Your Hosting Provider's Control Panel

### Popular Hosting Providers:

#### **GoDaddy**
1. Go to: https://www.godaddy.com/hosting/cpanel-login
2. Login with your GoDaddy account
3. Look for "cPanel Admin" or "File Manager"
4. FTP details are usually in "FTP Accounts" section

#### **Hostgator**
1. Go to: https://portal.hostgator.com/
2. Login to your account
3. Go to "Hosting" → "Manage"
4. Click "cPanel Login"
5. In cPanel, find "FTP Accounts"

#### **Bluehost**
1. Go to: https://my.bluehost.com/
2. Login to your account
3. Go to "Advanced" → "cPanel"
4. Look for "FTP Accounts"

#### **SiteGround**
1. Go to: https://my.siteground.com/
2. Login to your account
3. Go to "Sites" → "Site Tools"
4. Find "FTP Manager"

#### **Namecheap**
1. Go to: https://ap.www.namecheap.com/
2. Login to your account
3. Go to "Domain List" → "Manage"
4. Look for "cPanel" or "Hosting"

## Method 3: What to Look For in cPanel

Once you're in cPanel, look for sections named:
- **"FTP Accounts"**
- **"FTP Manager"** 
- **"File Manager"**
- **"Files"** section

## Common FTP Details Format

| Field | Typical Value | Example |
|-------|---------------|---------|
| **FTP Host** | `ftp.yourdomain.com` | `ftp.example.com` |
| **Username** | Your cPanel username | `example123` or `user@example.com` |
| **Password** | Your cPanel password | `YourCpanelPassword123` |
| **Port** | Usually 21 (auto-detected) | `21` |
| **Path** | Web root directory | `/public_html/` |

## Method 4: Contact Your Hosting Provider

If you can't find the details:

1. **Contact support** of your hosting provider
2. **Ask for**: "FTP credentials for my hosting account"
3. **They will provide**:
   - FTP hostname
   - FTP username
   - FTP password (or help you reset it)

## Method 5: Check Your Browser's Saved Passwords

If you've logged into cPanel before:
1. **Chrome**: Settings → Passwords → Search for your domain
2. **Firefox**: Settings → Privacy & Security → Saved Logins
3. **Edge**: Settings → Passwords → Search for your domain

## Next Steps

Once you find your credentials, you'll need:

1. **FTP_HOST**: The FTP server address
2. **FTP_USERNAME**: Your FTP username
3. **FTP_PASSWORD**: Your FTP password  
4. **FTP_PATH**: Usually `/public_html/` for most hosts

## Need More Help?

Tell me:
- **What hosting provider do you use?** (GoDaddy, Hostgator, Bluehost, etc.)
- **Do you remember your domain name?**
- **Have you logged into cPanel before?**

I can give you more specific instructions based on your hosting provider!
