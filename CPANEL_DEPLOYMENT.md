# cPanel/WHM Deployment Guide for Island Tours

## Prerequisites
- cPanel hosting account with PHP 8.2+ support
- SSH access (optional but recommended)
- File Manager access via cPanel
- MySQL database access

## Deployment Steps

### Method 1: Using Git (Recommended if SSH is available)

1. **Enable Git in cPanel:**
   - Login to cPanel
   - Go to "Git™ Version Control"
   - Click "Create Repository"
   - Repository URL: `https://github.com/yourusername/island-tours.git`
   - Repository Path: `public_html/island-tours` (or your preferred directory)

2. **Set up the application:**
   ```bash
   cd public_html/island-tours
   composer install --no-dev --optimize-autoloader
   cp .env.example .env
   php artisan key:generate
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

### Method 2: Manual Upload

1. **Download your repository as ZIP from GitHub**
2. **Upload via cPanel File Manager:**
   - Extract the ZIP file to `public_html/island-tours`
   - Or extract to root and move contents to `public_html`

3. **Set up via cPanel Terminal or SSH:**
   ```bash
   cd public_html/island-tours
   composer install --no-dev --optimize-autoloader
   ```

### Step 3: Database Setup

1. **Create MySQL Database in cPanel:**
   - Go to "MySQL Databases"
   - Create database: `your_username_island_tours`
   - Create user and assign to database
   - Note down: database name, username, password, host

2. **Configure .env file:**
   ```env
   APP_NAME="Island Tours"
   APP_ENV=production
   APP_KEY=base64:your-generated-key-here
   APP_DEBUG=false
   APP_URL=https://yourdomain.com

   LOG_CHANNEL=single
   LOG_DEPRECATIONS_CHANNEL=null
   LOG_LEVEL=error

   DB_CONNECTION=mysql
   DB_HOST=localhost
   DB_PORT=3306
   DB_DATABASE=your_username_island_tours
   DB_USERNAME=your_db_username
   DB_PASSWORD=your_db_password

   BROADCAST_DRIVER=log
   CACHE_DRIVER=file
   FILESYSTEM_DISK=local
   QUEUE_CONNECTION=sync
   SESSION_DRIVER=file
   SESSION_LIFETIME=120
   ```

### Step 4: Run Migrations

Via SSH or cPanel Terminal:
```bash
php artisan migrate --force
php artisan db:seed --force
```

### Step 5: Set Permissions

```bash
chmod -R 755 storage
chmod -R 755 bootstrap/cache
chmod 644 .env
```

### Step 6: Configure Document Root

**Option A: Subdomain/Addon Domain**
- Point document root to: `/public_html/island-tours/public`

**Option B: Main Domain**
- Move contents of `/public` folder to `/public_html/`
- Update `/public_html/index.php` to point to correct paths

### Important Notes

- Most shared hosting providers don't allow `composer install` directly
- You may need to install dependencies locally and upload the `vendor` folder
- Some providers offer Node.js support for building assets
- Always backup your database before migrations

### Troubleshooting

1. **500 Internal Server Error:**
   - Check file permissions
   - Verify .env configuration
   - Check error logs in cPanel

2. **Composer Issues:**
   - Install dependencies locally
   - Upload the complete `vendor` folder via FTP

3. **Database Connection Issues:**
   - Verify database credentials
   - Check if remote MySQL connections are allowed

## File Structure After Deployment

```
public_html/
├── island-tours/
│   ├── app/
│   ├── config/
│   ├── database/
│   ├── public/          # Laravel public folder
│   ├── resources/
│   ├── routes/
│   ├── storage/
│   ├── vendor/
│   ├── .env
│   ├── artisan
│   └── composer.json
└── (other files if main domain)
```

## Production Optimizations

After deployment, run these commands:
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan storage:link
```
