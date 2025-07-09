# 🏝️ Island Tours - Complete cPanel Deployment Guide

## 📋 Pre-Deployment Checklist

### ✅ Local Development Complete
- [ ] All features tested locally
- [ ] Database migrations are finalized
- [ ] Production assets built (`npm run production`)
- [ ] No critical errors in logs
- [ ] All environment variables documented

### ✅ cPanel Account Requirements
- [ ] PHP 8.2+ enabled
- [ ] MySQL database available
- [ ] Composer access (SSH or cPanel Terminal)
- [ ] File Manager access
- [ ] Domain/subdomain configured

## 🚀 Step-by-Step Deployment Process

### Step 1: Create Deployment Package
```bash
# Run the deployment package creator
create-deployment-package.bat
```

This will create a timestamped ZIP file ready for upload.

### Step 2: Upload to cPanel
1. **Login to cPanel**
2. **Open File Manager**
3. **Navigate to target directory:**
   - Main domain: `public_html/`
   - Subdomain: `public_html/subdomain/`
4. **Upload the ZIP package**
5. **Extract the ZIP file**

### Step 3: Database Setup
1. **Create MySQL Database:**
   - Go to "MySQL Databases" in cPanel
   - Create database: `yourusername_island_tours`
   - Create user with strong password
   - Assign user to database with ALL PRIVILEGES

2. **Note database credentials:**
   - Database Host: Usually `localhost`
   - Database Name: `yourusername_island_tours`
   - Username: `yourusername_dbuser`
   - Password: [your secure password]

### Step 4: Environment Configuration
1. **Edit .env file:**
   ```env
   APP_NAME="Island Tours"
   APP_ENV=production
   APP_KEY=[will be generated]
   APP_DEBUG=false
   APP_URL=https://yourdomain.com

   DB_CONNECTION=mysql
   DB_HOST=localhost
   DB_PORT=3306
   DB_DATABASE=yourusername_island_tours
   DB_USERNAME=yourusername_dbuser
   DB_PASSWORD=your_secure_password

   LOG_LEVEL=error
   ```

### Step 5: Install Dependencies & Setup
**Via SSH (Recommended):**
```bash
cd public_html/island-tours  # or your directory
composer install --no-dev --optimize-autoloader
php artisan key:generate
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan storage:link
```

**Via cPanel Terminal:**
1. Open "Terminal" in cPanel
2. Run the same commands above

### Step 6: File Permissions
Set correct permissions:
```bash
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/
```

### Step 7: Domain Configuration

**Option A: Main Domain**
1. Move contents of `public/` to `public_html/`
2. Update `index.php` paths:
   ```php
   require __DIR__.'/bootstrap/app.php';
   ```

**Option B: Subdirectory**
1. Keep structure as-is
2. Point domain to `public/` folder via cPanel

## 🔧 Post-Deployment Testing

### ✅ Basic Functionality
- [ ] Homepage loads correctly
- [ ] Database connection working
- [ ] User registration/login
- [ ] Booking form functionality
- [ ] Admin panel access
- [ ] Email notifications (if configured)

### ✅ Performance & Security
- [ ] SSL certificate installed
- [ ] HTTPS redirect working
- [ ] Static assets loading
- [ ] Error pages display correctly
- [ ] Backup system in place

## 🚨 Troubleshooting Guide

### Common Issues & Solutions

#### 1. **500 Internal Server Error**
**Causes:**
- Incorrect file permissions
- Missing .env file
- PHP version incompatibility

**Solutions:**
```bash
# Check PHP version
php -v

# Fix permissions
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/

# Clear caches
php artisan config:clear
php artisan cache:clear
```

#### 2. **Database Connection Error**
**Check:**
- Database credentials in .env
- Database exists and user has permissions
- Database host (might not be localhost)

#### 3. **Missing Dependencies**
```bash
# Reinstall composer dependencies
composer install --no-dev --optimize-autoloader

# If composer not available, upload vendor/ folder manually
```

#### 4. **Asset Loading Issues**
**Solutions:**
- Ensure `public/build/` folder is uploaded
- Check APP_URL in .env
- Verify .htaccess rules

#### 5. **Storage Link Error**
```bash
# Remove existing link and recreate
rm public/storage
php artisan storage:link
```

#### 6. **Email Not Working**
**Check:**
- MAIL_* settings in .env
- cPanel email configuration
- Consider using services like Mailgun or SendGrid

## 📊 Performance Optimization

### Production Optimizations
```bash
# Enable OPCache in cPanel PHP settings
# Cache configurations
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Optimize Composer autoloader
composer dump-autoload --optimize
```

### Monitoring & Maintenance
- **Regular Backups:** Database + files
- **Log Monitoring:** `storage/logs/laravel.log`
- **Security Updates:** Keep Laravel and dependencies updated
- **Performance:** Monitor response times and database queries

## 🔐 Security Checklist

### ✅ Production Security
- [ ] APP_DEBUG=false
- [ ] Strong database passwords
- [ ] SSL certificate installed
- [ ] File permissions correctly set
- [ ] Error reporting disabled
- [ ] Regular security updates

### ✅ File Permissions
```
Folders: 755
Files: 644
storage/: 755
bootstrap/cache/: 755
```

## 📞 Support & Resources

### Getting Help
1. **Laravel Documentation:** https://laravel.com/docs
2. **cPanel Documentation:** Check your hosting provider
3. **Error Logs:** `storage/logs/laravel.log`
4. **Server Logs:** cPanel Error Logs section

### Backup Strategy
1. **Database Backup:** 
   ```bash
   mysqldump -u username -p database_name > backup.sql
   ```
2. **File Backup:** Download entire application folder
3. **Automated Backups:** Configure cPanel backup system

---

## 🎉 Congratulations!

Your Island Tours application should now be successfully deployed on cPanel! 

Remember to:
- Test all functionality thoroughly
- Set up monitoring and backups
- Keep your application updated
- Monitor logs for any issues

Need help? Check the troubleshooting section above or consult your hosting provider's documentation.
