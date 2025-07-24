# Bitbucket Pipelines Deployment for Island Tours

## Overview

Yes, you can definitely use **Bitbucket Pipelines** instead of GitHub Actions for automated deployment to your cPanel hosting. Bitbucket offers similar CI/CD capabilities.

## Bitbucket vs GitHub for Deployment

| Feature | Bitbucket Pipelines | GitHub Actions |
|---------|-------------------|----------------|
| **Free minutes** | 50 minutes/month | 2000 minutes/month |
| **Security** | ✅ Encrypted secrets | ✅ Encrypted secrets |
| **FTP deployment** | ✅ Supported | ✅ Supported |
| **Laravel support** | ✅ Full support | ✅ Full support |
| **Ease of setup** | ✅ Similar | ✅ Similar |

## Option 1: Migrate to Bitbucket

### Step 1: Create Bitbucket Repository
1. **Go to**: https://bitbucket.org/
2. **Create account** (if you don't have one)
3. **Create new repository**: `island-tours`

### Step 2: Migrate Your Code
```bash
# Add Bitbucket as remote
git remote add bitbucket https://bitbucket.org/yourusername/island-tours.git

# Push to Bitbucket
git push bitbucket main
```

### Step 3: Create bitbucket-pipelines.yml
Create this file in your project root:

```yaml
# bitbucket-pipelines.yml
image: php:8.2

pipelines:
  default:
    - step:
        name: Test and Deploy
        caches:
          - composer
          - node
        services:
          - mysql
        script:
          # Install PHP dependencies
          - apt-get update && apt-get install -y git unzip nodejs npm
          - curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
          - composer install --no-dev --optimize-autoloader --no-interaction
          
          # Install Node dependencies and build assets
          - npm ci
          - npm run build
          
          # Run tests
          - cp .env.example .env
          - php artisan key:generate
          - touch database/database.sqlite
          - php artisan test
          
          # Deploy via FTP
          - apt-get install -y lftp
          - |
            lftp -c "
            open -u $FTP_USERNAME,$FTP_PASSWORD $FTP_HOST;
            set ftp:ssl-allow no;
            mirror -R --delete --verbose . $FTP_PATH --exclude-glob .git* --exclude-glob node_modules --exclude-glob tests --exclude-glob .env.example;
            quit;
            "

definitions:
  services:
    mysql:
      image: mysql:8.0
      variables:
        MYSQL_DATABASE: laravel_test
        MYSQL_ROOT_PASSWORD: password
```

### Step 4: Add Repository Variables (Bitbucket Secrets)
1. **Go to your Bitbucket repository**
2. **Settings** → **Repository settings** → **Repository variables**
3. **Add these variables**:

| Variable Name | Value | Secured |
|--------------|-------|---------|
| `FTP_HOST` | `103.131.95.116` | ✅ Yes |
| `FTP_USERNAME` | `stgcorregidorisl` | ✅ Yes |
| `FTP_PASSWORD` | `[Your cPanel password]` | ✅ Yes |
| `FTP_PATH` | `/public_html/` | No |

## Option 2: Use Both GitHub and Bitbucket

You can keep your current GitHub setup and also push to Bitbucket:

```bash
# Add Bitbucket as additional remote
git remote add bitbucket https://bitbucket.org/yourusername/island-tours.git

# Push to both
git push origin main        # GitHub
git push bitbucket main     # Bitbucket
```

## Option 3: Stay with GitHub (Recommended)

**Why I recommend staying with GitHub:**

### ✅ **Advantages of GitHub Actions:**
- **More free minutes** (2000 vs 50 per month)
- **Larger community** and more examples
- **Better documentation** for Laravel deployment
- **You already have it set up** (just need to add secrets)
- **More third-party integrations**

### Current GitHub Setup Status:
- ✅ Repository exists
- ✅ Workflow file ready
- ❌ Only missing: FTP secrets (5 minutes to add)

## My Recommendation

**Stick with GitHub** because:
1. **You're 95% done** - just need to add 4 secrets
2. **40x more free minutes** than Bitbucket
3. **Better Laravel support** in the ecosystem
4. **Already configured and tested**

## Quick GitHub Completion

To finish your GitHub setup right now:

1. **Go to**: https://github.com/Ramjae12/island-tours/settings/secrets/actions
2. **Add 4 secrets**:
   - `FTP_HOST`: `103.131.95.116`
   - `FTP_USERNAME`: `stgcorregidorisl`
   - `FTP_PASSWORD`: [Your cPanel password]
   - `FTP_PATH`: `/public_html/`
3. **Push any small change**
4. **Watch deployment succeed**

## If You Still Prefer Bitbucket

I can help you set up Bitbucket Pipelines, but you'll need to:
1. **Create Bitbucket account**
2. **Create repository**
3. **Add the pipeline file**
4. **Configure repository variables**
5. **Push your code**

**What would you prefer?**
- ✅ **Finish GitHub setup** (5 minutes, you're almost done)
- 🔄 **Switch to Bitbucket** (30 minutes, start over)
- 📚 **Learn about both options** first

The functionality is essentially the same - both will automatically deploy your Laravel app to your cPanel hosting when you push code changes.
