# Installation Guide - Dynamic Portfolio Website

## System Requirements

- PHP 7.4 or higher
- MySQL 5.7 or MariaDB 10.2 or higher
- Apache 2.4 with mod_rewrite enabled
- Minimum 512MB RAM
- 100MB free disk space

## Step-by-Step Installation

### Step 1: Download and Extract

Extract all files to your web server directory:
- **XAMPP**: `C:/xampp/htdocs/portfolio/`
- **WAMP**: `C:/wamp/www/portfolio/`
- **MAMP**: `/Applications/MAMP/htdocs/portfolio/`
- **Linux**: `/var/www/html/portfolio/`

### Step 2: Create Database

Open phpMyAdmin or MySQL command line:

```sql
CREATE DATABASE portfolio_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### Step 3: Configure Database Connection

Edit `config/database.php` and update:

```php
private $host = "localhost";
private $db_name = "portfolio_db";
private $username = "root";      // Your MySQL username
private $password = "";          // Your MySQL password
```

### Step 4: Run Installation Script

Visit in your browser:
```
http://localhost/portfolio/database/install.php
```

This will:
- Create all required database tables
- Insert default settings and data
- Create admin account

### Step 5: Set File Permissions

For Linux/Mac servers, set proper permissions:

```bash
chmod 755 uploads/
chmod 755 uploads/images/
chmod 755 uploads/projects/
chmod 755 uploads/resume/
chmod 755 uploads/backups/
```

### Step 6: Access Admin Panel

Login to admin panel:
```
URL: http://localhost/portfolio/admin/login.php
Username: admin
Password: admin123
```

**⚠️ IMPORTANT: Change the password immediately after first login!**

### Step 7: Initial Configuration

After login, configure:

1. **Profile Settings** (admin/pages/profile.php)
   - Change username and password
   - Update email address

2. **Site Settings** (admin/pages/settings.php)
   - Site title
   - Upload logo and favicon
   - Contact information

3. **Hero Section** (admin/pages/hero.php)
   - Upload profile image
   - Set typing text
   - Upload resume

4. **About Me** (admin/pages/about.php)
   - Personal information
   - Biography
   - Statistics

5. **Theme Customizer** (admin/pages/theme.php)
   - Choose colors
   - Select font
   - Set theme mode

## Common Issues and Solutions

### Issue 1: Database Connection Error

**Solution:**
- Verify MySQL service is running
- Check database credentials in `config/database.php`
- Ensure database `portfolio_db` exists

### Issue 2: File Upload Errors

**Solution:**
- Check `uploads/` folder exists and is writable
- Verify PHP upload settings in `php.ini`:
  ```ini
  upload_max_filesize = 10M
  post_max_size = 10M
  ```

### Issue 3: 404 Errors / Routing Issues

**Solution:**
- Enable mod_rewrite in Apache
- Verify `.htaccess` file exists
- Check Apache configuration allows .htaccess overrides

### Issue 4: Session Errors

**Solution:**
- Ensure PHP session directory is writable
- Check PHP session settings in `php.ini`

## Post-Installation Security

### 1. Change Admin Credentials

```
Admin Panel → Profile → Change Password
```

### 2. Secure Database

Update database user with limited privileges:

```sql
CREATE USER 'portfolio_user'@'localhost' IDENTIFIED BY 'strong_password';
GRANT SELECT, INSERT, UPDATE, DELETE ON portfolio_db.* TO 'portfolio_user'@'localhost';
FLUSH PRIVILEGES;
```

### 3. Delete Installation File

After successful installation:
```bash
rm database/install.php
```

Or rename it for future use:
```bash
mv database/install.php database/install.php.bak
```

### 4. Update .htaccess

For production, uncomment HTTPS redirect:
```apache
RewriteCond %{HTTPS} off
RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
```

### 5. Enable Error Logging

Create `php.ini` or `.user.ini` in root:
```ini
log_errors = On
error_log = error_log.txt
display_errors = Off
```

## Server Configuration

### Apache Virtual Host Example

```apache
<VirtualHost *:80>
    ServerName portfolio.local
    DocumentRoot "/path/to/portfolio"
    
    <Directory "/path/to/portfolio">
        Options -Indexes +FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>
    
    ErrorLog ${APACHE_LOG_DIR}/portfolio-error.log
    CustomLog ${APACHE_LOG_DIR}/portfolio-access.log combined
