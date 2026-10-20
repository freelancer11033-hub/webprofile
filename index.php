<?php
/**
 * Home Page - Dynamic Portfolio Website
 * All content is loaded from database
 */

require_once 'config/database.php';
require_once 'includes/functions.php';

$database = new Database();
$conn = $database->getConnection();

// Track visitor
track_visitor($conn, 'home');

// Get settings
$site_title = get_setting($conn, 'site_title');
$site_logo = get_setting($conn, 'site_logo');

// Get hero data
$stmt = $conn->query("SELECT * FROM hero WHERE id = 1");
$hero = $stmt->fetch();

// Get about data
$stmt = $conn->query("SELECT * FROM about WHERE id = 1");
$about = $stmt->fetch();

// Get skills
$stmt = $conn->query("SELECT * FROM skills WHERE is_active = 1 ORDER BY skill_order");
$skills = $stmt->fetchAll();

// Get services
$stmt = $conn->query("SELECT * FROM services WHERE is_active = 1 ORDER BY service_order");
$services = $stmt->fetchAll();

// Get featured projects
$stmt = $conn->query("SELECT * FROM projects WHERE is_active = 1 AND is_featured = 1 ORDER BY project_order LIMIT 4");
$featured_projects = $stmt->fetchAll();

// Get testimonials
$stmt = $conn->query("SELECT * FROM testimonials WHERE is_active = 1 ORDER BY testimonial_order LIMIT 6");
$testimonials = $stmt->fetchAll();

// Get social links
$stmt = $conn->query("SELECT * FROM social_links WHERE is_active = 1 ORDER BY link_order");
$social_links = $stmt->fetchAll();

// Get theme settings
$stmt = $conn->query("SELECT * FROM theme_settings WHERE id = 1");
$theme = $stmt->fetch();

// Get SEO data
$stmt = $conn->prepare("SELECT * FROM seo_settings WHERE page_name = ?");
$stmt->execute(['home']);
$seo = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $seo['meta_title'] ?? $site_title; ?></title>
    <meta name="description" content="<?php echo $seo['meta_description'] ?? ''; ?>">
    <meta name="keywords" content="<?php echo $seo['meta_keywords'] ?? ''; ?>">
    
    <!-- Open Graph -->
    <meta property="og:title" content="<?php echo $seo['og_title'] ?? $seo['meta_title']; ?>">
    <meta property="og:description" content="<?php echo $seo['og_description'] ?? $seo['meta_description']; ?>">
    <meta property="og:image" content="<?php echo $seo['og_image'] ?? ''; ?>">
    
    <!-- Favicon -->
    <link rel="icon" href="uploads/images/<?php echo get_setting($conn, 'site_favicon'); ?>">
    
    <!-- CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary-color: <?php echo $theme['primary_color']; ?>;
            --secondary-color: <?php echo $theme['secondary_color']; ?>;
            --font-family: <?php echo $theme['font_family']; ?>, sans-serif;
            --bg-color: <?php echo $theme['background_color']; ?>;
        }
    </style>
