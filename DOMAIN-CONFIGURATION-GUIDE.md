# 🌐 Domain & Document Root Configuration

## Step 1: Set Document Root (Important!)

### For Main Domain:
If deploying to your **main domain** (yourdomain.com):

1. **Upload files to:** `/public_html/`
2. **Document root should point to:** `/public_html/public/`

### For Subdomain:
If deploying to a **subdomain** (tours.yourdomain.com):

1. **Create subdomain** in cPanel
2. **Upload files to:** `/public_html/tours/` (or subdomain folder)
3. **Document root should point to:** `/public_html/tours/public/`

## Step 2: Configure Document Root in cPanel

### Method A: Subdomain Document Root
1. **cPanel → Subdomains**
2. **Edit your subdomain**
3. **Set Document Root to:** `public_html/tours/public`

### Method B: Main Domain (Advanced)
If using main domain, you need to:
1. **Move all Laravel files** to `/public_html/`
2. **Move contents of `/public/` folder** to `/public_html/`
3. **Update `index.php`** to point to correct paths:

```php
// In index.php, update these lines:
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
```

## Step 3: .htaccess Configuration

### For Subdomain Setup (Recommended):
Your `.htaccess` in `/public/` should work as-is.

### For Main Domain Setup:
You may need to update URL rewriting rules.

## Step 4: Test Your Setup

1. **Visit your domain:** `https://yourdomain.com` or `https://tours.yourdomain.com`
2. **Check for Laravel welcome page** or your application home page
3. **Test routes:** Try navigating to different pages

## Common Issues & Solutions:

### "500 Internal Server Error"
- Check file permissions (755 for folders, 644 for files)
- Verify `.env` file configuration
- Check error logs in cPanel

### "404 Not Found" for routes
- Ensure `.htaccess` is in the correct directory
- Verify mod_rewrite is enabled
- Check document root configuration

### Database Connection Errors
- Verify database credentials in `.env`
- Ensure database user has proper privileges
- Check database host (usually 'localhost')

## Security Recommendations:
- 🔒 Use HTTPS (SSL certificate)
- 🚫 Hide Laravel files outside web root
- 🔐 Secure .env file permissions (644)
- 🛡️ Enable security headers
