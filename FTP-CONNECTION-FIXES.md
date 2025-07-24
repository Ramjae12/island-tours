# FTP Connection Issues - Alternative Solutions

## Current Issue: FTP Data Connection Timeout

**Error**: `Timeout when trying to open data connection to ***:56133`

This is a common issue with cPanel hosting and GitHub Actions FTP connections.

## Solution Options:

### Option 1: FTP with Passive Mode (Applied)
- Added explicit FTP configuration
- Passive mode for better firewall compatibility
- Increased timeout to 60 seconds
- Loose security for compatibility

### Option 2: SFTP Alternative
Many cPanel hosts support SFTP (port 22) which is more reliable:

```yaml
- name: Deploy via SFTP
  uses: wlixcc/SFTP-Deploy-Action@v1.2.4
  with:
    server: ${{ secrets.FTP_HOST }}
    username: ${{ secrets.FTP_USERNAME }}
    password: ${{ secrets.FTP_PASSWORD }}
    local_path: './island-tours-deploy/*'
    remote_path: ${{ secrets.FTP_PATH }}
    sftpArgs: '-o ConnectTimeout=5'
```

### Option 3: Manual Upload via cPanel
If FTP continues to fail:
1. Create deployment ZIP locally
2. Upload via cPanel File Manager
3. Extract on server

## Current Status:
- ✅ Deployment package builds successfully
- ✅ Much faster than before (not stuck for 38+ minutes)
- ❌ FTP connection issues with your hosting provider

## Next Steps:
1. Try the passive mode FTP fix
2. If that fails, switch to SFTP
3. If both fail, use manual cPanel upload

The good news: Your Laravel app is ready to deploy, we just need the right transfer method!
