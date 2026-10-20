# 🧪 TESTING GUIDE - Admin Panel Fixes

## Quick Testing Checklist

### 🔍 Issue 1: Navigation Testing (5 minutes)

#### Test from Dashboard (`/admin/index.php`)
```
✓ Click Dashboard → Should stay on index.php
✓ Click Hero Section → Should go to pages/hero.php
✓ Click About Me → Should go to pages/about.php
✓ Click Skills → Should go to pages/skills.php
✓ Click Services → Should go to pages/services.php
✓ Click Projects → Should go to pages/projects.php
✓ Click Testimonials → Should go to pages/testimonials.php
✓ Click Blog Posts → Should go to pages/blog.php
✓ Click Messages → Should go to pages/messages.php
✓ Click Site Settings → Should go to pages/settings.php
✓ Click Theme Customizer → Should go to pages/theme.php
✓ Click SEO Management → Should go to pages/seo.php
✓ Click Social Links → Should go to pages/social.php
✓ Click Backup → Should go to pages/backup.php
✓ Click Profile → Should go to pages/profile.php
```

#### Test from Any Sub-page (`/admin/pages/*.php`)
```
✓ Click Dashboard → Should go back to ../index.php
✓ Click any other page → Should navigate correctly
✓ Active menu item should be highlighted
✓ No 404 errors should appear
```

### 📸 Issue 2: Hero Image Testing (10 minutes)

#### Test 1: Upload New Image
1. Go to Admin Panel → Hero Section
2. Click "Choose Image" button
3. Select an image (JPG/PNG/WEBP)
4. **Expected Results:**
   - ✓ Image preview appears immediately
   - ✓ Form submits via AJAX
   - ✓ Loading overlay shows
   - ✓ Success message appears
   - ✓ Page doesn't reload
   - ✓ New image displays

#### Test 2: Drag & Drop Upload
1. Go to Hero Section
2. Drag an image file from your computer
3. Drop it on the upload zone
4. **Expected Results:**
   - ✓ Image preview appears
   - ✓ Upload proceeds automatically
   - ✓ Success notification shows

#### Test 3: Old Image Deletion
1. Note current hero image filename
2. Check `/uploads/images/` folder - note how many files
3. Upload a new image
4. **Expected Results:**
   - ✓ Old image deleted from server
   - ✓ New image added
   - ✓ Only ONE hero image in folder
   - ✓ Database updated with new filename

#### Test 4: File Validation
```
Try Invalid Files:
✓ File over 5MB → Should show error "File size exceeds 5MB"
✓ .txt file → Should show error "Invalid file type"
✓ .exe file → Should show error
✓ Corrupted image → Should show error

Try Valid Files:
✓ .jpg file → Should upload successfully
✓ .png file → Should upload successfully  
✓ .gif file → Should upload successfully
✓ .webp file → Should upload successfully ✅ NEW
```

#### Test 5: Frontend Verification
1. Upload new hero image
2. Go to frontend homepage
3. **Expected Results:**
   - ✓ New hero image displays on homepage
   - ✓ No broken image links
   - ✓ Image loads properly

---

## 🔧 Detailed Testing Steps

### A. Navigation System Testing

**Step 1: Test from Dashboard**
```bash
1. Open browser: http://localhost/yourfolder/admin/
2. Login with credentials
3. You should be at: /admin/index.php
4. Click each menu item one by one
5. Verify URL changes correctly
6. Check for any 404 errors
7. Verify active menu highlighting
```

**Step 2: Test from Sub-pages**
```bash
1. Navigate to: /admin/pages/hero.php
2. Click "Dashboard" in sidebar
3. Should go to: /admin/index.php (not pages/index.php)
4. Go back to any sub-page
5. Click other menu items
6. All should work correctly
```

**Step 3: Test Active Highlighting**
```bash
1. Go to Hero Section
2. Verify "Hero Section" is highlighted
3. Go to About Me
4. Verify "About Me" is highlighted
5. Active class should move correctly
```

---

### B. Hero Image Upload Testing

**Step 1: Initial State Check**
```bash
1. SSH or FTP to server
2. Navigate to: /uploads/images/
3. Count hero image files (should be 0 or 1)
4. Note the filename if exists
5. Check database: SELECT * FROM hero WHERE id=1;
6. Note profile_image value
```

**Step 2: Standard Upload Test**
```bash
1. Open Hero Section page
2. Click "Choose Image" button
3. Select test image (2MB JPG)
4. Submit form
5. Watch for:
   - Loading overlay appears
   - AJAX request completes
   - Success notification shows
   - Image preview updates
```

**Step 3: Verify File Replacement**
```bash
1. Check /uploads/images/ folder
2. Count files (should still be 1)
3. Old file should be deleted
4. New file should exist
5. Check database again
6. profile_image should have new filename
```

