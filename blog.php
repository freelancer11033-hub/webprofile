<?php
/**
 * Blog Page
 */

require_once 'config/database.php';
require_once 'includes/functions.php';
require_once 'includes/ads_helper.php';

$database = new Database();
$conn = $database->getConnection();

track_visitor($conn, 'blog');

// Pagination
$per_page = 9;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$pagination = paginate($conn, 'blog_posts', $per_page, $page, 'is_published = 1');

// Get blog posts
$stmt = $conn->prepare("SELECT b.*, c.category_name FROM blog_posts b 
                       LEFT JOIN blog_categories c ON b.category_id = c.id 
                       WHERE b.is_published = 1 
                       ORDER BY b.created_at DESC 
                       LIMIT ? OFFSET ?");
$stmt->execute([$pagination['per_page'], $pagination['offset']]);
$posts = $stmt->fetchAll();

// Get categories
$stmt = $conn->query("SELECT * FROM blog_categories ORDER BY category_name");
$categories = $stmt->fetchAll();

$site_title = get_setting($conn, 'site_title');
$stmt = $conn->query("SELECT * FROM theme_settings WHERE id = 1");
$theme = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog - <?php echo $site_title; ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: <?php echo $theme['primary_color']; ?>;
            --secondary-color: <?php echo $theme['secondary_color']; ?>;
        }
        .page-header {
            padding: 120px 0 60px;
            text-align: center;
            background: linear-gradient(135deg, rgba(99, 102, 241, 0.1), rgba(139, 92, 246, 0.1));
        }
        .page-header h1 {
            font-size: 3rem;
            margin-bottom: 1rem;
        }
        .blog-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 2rem;
            padding: 60px 0;
        }
        .blog-card {
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        .blog-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        }
        .blog-image {
            height: 220px;
            overflow: hidden;
        }
        .blog-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .blog-content {
            padding: 1.5rem;
        }
        .blog-meta {
            display: flex;
            gap: 1rem;
            margin-bottom: 1rem;
            font-size: 0.9rem;
            color: #64748b;
        }
        .pagination {
            display: flex;
            justify-content: center;
            gap: 0.5rem;
            padding: 2rem 0;
        }
        .pagination a {
            padding: 0.5rem 1rem;
            background: white;
            border-radius: 8px;
            color: var(--primary-color);
            text-decoration: none;
        }
        .pagination a.active {
            background: var(--primary-color);
            color: white;
        }
    </style>
</head>
<body class="<?php echo $theme['theme_mode']; ?>-mode">
    <?php include 'includes/header.php'; ?>
    <?php include_ad_tracking_script(); ?>
    
    <!-- Blog Header Ad -->
    <?php display_ad($conn, 'blog_header'); ?>
    
    <div class="page-header">
        <div class="container">
            <h1>Blog</h1>
            <p>Read my latest articles and tutorials</p>
        </div>
    </div>
    
    <section>
        <div class="container">
            <div class="row">
                <!-- Main Content -->
                <div class="col-lg-8">
                    <div class="blog-grid">
                        <?php foreach($posts as $index => $post): ?>
                        <div class="blog-card">
                            <?php if($post['featured_image']): ?>
                            <div class="blog-image">
                                <img src="uploads/images/<?php echo $post['featured_image']; ?>" alt="<?php echo $post['title']; ?>">
                            </div>
                            <?php endif; ?>
                            <div class="blog-content">
                                <div class="blog-meta">
                                    <span><i class="far fa-calendar"></i> <?php echo date('M d, Y', strtotime($post['created_at'])); ?></span>
                                    <span><i class="far fa-eye"></i> <?php echo $post['views']; ?> views</span>
                                </div>
                                <h3><?php echo $post['title']; ?></h3>
                                <p><?php echo truncate_text(strip_tags($post['content']), 120); ?></p>
                                <a href="blog-single.php?slug=<?php echo $post['slug']; ?>" class="btn btn-outline">Read More</a>
                            </div>
                        </div>
                        
                        <?php 
                        // Display ad after every 3 posts
                        if (($index + 1) % 3 === 0): 
                        ?>
                            <div class="col-12">
                                <?php display_ad($conn, 'blog_after_post'); ?>
                            </div>
                        <?php endif; ?>
                        
                        <?php endforeach; ?>
                    </div>
                    
                    <?php if($pagination['total_pages'] > 1): ?>
                    <div class="pagination">
                        <?php for($i = 1; $i <= $pagination['total_pages']; $i++): ?>
                        <a href="?page=<?php echo $i; ?>" class="<?php echo $i === $page ? 'active' : ''; ?>">
                            <?php echo $i; ?>
                        </a>
                        <?php endfor; ?>
                    </div>
                    <?php endif; ?>
                </div>
                
                <!-- Sidebar -->
                <div class="col-lg-4">
                    <div class="blog-sidebar">
                        <!-- Sidebar Top Ad -->
                        <?php display_ad($conn, 'blog_sidebar_top'); ?>
                        
                        <!-- Categories -->
                        <?php if(count($categories) > 0): ?>
                        <div class="sidebar-widget">
                            <h4>Categories</h4>
                            <ul class="category-list">
                                <?php foreach($categories as $category): ?>
                                <li>
                                    <a href="?category=<?php echo $category['category_slug']; ?>">
                                        <?php echo $category['category_name']; ?>
                                    </a>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <?php endif; ?>
                        
                        <!-- Sidebar Middle Ad -->
                        <?php display_ad($conn, 'blog_sidebar_middle'); ?>
                        
                        <!-- Recent Posts -->
                        <div class="sidebar-widget">
                            <h4>Recent Posts</h4>
                            <!-- Recent posts would go here -->
                        </div>
                        
                        <!-- Sidebar Bottom Ad -->
                        <?php display_ad($conn, 'blog_sidebar_bottom'); ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Blog Footer Ad -->
    <?php display_ad($conn, 'blog_footer'); ?>
    
    <?php include 'includes/footer.php'; ?>
    <script src="assets/js/main.js"></script>
</body>
</html>
