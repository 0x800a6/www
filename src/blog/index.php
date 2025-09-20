<?php
require_once __DIR__ . '/../utils/content.php';
require_once __DIR__ . '/../utils/data.php';

$posts = get_blog_posts() ?: [];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    $title = "Blog Posts";
    $description = "View all blog posts by Lexi (0x800a6) on various topics including programming, privacy, and open source.";
    include '../includes/seo.php';
    ?>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="/static/css/bootstrap.min.css">
    <link rel="stylesheet" href="/static/css/style.css">
    <link rel="stylesheet" href="/static/css/blog.css">
</head>
<body>
    <?php include '../includes/nav.php'; ?>
    <main>
        <!-- Hero -->
        <section class="hero">
            <div class="container">
                <h1 class="fancy">Blog Posts</h1>
                <p class="lead">Read the latest articles and updates from Lexi (0x800a6).</p>
            </div>
        </section>

        <div class="container my-5">
            <?php if (!empty($posts)): ?>
                <div class="row g-4">
                    <?php foreach ($posts as $post): ?>
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="card h-100 border-0 blog-card">
                                <div class="card-body d-flex flex-column">
                                    <h3 class="card-title mb-2">
                                        <a href="/blog/<?php echo htmlspecialchars($post['slug']); ?>" class="text-decoration-none text-primary">
                                            <?php echo htmlspecialchars($post['title']); ?>
                                        </a>
                                    </h3>
                                    <div class="mb-2 text-muted small">
                                        <?php echo date('F j, Y', strtotime($post['date'])); ?>
                                        <?php if (isset($post['readingTime'])): ?>
                                            • <?php echo $post['readingTime']; ?> min read
                                        <?php endif; ?>
                                    </div>
                                    <?php if (!empty($post['tags'])): ?>
                                        <div class="mb-2">
                                            <?php foreach (array_slice($post['tags'], 0, 3) as $tag): ?>
                                                <span class="badge bg-secondary"><?php echo htmlspecialchars($tag); ?></span>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>
                                    <p class="card-text flex-grow-1"><?php echo htmlspecialchars($post['summary']); ?></p>
                                    <div class="mt-3">
                                        <a href="/blog/<?php echo htmlspecialchars($post['slug']); ?>" class="btn btn-outline-primary btn-sm w-100">Read More</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p class="text-center text-muted">No blog posts yet. Check back soon!</p>
            <?php endif; ?>
        </div>
    </main>
    <?php include '../includes/footer.php'; ?>
</body>
</html>