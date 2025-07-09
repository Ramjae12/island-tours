# GitHub Deployment - Quick Reference

## 🚀 How It Works

1. **You push code** → GitHub automatically deploys to your hosting
2. **Tests run first** → Ensures code quality before deployment  
3. **Assets are built** → CSS/JS files are compiled for production
4. **Files are uploaded** → Via FTP to your cPanel hosting

## ⚡ Quick Setup (5 minutes)

### Step 1: Add FTP Secrets to GitHub
Go to: `GitHub Repository > Settings > Secrets and variables > Actions`

Add these 4 secrets:
- `FTP_HOST` → Your hosting FTP address (e.g., `ftp.yourdomain.com`)
- `FTP_USERNAME` → Your FTP username
- `FTP_PASSWORD` → Your FTP password  
- `FTP_PATH` → Upload path (usually `/public_html/`)

### Step 2: Deploy
```bash
git add .
git commit -m "Setup GitHub deployment"
git push origin main
```

### Step 3: Monitor
- Go to GitHub → Actions tab
- Watch the deployment progress
- Check your website when complete

## 📋 First Time Setup (on hosting)

After first deployment, configure these files on your server:

1. **Rename `.env.example` to `.env`**
2. **Edit `.env` with your database settings:**
   ```
   APP_URL=https://yourdomain.com
   DB_DATABASE=your_database_name
   DB_USERNAME=your_db_user
   DB_PASSWORD=your_db_password
   ```
3. **Generate app key:** `php artisan key:generate`
4. **Run migrations:** `php artisan migrate --force`

## 🔄 Daily Workflow

```bash
# 1. Make changes to your code
# 2. Test locally
# 3. Commit and push
git add .
git commit -m "Your changes description"
git push origin main
# 4. GitHub automatically deploys!
```

## 🆘 Common Issues

| Problem | Solution |
|---------|----------|
| FTP connection fails | Check FTP credentials in GitHub secrets |
| Files not uploading | Verify FTP_PATH is correct (usually `/public_html/`) |
| Website shows errors | Check `.env` file configuration on server |
| CSS/JS not loading | Clear browser cache, check file permissions |

## 📞 Need Help?

1. Check GitHub Actions logs (GitHub → Actions tab)
2. Verify FTP settings with your hosting provider
3. Review the detailed guide: `GITHUB-DEPLOYMENT-GUIDE.md`

---

**✅ You're all set! Your Island Tours app now deploys automatically via GitHub!**
