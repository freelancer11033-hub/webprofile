# 🔧 Troubleshooting Guide - Fix 404 Errors

## Problem 1: Getting 404 Errors When Accessing Admin Pages

### Quick Test
1. Open browser and go to: `http://localhost/new/api/test.php`
2. You should see: `{"success":true,"message":"API is working!"...}`
3. If you see this, APIs are working!

### If You See 404 Error:

#### Solution A: Check Your Server Setup

**For XAMPP/WAMP Users:**
1. Make sure Apache is running
2. Your folder should be in: `C:\xampp\htdocs\new\`
3. Access via: `http://localhost/new/admin/`

**For Local PHP Server:**
```cmd
cd C:\Users\PRODIPBISWAS\Desktop\new
php -S localhost:8000
```
Then access: `http://localhost:8000/admin/`

#### Solution B: Fix .htaccess File

The `.htaccess` might be blocking API access. Let me create a fixed version:

**Update `.htaccess` in the root folder:**

```apache
# Security Headers
<IfModule mod_headers.c>
    Header set X-Content-Type-Options "nosniff"
    Header set X-Frame-Options "SAMEORIGIN"
    Header set X-XSS-Protection "1; mode=block"
</IfModule>

# Prevent Directory Browsing
Options -Indexes

# Enable Rewrite Engine
<IfModule mod_rewrite.c>
    RewriteEngine On
    
    # Allow API access
    RewriteCond %{REQUEST_URI} ^/api/ [NC]
    RewriteRule ^ - [L]
    
    # Allow admin access
    RewriteCond %{REQUEST_URI} ^/admin/ [NC]
    RewriteRule ^ - [L]
    
    # Remove .php extension for other files
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME}\.php -f
    RewriteRule ^(.*)$ $1.php [L]
</IfModule>

# Protect sensitive files (but allow API)
<FilesMatch "^\.htaccess$">
    Order allow,deny
    Deny from all
</FilesMatch>

# PHP Settings
<IfModule mod_php7.c>
    php_value upload_max_filesize 10M
    php_value post_max_size 10M
    php_value max_execution_time 300
    php_value max_input_time 300
</IfModule>
```

#### Solution C: Check Folder Permissions

**On Windows:**
- Right-click on the `new` folder
- Properties → Security
- Make sure your user has "Full Control"

**On Linux/Mac:**
```bash
chmod -R 755 /path/to/new
chmod -R 777 /path/to/new/uploads
```

---

## Problem 2: "View Site" Button Not Working

### Fix:
The "View Site" button in the admin top bar has been updated to use the correct path.

**Test it:**
1. Go to admin panel: `http://localhost/new/admin/`
2. Click "View Site" button (top left)
3. Should open your website in a new tab

---

## Problem 3: API Returns Empty or No Data

### Check Database Tables Exist:

**Run this query in phpMyAdmin:**
```sql
SHOW TABLES;
```

**You should see these tables:**
- admin
- skills
- services
- projects
- testimonials
- blog_posts
- blog_categories
- contact_messages
- settings
- hero
- about
- social_links
- theme_settings
- seo_settings

**If tables are missing, run the installation:**
1. Go to: `http://localhost/new/database/install.php`
2. Wait for success message
3. Then try admin panel again

---

## Problem 4: Images Not Uploading

### Fix Upload Folders:

**Create these folders if they don't exist:**
```
new/uploads/
new/uploads/images/
new/uploads/projects/
new/uploads/resume/
```

**Windows PowerShell:**
```powershell
cd C:\Users\PRODIPBISWAS\Desktop\new
mkdir uploads\images -Force
mkdir uploads\projects -Force
mkdir uploads\resume -Force
```

**Set Write Permissions:**
- Right-click each folder → Properties → Security
- Edit → Add → "Everyone" → Full Control

---

## Problem 5: Blank Page or PHP Errors

### Enable Error Display:

