# 🚨 QUICK FIX for 404 Errors

## Step 1: Run System Check (IMPORTANT!)

Open your browser and go to:
```
http://localhost/new/admin/check_system.php
```

This will show you:
- ✓ What's working
- ✗ What needs to be fixed
- All system requirements

---

## Step 2: Most Common Fixes

### Fix A: Wrong URL Path

**If your folder is on Desktop, you need PHP server:**

1. Open Command Prompt (CMD)
2. Type:
```cmd
cd C:\Users\PRODIPBISWAS\Desktop\new
php -S localhost:8000
```
3. Access admin at: `http://localhost:8000/admin/`

**If using XAMPP/WAMP:**
1. Move folder to: `C:\xampp\htdocs\new\`
2. Access at: `http://localhost/new/admin/`

---

### Fix B: API Test

Test if APIs are working:
```
http://localhost:8000/api/test.php
```
or
```
http://localhost/new/api/test.php
```

**Should see:**
```json
{"success":true,"message":"API is working!"}
```

**If you see 404:**
- Your web server path is wrong
- Follow Fix A above

---

### Fix C: Database Not Installed

If system check shows missing tables:

1. Go to: `http://localhost:8000/database/install.php`
2. Wait for "Success" message
3. You'll see default login credentials
4. Then go back to admin panel

---

## Step 3: Access Admin Panel

Once system check passes:

```
http://localhost:8000/admin/login.php
```

**Default Login:**
- Username: `admin`
- Password: `admin123`

---

## Step 4: Test Each Feature

### ✅ Test Skills
1. Click "Skills" in sidebar
2. Click "Add Skill" button
3. Enter: Name="PHP", Percentage=90%
4. Choose an icon
5. Click Save
6. Should appear in list!

### ✅ Test Services
1. Click "Services" in sidebar  
2. Click "Add Service"
3. Fill the form
4. Click Save
5. Should appear!

### ✅ Test Projects
1. Click "Projects" in sidebar
2. Click "Add Project"
3. Upload an image
4. Fill details
5. Click Save

### ✅ Test Testimonials
1. Click "Testimonials" in sidebar
2. Click "Add Testimonial"
3. Enter client details
4. Click stars for rating
5. Click Save

### ✅ Test Blog
1. Click "Blog Posts" in sidebar
2. Click "New Post"
3. Write title and content
4. Click Save

### ✅ Test Messages
1. Go to your website front-end
2. Fill contact form
3. Go to "Messages" in admin
4. You should see your message!

---

## Quick Reference

| Feature | Admin URL | API URL |
|---------|-----------|---------|
| Skills | `/admin/pages/skills.php` | `/api/skills.php` |
| Services | `/admin/pages/services.php` | `/api/services.php` |
| Projects | `/admin/pages/projects.php` | `/api/projects.php` |
| Testimonials | `/admin/pages/testimonials.php` | `/api/testimonials.php` |
| Blog | `/admin/pages/blog.php` | `/api/blog.php` |
| Messages | `/admin/pages/messages.php` | `/api/messages.php` |

---

## View Site Button

The "View Site" button in the top-left of admin panel opens your website.

**It goes to:** `http://localhost:8000/` or `http://localhost/new/`

---

## Still Having 404 Errors?

### Check Your Browser Console

1. Press `F12` in browser
2. Go to "Console" tab
3. Try to add a skill
4. Look for red errors
5. Take a screenshot and check:

**Common errors:**
- `ERR_CONNECTION_REFUSED` = Server not running
- `404 Not Found` = Wrong URL path
- `500 Internal Server Error` = Check PHP errors

### Check Network Tab

1. Press `F12`
2. Go to "Network" tab
3. Try to add a skill
4. Click on the red/failed request
5. Check "Response" tab
6. This shows the actual error!

---

## Directory Structure Should Be:

```
new/
├── admin/
│   ├── pages/
│   │   ├── skills.php       ✓ Complete
│   │   ├── services.php     ✓ Complete
│   │   ├── projects.php     ✓ Complete
│   │   ├── testimonials.php ✓ Complete
│   │   ├── blog.php         ✓ Complete
│   │   └── messages.php     ✓ Complete
│   ├── includes/
│   │   ├── sidebar.php
│   │   └── topbar.php
│   ├── check_system.php     ← Run this first!
│   └── login.php
├── api/
│   ├── skills.php           ✓ Created
│   ├── services.php         ✓ Created
│   ├── projects.php         ✓ Created
│   ├── testimonials.php     ✓ Created
│   ├── blog.php             ✓ Created
│   ├── messages.php         ✓ Created
│   └── test.php             ✓ Test file
├── config/
│   └── database.php
├── database/
│   └── install.php
└── uploads/
    ├── images/
    ├── projects/
    └── resume/
```

---

## What I Fixed

### ✅ Created Missing API Files:
- `/api/skills.php` - Add/edit/delete skills
- `/api/testimonials.php` - Add/edit/delete testimonials
- `/api/blog.php` - Add/edit/delete blog posts

### ✅ Updated Admin Pages:
- `/admin/pages/skills.php` - Full CRUD interface
- `/admin/pages/testimonials.php` - Full CRUD interface
- `/admin/pages/blog.php` - Full CRUD interface with categories

### ✅ Fixed Navigation:
- Updated topbar with working "View Site" button
- Fixed sidebar navigation paths
- Added database connection error handling

### ✅ Fixed .htaccess:
- API requests now work correctly
- Admin requests work correctly
- Upload folders accessible

### ✅ Added Debugging:
- `/admin/check_system.php` - Complete system diagnostic
- `/api/test.php` - Test if APIs are accessible
- Better error messages in all APIs

---

## What Each Page Can Do Now:

### 📊 **Skills Page**
- ✅ Add new skills
- ✅ Set percentage levels (0-100%)
- ✅ Choose from 40+ icons
- ✅ Edit existing skills
- ✅ Delete skills
- ✅ Beautiful progress bars

### 💼 **Services Page**
- ✅ Add services
- ✅ Choose icons
- ✅ Edit services
- ✅ Delete services
- ✅ Card layout

### 📁 **Projects Page**
- ✅ Add projects with images
- ✅ Upload screenshots (drag & drop)
- ✅ Add demo/GitHub links
- ✅ Download links support
- ✅ Mark as featured
- ✅ Edit/delete projects

### 💬 **Testimonials Page**
- ✅ Add client reviews
- ✅ Upload client photos
- ✅ 5-star rating system
- ✅ Edit/delete testimonials
- ✅ Circular avatars

### 📝 **Blog Page**
- ✅ Create blog posts
- ✅ Add featured images
- ✅ Category management
- ✅ SEO optimization
- ✅ Draft/publish status
- ✅ Tags support
- ✅ Edit/delete posts

### 📧 **Messages Page**
- ✅ View all messages
- ✅ Search messages
- ✅ Filter (All/Unread/Read)
- ✅ Reply to messages
- ✅ Delete messages
- ✅ Bulk actions

---

## Need More Help?

1. **Run system check first:** `http://localhost:8000/admin/check_system.php`
2. **Test API:** `http://localhost:8000/api/test.php`
3. **Check console:** Press F12 → Console tab
4. **Check network:** Press F12 → Network tab

---

**Everything is ready! Just run the system check and start using your admin panel! 🚀**

**Remember:** If on Desktop, use PHP server: `php -S localhost:8000`
