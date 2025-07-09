# 🗄️ Database Setup Guide for cPanel

## Step 1: Create Database in cPanel

1. **Login to cPanel**
2. **Navigate to MySQL Databases**
3. **Create New Database:**
   - Database Name: `island_tours` (or similar)
   - Note the full name (usually prefixed: `username_island_tours`)

## Step 2: Create Database User

1. **In MySQL Databases section:**
   - Username: `island_user` (or similar)
   - Strong password (save this!)
   - Note full username (usually: `username_island_user`)

## Step 3: Assign User to Database

1. **Add User to Database:**
   - Select your database and user
   - Grant **ALL PRIVILEGES**

## Step 4: Import Database Structure

### Option A: Using cPanel phpMyAdmin
1. **Go to phpMyAdmin** in cPanel
2. **Select your database**
3. **Import tab**
4. **Choose your SQL file** from local backup or export

### Option B: Using Database Migration (Recommended)
After files are uploaded and .env configured:

1. **SSH/Terminal Access** (if available):
   ```bash
   cd /path/to/your/domain
   php artisan migrate --force
   php artisan db:seed --force
   ```

2. **Or via cPanel Terminal** (if available)

### Option C: Manual SQL Import
If you have an SQL backup file, import it directly through phpMyAdmin.

## Step 5: Update .env File

Update these values in your .env:
```env
DB_DATABASE=username_island_tours
DB_USERNAME=username_island_user  
DB_PASSWORD=your_secure_password
```

## Important Notes:
- ⚠️ Database names and usernames are usually prefixed with your cPanel username
- 🔒 Use strong passwords for database security
- 📝 Save all credentials in a secure location
- 🔄 Test database connection after setup