**Create `debug.php` in admin folder:**
```php
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>PHP Debug Info</h1>";
echo "<h2>PHP Version: " . phpversion() . "</h2>";

// Test database connection
require_once '../config/database.php';
try {
    $db = new Database();
    $conn = $db->getConnection();
    echo "<p style='color:green'>✓ Database Connected!</p>";
    
    // Test query
    $stmt = $conn->query("SELECT COUNT(*) as count FROM admin");
    $result = $stmt->fetch();
    echo "<p>Admin users: " . $result['count'] . "</p>";
    
} catch(Exception $e) {
    echo "<p style='color:red'>✗ Database Error: " . $e->getMessage() . "</p>";
}

echo "<h2>Loaded Extensions:</h2>";
echo "<ul>";
foreach(get_loaded_extensions() as $ext) {
    echo "<li>$ext</li>";
}
echo "</ul>";
?>
```

Then visit: `http://localhost/new/admin/debug.php`

---

## Problem 6: Cannot Login to Admin Panel

### Reset Admin Password:

**Create `reset_password.php` in root folder:**
```php
<?php
require_once 'config/database.php';

$database = new Database();
$conn = $database->getConnection();

$new_password = password_hash('admin123', PASSWORD_DEFAULT);

$stmt = $conn->prepare("UPDATE admin SET password = ? WHERE username = 'admin'");
$stmt->execute([$new_password]);

echo "Password reset! Login with: admin / admin123";
?>
```

Visit: `http://localhost/new/reset_password.php`

---

## Quick Diagnostic Checklist

Run through this checklist:

- [ ] Apache/PHP server is running
- [ ] Can access `http://localhost/new/index.php`
- [ ] Can access `http://localhost/new/api/test.php`
- [ ] Database tables exist (check phpMyAdmin)
- [ ] Upload folders exist and are writable
- [ ] Can login to admin panel
- [ ] "View Site" button works
- [ ] Can add a test skill (Skills page)

---

## Still Having Issues?

### Collect This Information:

1. **What URL are you using?**
   - Example: `http://localhost/new/admin/`

2. **What exact error message do you see?**
   - Take a screenshot

3. **Check Browser Console:**
   - Press F12
   - Go to "Console" tab
   - Copy any red error messages

4. **Check Network Tab:**
   - Press F12
   - Go to "Network" tab
   - Try the action again
   - Click on any red/failed requests
   - Copy the error response

5. **Server Info:**
   - XAMPP or WAMP or Other?
   - PHP Version (run `debug.php` to see)
   - Operating System

---

## Common Fixes Summary

### Fix #1: Wrong Base URL
```javascript
// In admin page, change API_URL to absolute path:
const API_URL = 'http://localhost/new/api/skills.php';
```

### Fix #2: Disable .htaccess Temporarily
Rename `.htaccess` to `.htaccess.bak` and test if it works.

### Fix #3: Check PHP Version
You need PHP 7.4 or higher. Check with:
```cmd
php -v
```

### Fix #4: Clear Browser Cache
- Press Ctrl+Shift+Delete
- Clear cache and cookies
- Try again

---

## Testing Each Feature

### Test Skills:
1. Go to: `http://localhost/new/admin/pages/skills.php`
2. Click "Add Skill"
3. Fill: Name="PHP", Percentage=90%, Icon=(choose any)
4. Click Save
5. Should appear in list

### Test Services:
1. Go to: `http://localhost/new/admin/pages/services.php`
2. Click "Add Service"
3. Fill in the form
4. Click Save

### Test Projects:
1. Go to: `http://localhost/new/admin/pages/projects.php`
2. Click "Add Project"
3. Upload an image
4. Fill details
5. Click Save

### Test Testimonials:
1. Go to: `http://localhost/new/admin/pages/testimonials.php`
2. Click "Add Testimonial"
3. Fill client details
4. Set rating (click stars)
5. Click Save

### Test Blog:
1. Go to: `http://localhost/new/admin/pages/blog.php`
2. Click "New Post"
3. Fill title and content
4. Click Save

### Test Messages:
1. Go to your website contact form
2. Submit a test message
3. Go to: `http://localhost/new/admin/pages/messages.php`
4. You should see your message
5. Click on it to view
6. Try replying

---

**If all tests pass, your admin panel is working perfectly! 🎉**