</head>
<body class="<?php echo $theme['theme_mode']; ?>-mode">
    
    <!-- Header/Navigation -->
    <?php include 'includes/header.php'; ?>
    
    <!-- Hero Section -->
    <section id="home" class="hero-section">
        <div class="container">
            <div class="hero-content">
                <div class="hero-text">
                    <span class="hero-greeting">👋 <?php echo $hero['title']; ?></span>
                    <h1 class="hero-title">
                        <?php echo $about['name']; ?> 
                        <span class="typed-text" data-typed="<?php echo $hero['typing_text']; ?>"></span>
                    </h1>
                    <p class="hero-subtitle"><?php echo $hero['subtitle']; ?></p>
                    
                    <div class="hero-buttons">
                        <a href="#contact" class="btn btn-primary">
                            <i class="fas fa-paper-plane"></i> <?php echo $hero['hire_button_text']; ?>
                        </a>
                        <?php if($hero['resume_file']): ?>
                        <a href="uploads/resume/<?php echo $hero['resume_file']; ?>" class="btn btn-outline" download>
                            <i class="fas fa-download"></i> <?php echo $hero['cv_button_text']; ?>
                        </a>
                        <?php endif; ?>
                    </div>
                    
                    <div class="social-links">
                        <?php foreach($social_links as $social): ?>
                        <a href="<?php echo $social['platform_url']; ?>" target="_blank" rel="noopener">
                            <i class="<?php echo $social['platform_icon']; ?>"></i>
                        </a>
                        <?php endforeach; ?>
                    </div>
                </div>
                
                <div class="hero-image">
                    <?php if($hero['profile_image']): ?>
                    <img src="uploads/images/<?php echo $hero['profile_image']; ?>" alt="<?php echo $about['name']; ?>">
                    <?php endif; ?>
                    <div class="floating-icons">
                        <div class="icon-box icon-1"><i class="fas fa-code"></i></div>
                        <div class="icon-box icon-2"><i class="fas fa-palette"></i></div>
                        <div class="icon-box icon-3"><i class="fas fa-mobile-alt"></i></div>
                    </div>
                </div>
            </div>
            
            <!-- Statistics Counter -->
            <div class="stats-counter">
                <div class="stat-item">
                    <i class="fas fa-briefcase"></i>
                    <h3 class="counter" data-target="<?php echo $about['years_experience']; ?>">0</h3>
                    <p>Years of Experience</p>
                </div>
                <div class="stat-item">
                    <i class="fas fa-project-diagram"></i>
                    <h3 class="counter" data-target="<?php echo $about['completed_projects']; ?>">0</h3>
                    <p>Projects Completed</p>
                </div>
                <div class="stat-item">
                    <i class="fas fa-users"></i>
                    <h3 class="counter" data-target="<?php echo $about['happy_clients']; ?>">0</h3>
                    <p>Happy Clients</p>
                </div>
                <div class="stat-item">
                    <i class="fas fa-trophy"></i>
                    <h3 class="counter" data-target="<?php echo $about['awards_won']; ?>">0</h3>
                    <p>Awards Won</p>
                </div>
            </div>
        </div>
    </section>
    
    <!-- About Section -->
    <section id="about" class="about-section">
        <div class="container">
            <div class="section-header">
                <span class="section-tag">Get To Know</span>
                <h2 class="section-title"><?php echo $about['section_title']; ?></h2>
                <p class="section-subtitle"><?php echo $about['section_subtitle']; ?></p>
            </div>
            
            <div class="about-content">
                <div class="about-image">
                    <?php if($about['about_image']): ?>
                    <img src="uploads/images/<?php echo $about['about_image']; ?>" alt="About <?php echo $about['name']; ?>">
                    <?php endif; ?>
                </div>
                
                <div class="about-info">
                    <h3><?php echo $about['name']; ?></h3>
                    <p class="designation"><?php echo $about['designation']; ?></p>
                    
                    <div class="bio">
                        <?php echo nl2br($about['biography']); ?>
                    </div>
                    
                    <div class="personal-info">
                        <div class="info-item">
                            <i class="fas fa-birthday-cake"></i>
                            <span><strong>Birthday:</strong> <?php echo date('F j, Y', strtotime($about['birthday'])); ?></span>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-envelope"></i>
                            <span><strong>Email:</strong> <?php echo $about['email']; ?></span>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-phone"></i>
                            <span><strong>Phone:</strong> <?php echo $about['phone']; ?></span>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <span><strong>Address:</strong> <?php echo $about['address']; ?></span>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-briefcase"></i>
                            <span><strong>Freelance:</strong> <?php echo $about['freelance_status']; ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Skills Section -->
    <?php if(count($skills) > 0): ?>
    <section id="skills" class="skills-section">
        <div class="container">
            <div class="section-header">
                <span class="section-tag">My Expertise</span>
                <h2 class="section-title">Skills & Technologies</h2>
            </div>
            
            <div class="skills-grid">
                <?php foreach($skills as $skill): ?>
                <div class="skill-item">
                    <?php if($skill['skill_icon']): ?>
                    <i class="<?php echo $skill['skill_icon']; ?> skill-icon"></i>
                    <?php endif; ?>
                    <h4><?php echo $skill['skill_name']; ?></h4>
                    <div class="skill-bar">
                        <div class="skill-progress" data-progress="<?php echo $skill['skill_percentage']; ?>">
                            <span class="skill-percent"><?php echo $skill['skill_percentage']; ?>%</span>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>
    
    <!-- Services Section -->
    <?php if(count($services) > 0): ?>
    <section id="services" class="services-section">
        <div class="container">
            <div class="section-header">
                <span class="section-tag">What I Do</span>
                <h2 class="section-title">My Services</h2>
            </div>
            
            <div class="services-grid">
                <?php foreach($services as $service): ?>
                <div class="service-card">
                    <div class="service-icon">
                        <i class="<?php echo $service['service_icon']; ?>"></i>
                    </div>
                    <h3><?php echo $service['service_title']; ?></h3>
                    <p><?php echo $service['service_description']; ?></p>
                    <a href="#contact" class="service-link">
                        <?php echo $service['button_text']; ?> <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>
    
    <!-- Portfolio Section -->
    <?php if(count($featured_projects) > 0): ?>
    <section id="portfolio" class="portfolio-section">
        <div class="container">
            <div class="section-header">
                <span class="section-tag">My Work</span>
                <h2 class="section-title">Featured Projects</h2>
            </div>
            
            <div class="portfolio-grid">
                <?php foreach($featured_projects as $project): ?>
                <div class="portfolio-card">
                    <div class="portfolio-image">
                        <?php if($project['project_image']): ?>
                        <img src="uploads/projects/<?php echo $project['project_image']; ?>" 
                             alt="<?php echo $project['project_name']; ?>" loading="lazy">
                        <?php endif; ?>
                        <div class="portfolio-overlay">
                            <div class="portfolio-links">
                                <?php if($project['live_demo_link']): ?>
                                <a href="<?php echo $project['live_demo_link']; ?>" target="_blank" class="portfolio-link">
                                    <i class="fas fa-external-link-alt"></i>
                                </a>
                                <?php endif; ?>
                                <?php if($project['github_link']): ?>
                                <a href="<?php echo $project['github_link']; ?>" target="_blank" class="portfolio-link">
                                    <i class="fab fa-github"></i>
                                </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="portfolio-info">
                        <span class="portfolio-category"><?php echo $project['project_category']; ?></span>
                        <h3><?php echo $project['project_name']; ?></h3>
                        <p><?php echo truncate_text($project['project_description'], 100); ?></p>
                        <?php if($project['technologies_used']): ?>
                        <div class="portfolio-tags">
                            <?php 
                            $techs = explode(',', $project['technologies_used']);
                            foreach($techs as $tech): 
                            ?>
                            <span class="tag"><?php echo trim($tech); ?></span>
                            <?php endforeach; ?>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            
            <div class="text-center">
                <a href="portfolio.php" class="btn btn-primary">View All Projects</a>
            </div>
        </div>
    </section>
    <?php endif; ?>
    
    <!-- Testimonials Section -->
    <?php if(count($testimonials) > 0): ?>
    <section id="testimonials" class="testimonials-section">
        <div class="container">
            <div class="section-header">
                <span class="section-tag">Client Reviews</span>
                <h2 class="section-title">What Clients Say</h2>
            </div>
            
            <div class="testimonials-slider">
                <?php foreach($testimonials as $testimonial): ?>
                <div class="testimonial-card">
                    <div class="testimonial-rating">
                        <?php for($i = 0; $i < $testimonial['rating']; $i++): ?>
                        <i class="fas fa-star"></i>
                        <?php endfor; ?>
                    </div>
                    <p class="testimonial-text">"<?php echo $testimonial['review_text']; ?>"</p>
                    <div class="testimonial-author">
                        <?php if($testimonial['client_image']): ?>
                        <img src="uploads/images/<?php echo $testimonial['client_image']; ?>" 
                             alt="<?php echo $testimonial['client_name']; ?>">
                        <?php endif; ?>
                        <div>
                            <h4><?php echo $testimonial['client_name']; ?></h4>
                            <p><?php echo $testimonial['designation']; ?></p>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>
    
    <!-- Contact Section -->
    <section id="contact" class="contact-section">
        <div class="container">
            <div class="section-header">
                <span class="section-tag">Get In Touch</span>
                <h2 class="section-title">Contact Me</h2>
            </div>
            
            <div class="contact-content">
                <div class="contact-info">
                    <h3>Let's work together!</h3>
                    <p>Have a project in mind? Let's discuss how I can help bring your ideas to life.</p>
                    
                    <div class="contact-methods">
                        <div class="contact-method">
                            <i class="fas fa-envelope"></i>
                            <div>
                                <h4>Email</h4>
                                <a href="mailto:<?php echo get_setting($conn, 'contact_email'); ?>">
                                    <?php echo get_setting($conn, 'contact_email'); ?>
                                </a>
                            </div>
                        </div>
                        <div class="contact-method">
                            <i class="fas fa-phone"></i>
                            <div>
                                <h4>Phone</h4>
                                <a href="tel:<?php echo get_setting($conn, 'contact_phone'); ?>">
                                    <?php echo get_setting($conn, 'contact_phone'); ?>
                                </a>
                            </div>
                        </div>
                        <div class="contact-method">
                            <i class="fas fa-map-marker-alt"></i>
                            <div>
                                <h4>Address</h4>
                                <p><?php echo get_setting($conn, 'contact_address'); ?></p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="quick-contact">
                        <?php if(get_setting($conn, 'whatsapp_number')): ?>
                        <a href="https://wa.me/<?php echo get_setting($conn, 'whatsapp_number'); ?>" 
                           class="btn btn-success" target="_blank">
                            <i class="fab fa-whatsapp"></i> WhatsApp
                        </a>
                        <?php endif; ?>
                        
                        <?php if(get_setting($conn, 'messenger_link')): ?>
                        <a href="<?php echo get_setting($conn, 'messenger_link'); ?>" 
                           class="btn btn-info" target="_blank">
                            <i class="fab fa-facebook-messenger"></i> Messenger
                        </a>
                        <?php endif; ?>
                        
                        <?php if(get_setting($conn, 'telegram_link')): ?>
                        <a href="<?php echo get_setting($conn, 'telegram_link'); ?>" 
                           class="btn btn-primary" target="_blank">
                            <i class="fab fa-telegram"></i> Telegram
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="contact-form-wrapper">
                    <form id="contactForm" class="contact-form">
                        <div class="form-group">
                            <input type="text" name="name" placeholder="Your Name" required>
                        </div>
                        <div class="form-group">
                            <input type="email" name="email" placeholder="Your Email" required>
                        </div>
                        <div class="form-group">
                            <input type="text" name="subject" placeholder="Subject" required>
                        </div>
                        <div class="form-group">
                            <textarea name="message" rows="5" placeholder="Your Message" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">
                            <i class="fas fa-paper-plane"></i> Send Message
                        </button>
                    </form>
                    <div id="formMessage" class="form-message"></div>
                </div>
            </div>
            
            <?php if(get_setting($conn, 'google_map_embed')): ?>
            <div class="map-wrapper">
                <?php echo get_setting($conn, 'google_map_embed'); ?>
            </div>
            <?php endif; ?>
        </div>
    </section>
    
    <!-- Footer -->
    <?php include 'includes/footer.php'; ?>
    
    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/typed.js/2.0.12/typed.min.js"></script>
    <script src="assets/js/main.js"></script>
</body>
</html>