**Step 4: Drag & Drop Test**
```bash
1. Find another test image on your computer
2. Drag it from file explorer
3. Drop onto the upload zone
4. Verify:
   - Drop zone responds visually
   - Upload starts automatically
   - Preview updates
   - Success message shows
```

**Step 5: File Validation Test**
```bash
Test Large File:
1. Get/create image over 5MB
2. Try to upload
3. Should see: "File size exceeds 5MB"

Test Wrong Type:
1. Try to upload .txt file
2. Should see: "Invalid file type"

Test Valid Types:
1. Upload .jpg → Success
2. Upload .png → Success
3. Upload .gif → Success
4. Upload .webp → Success ✅
```

**Step 6: Frontend Verification**
```bash
1. After successful upload
2. Open new browser tab
3. Go to: http://localhost/yourfolder/
4. Check homepage hero section
5. New image should display
6. Right-click → Inspect image src
7. Should point to new filename
```

---

## 🐛 Common Issues & Solutions

### Issue: 404 on Menu Items
**Solution:**
- Verify file exists in `/admin/pages/`
- Check file permissions (644)
- Clear browser cache
- Check PHP error logs

### Issue: Image Upload Fails
**Solution:**
- Check `/uploads/images/` folder exists
- Verify folder permissions (755)
- Check PHP upload settings:
  ```ini
  upload_max_filesize = 10M
  post_max_size = 10M
  ```
- Enable error reporting temporarily

### Issue: Old Image Not Deleting
**Solution:**
- Check folder write permissions
- Verify function `delete_file()` is called
- Check file path is correct
- Look for PHP errors

### Issue: AJAX Not Working
**Solution:**
- Open browser console (F12)
- Check for JavaScript errors
- Verify jQuery is loaded
- Check network tab for failed requests

---

## 📊 Expected Results Summary

### Navigation (Issue 1)
- ✅ **Zero 404 errors**
- ✅ All links work from dashboard
- ✅ All links work from sub-pages
- ✅ Active menu highlighting works
- ✅ Proper breadcrumb behavior
- ✅ Session management works

### Hero Image (Issue 2)
- ✅ **Only ONE image at a time**
- ✅ Old image auto-deleted
- ✅ New image uploads successfully
- ✅ WEBP format supported
- ✅ File validation works
- ✅ Drag & drop functional
- ✅ Image preview works
- ✅ AJAX submission (no reload)
- ✅ Loading indicators show
- ✅ Success notifications appear
- ✅ Frontend updates immediately

---

## 🔍 Verification Commands

### Check Upload Folder
```bash
# Linux/Mac
ls -la uploads/images/
ls -la uploads/resume/

# Windows
dir uploads\images
dir uploads\resume
```

### Check Database
```sql
-- Check hero data
SELECT * FROM hero WHERE id = 1;

-- Check for duplicate images (should be 0 or 1)
SELECT profile_image FROM hero;

-- Verify timestamps
SELECT profile_image, updated_at FROM hero WHERE id = 1;
```

### Check PHP Errors
```bash
# Linux
tail -f /var/log/apache2/error.log

# Or check your custom error log
tail -f error_log.txt
```

---

## ✅ Final Checklist

### Before Deployment
- [ ] All navigation links tested
- [ ] No 404 errors found
- [ ] Hero image upload tested
- [ ] File replacement verified
- [ ] WEBP upload tested
- [ ] File validation tested
- [ ] Drag & drop tested
- [ ] Frontend verified
- [ ] Database checked
- [ ] Permissions correct (755/644)
- [ ] Error logs clean
- [ ] Browser console clean
- [ ] Mobile responsiveness checked

### Post-Deployment
- [ ] Test on production server
- [ ] Test with real hero images
- [ ] Monitor upload folder size
- [ ] Check error logs regularly
- [ ] Verify SSL certificate
- [ ] Test cross-browser compatibility

---

## 🎯 Quick Test Script

Copy and run this checklist:

```
NAVIGATION TEST:
□ Dashboard link works
□ All Content Management links work
□ All Settings links work  
□ Profile link works
□ Logout works
□ Active highlighting works
□ No 404 errors

HERO IMAGE TEST:
□ Click upload works
□ Drag & drop works
□ Image preview shows
□ File validation works
□ Upload succeeds
□ Old image deleted
□ Only 1 file in folder
□ Frontend shows new image
□ Success notification appears
□ AJAX works (no reload)
```

---

## 🆘 Support

If tests fail:

1. **Check Logs**
   - PHP error log
   - Browser console
   - Network tab

2. **Verify Permissions**
   ```bash
   chmod 755 uploads/
   chmod 755 uploads/images/
   chmod 644 admin/pages/*.php
   ```

3. **Check Requirements**
   - PHP 7.4+
   - PDO enabled
   - GD library installed
   - Disk space available

4. **Enable Debug Mode**
   ```php
   // Add to top of hero.php temporarily
   error_reporting(E_ALL);
   ini_set('display_errors', 1);
   ```

---

**Testing Complete!** ✅

If all tests pass, both issues are successfully resolved!
