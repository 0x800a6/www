<?php
// Function to get all posts from the current directory
function get_all_posts()
{
  $files = glob('post/*.php');
  $files = array_diff($files);
  $posts = array();
  
  foreach ($files as $file) {
    // Read the file content
    $content = file_get_contents($file);
    
    // Extract variables using regex
    $title = extract_php_variable($content, 'title');
    $slug = extract_php_variable($content, 'slug');
    $language = extract_php_variable($content, 'language');
    $date = extract_php_variable($content, 'date');
    $description = extract_php_variable($content, 'description');
    
    // Store the post data
    $posts[] = array(
      'file' => $file,
      'title' => $title ?: 'Untitled',
      'slug' => $slug ?: 'untitled',
      'language' => $language ?: 'Unknown',
      'date' => $date ?: 'Unknown',
      'description' => $description ?: 'No description available'
    );
  }
  
  // Sort by date (newest first)
  usort($posts, function($a, $b) {
    return strcmp($b['date'], $a['date']);
  });
  
  return $posts;
}

function extract_php_variable($content, $variable_name) {
  // Pattern to match PHP variable assignment
  $pattern = '/\$' . $variable_name . '\s*=\s*"([^"]*)"\s*;/';
  if (preg_match($pattern, $content, $matches)) {
    return $matches[1];
  }
  
  // Try single quotes as fallback
  $pattern = '/\$' . $variable_name . '\s*=\s*\'([^\']*)\'\s*;/';
  if (preg_match($pattern, $content, $matches)) {
    return $matches[1];
  }
  
  return null;
}

// Get all posts
$posts = get_all_posts();
$total_posts = count($posts);
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    
    <!-- Primary Meta Tags -->
    <title>Blog Posts | Lexi's Website</title>
    <meta name="title" content="Blog Posts - Software Development & Tech Articles" />
    <meta name="description" content="Explore my latest blog posts about software development, programming tutorials, and tech insights. From low-level C experiments to modern web development." />
    <meta name="keywords" content="blog posts, software development, programming tutorials, tech articles, c programming, rust, typescript, web development" />
    <meta name="author" content="Lexi Rose Rogers" />
    <meta name="robots" content="index, follow" />
    <meta name="language" content="English" />
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website" />
    <meta property="og:url" content="https://lrr.sh/posts/" />
    <meta property="og:title" content="Blog Posts - Software Development & Tech Articles" />
    <meta property="og:description" content="Explore my latest blog posts about software development, programming tutorials, and tech insights. From low-level C experiments to modern web development." />
    <meta property="og:image" content="https://lrr.sh/static/images/picture.jpg" />
    <meta property="og:site_name" content="Lexi's Website" />
    <meta property="og:locale" content="en_US" />
    
    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image" />
    <meta property="twitter:url" content="https://lrr.sh/posts/" />
    <meta property="twitter:title" content="Blog Posts - Software Development & Tech Articles" />
    <meta property="twitter:description" content="Explore my latest blog posts about software development, programming tutorials, and tech insights. From low-level C experiments to modern web development." />
    <meta property="twitter:image" content="https://lrr.sh/static/images/picture.jpg" />
    
    <!-- Additional SEO -->
    <link rel="canonical" href="https://lrr.sh/posts/" />
    <meta name="theme-color" content="#1d2021" />
    
    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="/static/images/picture.jpg" />
    
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="/static/css/style.css">
    
    <style>
      .post-card {
        background: var(--bg-secondary);
        border: 1px solid var(--border);
        border-radius: 8px;
        padding: 1.5rem;
        margin: 1rem 0;
        transition: all 0.2s ease;
      }
      .post-card:hover {
        border-color: var(--green);
        box-shadow: 0 0 10px rgba(152, 151, 26, 0.1);
        transform: translateY(-2px);
      }
      .post-title a {
        color: var(--green);
        text-decoration: none;
        font-size: 1.3rem;
        font-weight: bold;
      }
      .post-title a:hover {
        color: var(--aqua);
      }
      .post-meta {
        color: var(--gray);
        font-size: 0.9rem;
        margin: 0.5rem 0;
      }
      .post-meta strong {
        color: var(--yellow);
      }
      .post-description {
        color: var(--fg);
        margin: 0.5rem 0;
        line-height: 1.6;
      }
      .language-badge {
        display: inline-block;
        background: var(--blue);
        color: white;
        padding: 0.2rem 0.6rem;
        border-radius: 12px;
        font-size: 0.8rem;
        font-weight: bold;
        margin-right: 0.5rem;
      }
      .stats-section {
        background: var(--bg-secondary);
        border: 1px solid var(--border);
        border-radius: 8px;
        padding: 1.5rem;
        margin: 2rem 0;
        text-align: center;
      }
      .stats-number {
        font-size: 2rem;
        font-weight: bold;
        color: var(--green);
      }
      .stats-label {
        color: var(--gray);
        font-size: 0.9rem;
      }
      .empty-state {
        text-align: center;
        padding: 3rem 1rem;
        color: var(--gray);
      }
      .empty-state h3 {
        color: var(--yellow);
        margin-bottom: 1rem;
      }
    </style>
  </head>
  <body class="container">
    <!-- Navbar -->
    <?php include 'includes/navbar.php'; ?>
    
    <!-- Header -->
    <header>
      <h1 id="title">Blog Posts</h1>
      <p>
        Software development insights, programming tutorials, and tech experiments.
        From low-level C to modern web development.
      </p>
    </header>

    <!-- Stats Section -->
    <div class="stats-section">
      <div class="stats-number"><?php echo $total_posts; ?></div>
      <div class="stats-label"><?php echo $total_posts === 1 ? 'Post' : 'Posts'; ?> Published</div>
    </div>

    <!-- Posts List -->
    <div class="posts-container">
      <?php if (empty($posts)): ?>
        <div class="empty-state">
          <h3>No posts yet</h3>
          <p>Blog posts will appear here as they are published.</p>
        </div>
      <?php else: ?>
        <?php foreach ($posts as $post): ?>
          <div class="post-card">
            <div class="post-title">
              <a href="/post/<?php echo htmlspecialchars($post['slug']); ?>"><?php echo htmlspecialchars($post['title']); ?></a>
            </div>
            <div class="post-meta">
              <span class="language-badge"><?php echo htmlspecialchars($post['language']); ?></span>
              <strong>Published:</strong> <?php echo htmlspecialchars($post['date']); ?>
            </div>
            <div class="post-description">
              <?php echo htmlspecialchars($post['description']); ?>
            </div>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>

    <!-- Footer -->
    <?php include 'includes/footer.php'; ?>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>
    <script>
      // Anime.js animations
      anime({
        targets: "#title",
        opacity: [0, 1],
        translateY: [-20, 0],
        easing: "easeOutExpo",
        duration: 800,
      });
      anime({
        targets: ".post-card",
        opacity: [0, 1],
        translateY: [15, 0],
        delay: anime.stagger(100, { start: 500 }),
        duration: 600,
        easing: "easeOutQuad",
      });
      anime({
        targets: ".stats-section",
        opacity: [0, 1],
        scale: [0.95, 1],
        delay: 300,
        duration: 600,
        easing: "easeOutQuad",
      });
    </script>
  </body>
</html>
