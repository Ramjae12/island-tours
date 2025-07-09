# 📁 FTP Upload Instructions for Island Tours

## Using FileZilla or Similar FTP Client

### Connection Details (Get from your hosting provider):
- **Host:** ftp.yourdomain.com
- **Username:** your-cpanel-username
- **Password:** your-cpanel-password
- **Port:** 21 (or 22 for SFTP)

### Upload Steps:
1. Connect to your server via FTP
2. Navigate to `/public_html/` (or your domain folder)
3. Upload ALL contents from `cpanel-deployment` folder
4. Maintain folder structure exactly as is

### Important Folders to Upload:
- `/app/` - Core application files
- `/bootstrap/` - Framework bootstrap files
- `/config/` - Configuration files
- `/database/` - Database files and migrations
- `/public/` - Web-accessible files
- `/resources/` - Views, assets, language files
- `/routes/` - Application routes
- `/storage/` - File storage and logs
- `/vendor/` - Dependencies (large folder)
- All root files (.htaccess, index.php, etc.)

### File Permissions After Upload:
- Folders: 755
- Files: 644
- `/storage/` and subfolders: 755
- `/bootstrap/cache/`: 755
