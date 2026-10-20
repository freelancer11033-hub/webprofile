<?php
/**
 * Portfolio Page - All Projects
 */

require_once 'config/database.php';
require_once 'includes/functions.php';

$database = new Database();
$conn = $database->getConnection();

track_visitor($conn, 'portfolio');

// Get filter category
$filter_category = $_GET['category'] ?? 'all';

// Get all categories
$stmt = $conn->query("SELECT DISTINCT project_category FROM projects WHERE is_active = 1 ORDER BY project_category");
$categories = $stmt->fetchAll();

// Get projects
if ($filter_category === 'all') {
    $stmt = $conn->query("SELECT * FROM projects WHERE is_active = 1 ORDER BY project_order, created_at DESC");
} else {
    $stmt = $conn->prepare("SELECT * FROM projects WHERE is_active = 1 AND project_category = ? ORDER BY project_order, created_at DESC");
    $stmt->execute([$filter_category]);
}
$projects = $stmt->fetchAll();

// Get theme and SEO
$stmt = $conn->query("SELECT * FROM theme_settings WHERE id = 1");
$theme = $stmt->fetch();

$stmt = $conn->prepare("SELECT * FROM seo_settings WHERE page_name = ?");
$stmt->execute(['portfolio']);
$seo = $stmt->fetch();

$site_title = get_setting($conn, 'site_title');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $seo['meta_title'] ?? 'Portfolio - ' . $site_title; ?></title>
    <meta name="description" content="<?php echo $seo['meta_description'] ?? ''; ?>">
    <link rel="icon" href="uploads/images/<?php echo get_setting($conn, 'site_favicon'); ?>">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: <?php echo $theme['primary_color']; ?>;
            --secondary-color: <?php echo $theme['secondary_color']; ?>;
            --font-family: <?php echo $theme['font_family']; ?>, sans-serif;
        }
    </style>
</head>
<body class="<?php echo $theme['theme_mode']; ?>-mode">
    <?php include 'includes/header.php'; ?>
    
    <section class="page-header">
        <div class="container">
            <h1>My Portfolio</h1>
            <p>Explore my latest work and projects</p>
        </div>
    </section>
    
    <section class="portfolio-page">
        <div class="container">
            <div class="portfolio-filter">
                <button class="filter-btn <?php echo $filter_category === 'all' ? 'active' : ''; ?>" 
                        onclick="window.location.href='portfolio.php?category=all'">All</button>
                <?php foreach($categories as $cat): ?>
                <button class="filter-btn <?php echo $filter_category === $cat['project_category'] ? 'active' : ''; ?>"
                        onclick="window.location.href='portfolio.php?category=<?php echo urlencode($cat['project_category']); ?>'">
                    <?php echo $cat['project_category']; ?>
                </button>
                <?php endforeach; ?>
            </div>
            
            <div class="portfolio-grid">
                <?php foreach($projects as $project): ?>
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
                        <p><?php echo truncate_text($project['project_description'], 120); ?></p>
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
        </div>
    </section>
    
    <?php include 'includes/footer.php'; ?>
    <script src="assets/js/main.js"></script>
</body>
</html>
