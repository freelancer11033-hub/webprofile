# Dynamic Portfolio Website

A professional, fully dynamic portfolio website built with PHP, MySQL, HTML5, CSS3, and JavaScript. Every element is manageable through an intuitive admin panel.

## Features

### Frontend
- **Modern Design** - Premium, responsive design with smooth animations
- **Hero Section** - Animated typing text, profile image, CTA buttons
- **About Section** - Personal info, biography, statistics counter
- **Skills** - Animated progress bars with custom icons
- **Services** - Showcase your services with icons and descriptions
- **Portfolio** - Project gallery with filtering and categories
- **Testimonials** - Client reviews with ratings
- **Blog** - Full-featured blog system with categories and tags
- **Contact** - Contact form with WhatsApp, Messenger, Telegram integration
- **SEO Optimized** - Meta tags, Open Graph, Schema markup
- **Dark Mode** - Toggle between light and dark themes
- **Fully Responsive** - Mobile, tablet, and desktop friendly

### Admin Panel
- **Secure Login** - Password hashing, remember me, session management
- **Dashboard** - Statistics overview with recent activity
- **Content Management**
  - Hero Section Editor
  - About Me Manager
  - Skills CRUD
  - Services CRUD
  - Projects CRUD with multiple images
  - Testimonials CRUD
  - Blog Posts with categories and SEO
  - Messages Inbox
- **Settings**
  - Site Settings (title, logo, favicon, footer)
  - Theme Customizer (colors, fonts, modes)
  - SEO Management (meta tags per page)
  - Social Media Links
- **Database Backup** - One-click backup and restore
- **File Manager** - Upload images, PDFs, documents

## Installation

### Requirements
- PHP 7.4 or higher
- MySQL 5.7 or higher
- Apache/Nginx web server
- mod_rewrite enabled

### Setup Instructions

1. **Extract Files**
   ```
   Extract all files to your web server directory (htdocs, www, or public_html)
   ```

2. **Create Database**
   ```sql
   CREATE DATABASE portfolio_db;
   ```

3. **Configure Database**
   - Open `config/database.php`
   - Update database credentials:
     ```php
     private $host = "localhost";
     private $db_name = "portfolio_db";
     private $username = "your_username";
     private $password = "your_password";
     ```

4. **Install Database**
   - Visit: `http://yoursite.com/database/install.php`
   - This will create all tables and insert default data

5. **Login to Admin**
   - URL: `http://yoursite.com/admin/login.php`
   - Username: `admin`
   - Password: `admin123`
   - **Important:** Change the password immediately after first login!

6. **Start Customizing**
   - Update hero section with your information
   - Add your profile images
   - Add your skills, services, and projects
   - Customize theme colors
   - Update SEO settings

## File Structure

```
├── admin/                  # Admin panel
│   ├── assets/            # Admin CSS/JS
│   ├── includes/          # Admin components
│   ├── pages/             # Admin pages
│   ├── index.php          # Dashboard
│   └── login.php          # Login page
├── api/                   # API endpoints
│   └── contact.php        # Contact form handler
├── assets/                # Frontend assets
│   ├── css/              # Stylesheets
│   ├── js/               # JavaScript files
│   ├── images/           # Static images
│   └── fonts/            # Web fonts
├── config/               # Configuration files
│   └── database.php      # Database connection
├── database/             # Database scripts
│   └── install.php       # Installation script
├── includes/             # Shared PHP files
│   ├── functions.php     # Helper functions
│   ├── header.php        # Site header
│   └── footer.php        # Site footer
├── uploads/              # User uploads
│   ├── images/          # Images
│   ├── projects/        # Project screenshots
│   ├── resume/          # Resume files
│   └── backups/         # Database backups
├── index.php             # Homepage
├── portfolio.php         # Portfolio page
├── blog.php              # Blog listing
└── README.md             # This file
```

## Security Features

- **SQL Injection Protection** - Prepared statements with PDO
- **XSS Protection** - Input sanitization and output escaping
- **CSRF Protection** - Token validation on forms
- **Password Security** - Bcrypt hashing
- **Session Security** - Secure session management
- **File Upload Security** - File type and size validation
- **Login Attempts** - Rate limiting (can be enhanced)

## Customization

### Theme Colors
Admin Panel → Theme Customizer
- Change primary and secondary colors
- Select fonts
- Toggle dark/light mode

### Adding Content
All content can be added/edited through the admin panel:
- Hero Section: admin/pages/hero.php
- About: admin/pages/about.php
- Skills: admin/pages/skills.php
- Services: admin/pages/services.php
- Projects: admin/pages/projects.php
- Testimonials: admin/pages/testimonials.php
- Blog: admin/pages/blog.php

### SEO Settings
Admin Panel → SEO Management
- Set meta titles and descriptions for each page
- Add Open Graph data
- Include schema markup

## Support

For issues or questions:
1. Check the admin dashboard for system status
2. Review error logs in your server
3. Ensure all file permissions are correct (uploads folder should be writable)
4. Verify database connection settings

## Security Recommendations

1. **Change Default Credentials** - Immediately after installation
2. **Use Strong Passwords** - Minimum 12 characters with mixed case, numbers, symbols
3. **Regular Backups** - Use the built-in backup feature regularly
4. **Keep Updated** - Update PHP and MySQL to latest stable versions
5. **HTTPS** - Always use SSL certificate in production
6. **Restrict Admin Access** - Consider IP whitelisting for admin panel
7. **File Permissions** - Set appropriate permissions (644 for files, 755 for directories)

## Credits

- Font Awesome - Icons
- Google Fonts - Typography
- Typed.js - Typing animation

## License

This project is provided as-is for personal and commercial use.

---

**Enjoy building your portfolio! 🚀**
