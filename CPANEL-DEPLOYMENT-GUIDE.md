# 🏝️ Island Tours - Complete cPanel Deployment Guide

## 🚀 Pre-Deployment Checklist

✅ **Local Development Complete**
- ✅ Application tested locally
- ✅ Laravel Mix build successful
- ✅ Database migrations ready
- ✅ All features working

✅ **cPanel Hosting Requirements**
- ✅ PHP 8.1+ enabled
- ✅ MySQL database available
- ✅ SSH access (optional but recommended)
- ✅ File Manager access
- ✅ Subdomain or domain ready

---

## 📋 Step 1: Prepare Your cPanel Environment

### 1.1 Create Database
1. Log into cPanel
2. Go to **MySQL Databases**
3. Create a new database (e.g., `yourname_island_tours`)
4. Create a database user
5. Add user to database with **ALL PRIVILEGES**
6. **Note down**: Database name, username, password

### 1.2 Create Subdomain (Optional)
1. Go to **Subdomains** in cPanel
2. Create subdomain: `tours.yourdomain.com`
3. Set document root to: `public_html/island-tours/public`

---

## 📦 Step 2: Upload Your Application

### Method A: File Manager Upload (Recommended)
1. **Compress your project** (excluding):
   - `node_modules/`
   - `.git/`
   - `storage/logs/*`
   - `storage/framework/cache/*`
   - `storage/framework/sessions/*`
   - `storage/framework/views/*`

2. **Upload via File Manager**:
   - Upload ZIP to `public_html/island-tours/`
   - Extract the files

### Method B: FTP Upload
1. Use FileZilla or similar FTP client
2. Upload all files to `/public_html/island-tours/`
3. Skip the excluded folders mentioned above

---

## ⚙️ Step 3: Configure Environment

### 3.1 Create Production .env File
1. Copy `env-production-template.txt` content
2. Create new file: `.env` in root directory
3. Update these values:

```env
APP_NAME="Island Tours"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://tours.yourdomain.com

# Your cPanel Database Details
DB_CONNECTION=mysql
DB_HOST=localhost
DB_DATABASE=yourname_island_tours
DB_USERNAME=yourname_dbuser
DB_PASSWORD=your_db_password

# Your Email Settings
MAIL_HOST=mail.yourdomain.com
MAIL_USERNAME=noreply@yourdomain.com
MAIL_PASSWORD=your_email_password
MAIL_FROM_ADDRESS="noreply@yourdomain.com"
```

### 3.2 Set File Permissions
```bash
# Via SSH or File Manager
chmod 755 storage
chmod 755 bootstrap/cache
chmod 644 .env
```

---

## 🗄️ Step 4: Setup Database

### 4.1 Run Migrations (SSH Method)
```bash
cd public_html/island-tours
php artisan migrate --force
php artisan db:seed --force
```

### 4.2 Alternative: Import SQL (if SSH not available)
1. Export your local database
2. Import via **phpMyAdmin** in cPanel
3. Update any local URLs in the database

---

## 🌐 Step 5: Configure Web Server

### 5.1 Point Domain to Public Folder

**Option A: Main Domain**
- Move contents of `public/` to `public_html/`
- Update `index.php` paths to point to Laravel root

**Option B: Subdomain (Recommended)**
- Set document root to: `/public_html/island-tours/public`

### 5.2 Update .htaccess (if needed)
The included `.htaccess` should work, but if you have issues:

```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteRule ^(.*)$ public/$1 [L]
</IfModule>
```

---

## 🔧 Step 6: Production Optimization

### 6.1 Run Production Commands (SSH)
```bash
cd public_html/island-tours

# Clear caches
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Cache for production
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Create storage link
php artisan storage:link
```

### 6.2 Set Production File Permissions
```bash
find . -type f -exec chmod 644 {} \;
find . -type d -exec chmod 755 {} \;
chmod -R 755 storage
chmod -R 755 bootstrap/cache
```

---

## 🧪 Step 7: Testing

### 7.1 Basic Tests
- ✅ Homepage loads: `https://tours.yourdomain.com`
- ✅ Admin login works
- ✅ User registration works  
- ✅ Database connections work
- ✅ Email sending works
- ✅ File uploads work

### 7.2 Performance Tests
- ✅ CSS/JS assets load
- ✅ Images display correctly
- ✅ Forms submit successfully
- ✅ Admin panel accessible

---

## 🔒 Step 8: Security & SSL

### 8.1 Setup SSL Certificate
1. Go to **SSL/TLS** in cPanel
2. Choose **Let's Encrypt** (free)
3. Enable **Force HTTPS Redirect**

### 8.2 Security Headers (Optional)
Add to `.htaccess` in public folder:

```apache
<IfModule mod_headers.c>
    Header always set X-Content-Type-Options nosniff
    Header always set X-Frame-Options DENY
    Header always set X-XSS-Protection "1; mode=block"
    Header always set Strict-Transport-Security "max-age=31536000; includeSubDomains"
</IfModule>
```

---

## 🎯 Step 9: Create Admin User

### Via SSH:
```bash
php artisan tinker
User::create([
    'name' => 'Admin',
    'email' => 'admin@yourdomain.com',
    'password' => Hash::make('your-secure-password'),
    'email_verified_at' => now()
]);
```

### Via Database:
1. Open phpMyAdmin
2. Insert into `users` table with hashed password

---

## 📊 Step 10: Monitoring & Maintenance

### 10.1 Log Monitoring
- Check: `storage/logs/laravel.log`
- Monitor for errors via cPanel Error Logs

### 10.2 Regular Maintenance
```bash
# Weekly maintenance
php artisan cache:clear
php artisan view:clear
php artisan queue:restart (if using queues)
```

### 10.3 Backup Strategy
- Database: Weekly exports via phpMyAdmin
- Files: Regular downloads of `/storage/app/public`
- Code: Keep in version control (Git)

---

## 🚨 Troubleshooting

### Common Issues & Solutions

**500 Internal Server Error**
- Check file permissions (755 for directories, 644 for files)
- Check `.env` file configuration
- Check storage folder permissions
- Review error logs

**Database Connection Error**
- Verify database credentials in `.env`
- Check if database user has correct privileges
- Test connection via phpMyAdmin

**Assets Not Loading**
- Run `php artisan storage:link`
- Check `mix-manifest.json` exists
- Verify asset paths in views

**Mail Not Sending**
- Test SMTP settings
- Check spam folders
- Verify mail server configuration

---

## 📞 Post-Deployment Support

### Essential Commands for cPanel
```bash
# Check Laravel installation
php artisan --version

# Check environment
php artisan env

# Clear everything
php artisan optimize:clear

# Cache everything for production
php artisan optimize
```

### File Locations
- **Application Root**: `/public_html/island-tours/`
- **Public Files**: `/public_html/island-tours/public/`
- **Logs**: `/public_html/island-tours/storage/logs/`
- **Config**: `/public_html/island-tours/.env`

---

## 🎉 Deployment Complete!

Your Island Tours application should now be live at:
**https://tours.yourdomain.com**

### Default Login Credentials
- **Admin**: admin@yourdomain.com
- **Password**: (as created in Step 9)

### Next Steps
1. Update all placeholder content
2. Configure email templates
3. Set up regular backups
4. Monitor application performance
5. Plan for scaling if needed

---

**🏝️ Welcome to your live Island Tours booking system!**
