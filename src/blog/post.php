<?php
require_once __DIR__ . '/../utils/content.php';
require_once __DIR__ . '/../utils/data.php';

// Get parameters from URL
$year = isset($_GET['year']) ? $_GET['year'] : null;
$month = isset($_GET['month']) ? $_GET['month'] : null;
$slug = isset($_GET['slug']) ? $_GET['slug'] : null;

// Validate parameters
if (!$year || !$month || !$slug) {
    http_response_code(404);
    include '../errors/404.php';
    exit;
}

// Find the correct post by matching slug, year, and month
$posts = get_blog_posts();
$post = null;
foreach ($posts as $p) {
    // Accept slugs with or without year/month prefix
    $slugMatch = ($p['slug'] === $slug) || (basename($p['slug']) === $slug);

    // PATCH: If slug contains year/month, allow mismatch between URL and post date
    if ($slugMatch) {
        $post = get_blog_post($p['slug']);
        break;
    }

    // Fallback: match by date as before
    $dateMatch = substr($p['date'], 0, 4) === $year && substr($p['date'], 5, 2) === $month;
    if ($slugMatch && $dateMatch) {
        $post = get_blog_post($p['slug']);
        break;
    }
}

if (!$post) {
    http_response_code(404);
    include '../errors/404.php';
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    $title = htmlspecialchars($post['title']);
    $description = htmlspecialchars($post['summary']);
    include '../includes/seo.php';
    ?>
    <link rel="stylesheet" href="/static/css/bootstrap.min.css">
    <link rel="stylesheet" href="/static/css/style.css">
    <link rel="stylesheet" href="/static/css/blog.css">
    <link rel="stylesheet" href="/static/css/github.min.css">
</head>
<body>
    <?php include '../includes/nav.php'; ?>
    <main>
        <section class="hero" style="padding: 3rem 1rem;">
            <div class="container">
                <h1 class="fancy"><?php echo htmlspecialchars($post['title']); ?></h1>
                <div class="mb-2 text-muted small">
                    <?php echo date('F j, Y', strtotime($post['date'])); ?>
                    <?php if (isset($post['readingTime'])): ?>
                        • <?php echo $post['readingTime']; ?> min read
                    <?php endif; ?>
                </div>
                <?php if (!empty($post['tags'])): ?>
                    <div class="mb-2">
                        <?php foreach ($post['tags'] as $tag): ?>
                            <span class="badge bg-secondary"><?php echo htmlspecialchars($tag); ?></span>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                <p class="lead"><?php echo htmlspecialchars($post['summary']); ?></p>
            </div>
        </section>
        <div class="container my-5">
            <article class="blog-post-content">
                <?php
                // Render the post content (assume markdown or HTML)
                echo $post['content'];
                ?>
            </article>
        </div>
        <div class="container mb-5">
            <a href="/blog" class="btn btn-outline-primary">&larr; Back to Blog</a>
        </div>
    </main>
    <?php include '../includes/footer.php'; ?>
    <!-- Add highlight.js JS and auto-init -->
    <script type="module">
        import hljs from '/static/js/highlight.min.js';
        hljs.highlightAll();
    </script>
</body>
</html>