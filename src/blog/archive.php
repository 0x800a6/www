<?php
require_once __DIR__ . '/../utils/content.php';
require_once __DIR__ . '/../utils/data.php';

$year = isset($_GET['year']) ? $_GET['year'] : null;
$month = isset($_GET['month']) ? $_GET['month'] : null;

if (!$year) {
    http_response_code(404);
    include '../errors/404.php';
    exit;
}

$posts = get_blog_posts();
$filtered = array_filter($posts, function($p) use ($year, $month) {
    $y = substr($p['date'], 0, 4);
    $m = substr($p['date'], 5, 2);
    if ($month) {
        return $y === $year && $m === $month;
    }
    return $y === $year;
});
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    $title = "Blog Archive" . ($month ? " - $year/$month" : " - $year");
    $description = "Blog posts from " . ($month ? "$year/$month" : $year);
    include '../includes/seo.php';
    ?>
    <link rel="stylesheet" href="/static/css/bootstrap.min.css">
    <link rel="stylesheet" href="/static/css/style.css">
    <link rel="stylesheet" href="/static/css/blog.css">
</head>
<body>
    <?php include '../includes/nav.php'; ?>
    <main>
        <div class="container my-5">
            <h1 class="section-title fancy">
                Blog Posts for <?php echo htmlspecialchars($year); ?>
                <?php if ($month): ?>
                    /<?php echo htmlspecialchars($month); ?>
                <?php endif; ?>
            </h1>
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-body">
                            <?php if (empty($filtered)): ?>
                                <p class="text-center text-muted mb-0">No posts found.</p>
                            <?php else: ?>
                                <ul class="list-group list-group-flush">
                                    <?php foreach ($filtered as $post): ?>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <div>
                                                <a class="fw-bold text-decoration-none" href="/blog/<?php echo substr($post['date'],0,4); ?>/<?php echo substr($post['date'],5,2); ?>/<?php echo urlencode(basename($post['slug'])); ?>">
                                                    <?php echo htmlspecialchars($post['title']); ?>
                                                </a>
                                            </div>
                                            <span class="badge rounded-pill bg-light text-secondary small ms-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#ee9ca7" class="bi bi-calendar2-heart me-1" viewBox="0 0 16 16" style="vertical-align: -2px;">
                                                    <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 3a1 1 0 0 1 1-1h1v.5a.5.5 0 0 0 1 0V2h6v.5a.5.5 0 0 0 1 0V2h1a1 1 0 0 1 1 1v2H1V3zm0 3v8a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V6H1zm8.5 2.5c-.828 0-1.5.672-1.5 1.5 0 .828.672 1.5 1.5 1.5s1.5-.672 1.5-1.5c0-.828-.672-1.5-1.5-1.5zm-3 0c-.828 0-1.5.672-1.5 1.5 0 .828.672 1.5 1.5 1.5s1.5-.672 1.5-1.5c0-.828-.672-1.5-1.5-1.5z"/>
                                                </svg>
                                                <?php echo date('M j, Y', strtotime($post['date'])); ?>
                                            </span>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="text-center">
                        <a href="/blog" class="btn btn-outline-primary px-4 py-2">
                            &larr; Back to Blog
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <?php include '../includes/footer.php'; ?>
</body>
</html>