</VirtualHost>
```

### Nginx Configuration Example

```nginx
server {
    listen 80;
    server_name portfolio.local;
    root /path/to/portfolio;
    index index.php index.html;
    
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
    
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php7.4-fpm.sock;
        fastcgi_index index.php;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
    }
    
    location ~ /\. {
        deny all;
    }
}
```

## Backup Recommendations

### Automated Daily Backups

Use the built-in backup system or create a cron job:

```bash
# Daily at 2 AM
0 2 * * * wget -q http://localhost/portfolio/admin/pages/backup.php?auto=1
```

### Manual Backup

1. Database: Admin Panel → Backup → Create Backup
2. Files: Copy entire uploads/ directory

## Performance Optimization

### 1. Enable Caching

Add to `.htaccess`:
```apache
<IfModule mod_expires.c>
    ExpiresActive On
    ExpiresByType image/jpeg "access plus 1 year"
    ExpiresByType image/png "access plus 1 year"
    ExpiresByType text/css "access plus 1 month"
    ExpiresByType application/javascript "access plus 1 month"
</IfModule>
```

### 2. Optimize Images

Before uploading:
- Compress images using TinyPNG or ImageOptim
- Recommended sizes:
  - Profile image: 800x800px
  - Project images: 1200x800px
  - Blog images: 1200x600px

### 3. Enable Gzip Compression

Already included in `.htaccess`:
```apache
<IfModule mod_deflate.c>
    AddOutputFilterByType DEFLATE text/html text/css application/javascript
</IfModule>
```

## Deployment to Production

### 1. Update Database Configuration

```php
private $host = "your-server.com";
private $db_name = "your_database";
private $username = "your_username";
private $password = "strong_password";
```

### 2. Update Base URLs

Check and update URLs in:
- `includes/header.php`
- `includes/footer.php`

### 3. Enable HTTPS

```apache
# Force HTTPS
RewriteCond %{HTTPS} off
RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
```

### 4. Disable Error Display

In `.htaccess` or `php.ini`:
```ini
display_errors = Off
log_errors = On
```

### 5. Set Secure Permissions

```bash
find . -type f -exec chmod 644 {} \;
find . -type d -exec chmod 755 {} \;
chmod 755 uploads/
```

## Testing Checklist

- [ ] Homepage loads correctly
- [ ] All sections display (Hero, About, Skills, Services, Portfolio, Testimonials, Contact)
- [ ] Contact form submits successfully
- [ ] Admin login works
- [ ] Can add/edit/delete projects
- [ ] Can add/edit/delete services
- [ ] Theme customizer applies changes
- [ ] File uploads work
- [ ] Database backup creates successfully
- [ ] Mobile responsive design works
- [ ] Dark mode toggle works
- [ ] All navigation links work

## Support and Troubleshooting

For additional help:

1. Check error logs:
   - PHP error log: `error_log.txt` or server error logs
   - Apache error log: `/var/log/apache2/error.log`

2. Enable debugging temporarily:
   - Add to `config/database.php`: `error_reporting(E_ALL);`

3. Verify PHP extensions:
   ```bash
   php -m | grep -E 'pdo|mysql|gd'
   ```

## Upgrading

When new versions are released:

1. Backup database and files
2. Replace all files except:
   - `config/database.php`
   - `uploads/` directory
3. Run any new migration scripts
4. Clear browser cache

---

**Installation Complete! 🎉**

Your dynamic portfolio website is now ready to use. Start customizing it from the admin panel!
