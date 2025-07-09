# 🎯 cPanel Deployment Checklist

## ✅ Pre-Upload Checklist

- [ ] **cPanel Access Ready**
  - [ ] cPanel login credentials available
  - [ ] File Manager access confirmed
  - [ ] Domain/subdomain configured

- [ ] **Database Setup**
  - [ ] MySQL database created in cPanel
  - [ ] Database user created with full privileges
  - [ ] Database credentials noted down

- [ ] **Application Ready** 
  - [ ] ✅ `cpanel-deployment` folder created
  - [ ] ✅ Production assets built (Laravel Mix)
  - [ ] ✅ All files copied to deployment folder
  - [ ] Ready to compress for upload

---

## 📦 Upload Process

### Step 1: Create ZIP Archive
1. Right-click on `cpanel-deployment` folder
2. Select "Send to > Compressed (zipped) folder"
3. Name it: `island-tours-deployment.zip`

### Step 2: Upload to cPanel
1. Log into your cPanel
2. Open **File Manager**
3. Navigate to `public_html` (or your domain folder)
4. Click **Upload**
5. Upload `island-tours-deployment.zip`
6. Select the ZIP file and click **Extract**
7. Rename extracted folder to `island-tours`

---

## ⚙️ Configuration Checklist

### Step 3: Configure Environment
- [ ] Copy `env-production-template.txt` to `.env`
- [ ] Update database credentials in `.env`:
  ```env
  DB_DATABASE=your_cpanel_database_name
  DB_USERNAME=your_cpanel_db_user  
  DB_PASSWORD=your_cpanel_db_password
  ```
- [ ] Update domain URL in `.env`:
  ```env
  APP_URL=https://yourdomain.com
  ```
- [ ] Configure email settings

### Step 4: Set File Permissions
- [ ] Set folder permissions to 755:
  - `storage/`
  - `bootstrap/cache/`
- [ ] Set `.env` permission to 644

### Step 5: Domain Configuration
- [ ] **Option A**: Point main domain to `island-tours/public/`
- [ ] **Option B**: Create subdomain pointing to `island-tours/public/`

---

## 🗄️ Database Setup

- [ ] **Via SSH** (if available):
  ```bash
  cd public_html/island-tours
  php artisan migrate --force
  php artisan db:seed --force
  ```

- [ ] **Via phpMyAdmin** (if no SSH):
  - [ ] Export local database
  - [ ] Import to cPanel database via phpMyAdmin

---

## 🚀 Production Optimization

### Step 6: Run Production Commands
- [ ] Clear all caches:
  ```bash
  php artisan config:clear
  php artisan cache:clear
  php artisan route:clear
  php artisan view:clear
  ```

- [ ] Cache for production:
  ```bash
  php artisan config:cache
  php artisan route:cache
  php artisan view:cache
  ```

- [ ] Create storage link:
  ```bash
  php artisan storage:link
  ```

---

## 🧪 Testing Checklist

### Step 7: Verify Deployment
- [ ] **Homepage loads**: `https://yourdomain.com`
- [ ] **Admin login works**
- [ ] **User registration works**
- [ ] **Assets load properly** (CSS/JS)
- [ ] **Database connections work**
- [ ] **Forms submit successfully**
- [ ] **Email sending works**
- [ ] **File uploads work**

---

## 🔒 Security & Performance

### Step 8: Final Security Setup
- [ ] **Enable SSL Certificate**
  - [ ] Go to cPanel > SSL/TLS
  - [ ] Install Let's Encrypt (free)
  - [ ] Force HTTPS redirect

- [ ] **Create Admin User**:
  ```bash
  php artisan tinker
  User::create([
      'name' => 'Admin',
      'email' => 'admin@yourdomain.com',
      'password' => Hash::make('secure-password'),
      'email_verified_at' => now()
  ]);
  ```

---

## 📊 Post-Deployment

### Step 9: Monitoring Setup
- [ ] Check error logs in cPanel
- [ ] Monitor `storage/logs/laravel.log`
- [ ] Set up regular backups
- [ ] Test all application features

### Step 10: Documentation
- [ ] Document admin credentials
- [ ] Note database connection details
- [ ] Save backup procedures
- [ ] Create maintenance schedule

---

## 🎉 Go Live!

Once all items are checked:

✅ **Your Island Tours application is LIVE!**

### Access URLs:
- **Frontend**: `https://yourdomain.com`
- **Admin Panel**: `https://yourdomain.com/admin`

### Default Credentials:
- **Email**: admin@yourdomain.com
- **Password**: (as configured in Step 8)

---

## 🆘 Emergency Contacts

### Common Issues:
- **500 Error**: Check file permissions and `.env` config
- **Database Error**: Verify database credentials
- **Assets Not Loading**: Run `php artisan storage:link`
- **Mail Issues**: Check SMTP configuration

### Support Files:
- 📖 `CPANEL-DEPLOYMENT-GUIDE.md` - Complete deployment guide
- 🔧 `FILE-PERMISSIONS.txt` - Permission requirements
- ⚙️ `env-production-template.txt` - Environment configuration

---

**🏝️ Welcome to your live Island Tours booking system!**
