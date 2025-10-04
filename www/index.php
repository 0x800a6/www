<?php
function get_posts()
{
  $files = array_filter(glob('post/*.php'));
  $posts = array();
  $count = 0;


  foreach ($files as $file) {
    $count++;
    if ($count > 5) {
      break;
    }
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
  usort($posts, function ($a, $b) {
    return strcmp($b['date'], $a['date']);
  });

  return $posts;
}

function extract_php_variable($content, $variable_name)
{
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
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <!-- Primary Meta Tags -->
  <title>Lexi Rose Rogers - Software Developer & Cosplayer</title>
  <meta name="title" content="Lexi Rose Rogers - Software Developer & Cosplayer" />
  <meta name="description" content="Software & Web Developer, Cosplayer, Anime Enthusiast, and Privacy Advocate. Building things on Arch Linux with C, Rust, TypeScript, and more." />
  <meta name="keywords" content="software developer, web developer, cosplayer, anime, arch linux, rust, typescript, c programming, privacy advocate" />
  <meta name="author" content="Lexi Rose Rogers" />
  <meta name="robots" content="index, follow" />
  <meta name="language" content="English" />
  <meta name="revisit-after" content="7 days" />

  <!-- Open Graph / Facebook -->
  <meta property="og:type" content="website" />
  <meta property="og:url" content="https://lrr.sh/" />
  <meta property="og:title" content="Lexi Rose Rogers - Software Developer & Cosplayer" />
  <meta property="og:description" content="Software & Web Developer, Cosplayer, Anime Enthusiast, and Privacy Advocate. Building things on Arch Linux with C, Rust, TypeScript, and more." />
  <meta property="og:image" content="https://lrr.sh/static/images/picture.jpg" />
  <meta property="og:site_name" content="Lexi's Website" />
  <meta property="og:locale" content="en_US" />

  <!-- Twitter -->
  <meta property="twitter:card" content="summary_large_image" />
  <meta property="twitter:url" content="https://lrr.sh/" />
  <meta property="twitter:title" content="Lexi Rose Rogers - Software Developer & Cosplayer" />
  <meta property="twitter:description" content="Software & Web Developer, Cosplayer, Anime Enthusiast, and Privacy Advocate. Building things on Arch Linux with C, Rust, TypeScript, and more." />
  <meta property="twitter:image" content="https://lrr.sh/static/images/picture.jpg" />

  <!-- Additional SEO -->
  <link rel="canonical" href="https://lrr.sh/" />
  <meta name="theme-color" content="#1d2021" />
  <meta name="msapplication-TileColor" content="#1d2021" />

  <!-- Favicon -->
  <link rel="icon" type="image/svg+xml" href="/static/images/picture.jpg" />

  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
    rel="stylesheet" />
  <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" />

  <link rel="stylesheet" href="/static/css/style.css">
</head>

<body class="container">
  <!-- Navbar -->
  <?php include 'includes/navbar.php'; ?>
  <!-- Hero -->
  <header>
    <h1 id="title">Hey, I’m Lexi <small style="font-size: 0.5em;"><i>(she/her)</i></small></h1>
    <p>
      Software / Web Developer • Cosplayer • Anime Enthusiast • Arch btw
      <img src="/static/images/archlinux-icon.svg" alt="Arch Linux" style="width: 22px; height: 20px;">
    </p>
  </header>

  <!-- About Section -->
  <section id="about">
    <h2 class="section-title">About</h2>
    <p>
      I'm Lexi Rose Rogers, a software & web developer, cosplayer, anime enthusiast, and
      privacy advocate. My work spans from low-level C experiments (servers,
      brute force tools) to TypeScript bots and Rust utilities. I build things
      on Arch Linux, tweak endlessly, and explore both code and cosplay.
    </p>
  </section>

  <!-- Projects Portfolio -->
  <section id="projects">
    <h2 class="section-title">Projects</h2>
    <?php
    $posts = get_posts();
    foreach ($posts as $post) {
      echo "<article class=\"post\">
        <h2><a href=\"/post/{$post['slug']}\">{$post['title']}</a></h2>
        <p class=\"meta\">Language: {$post['language']} • Date: {$post['date']}</p>
        <p>
          {$post['description']}
        </p>
      </article>";
    }
    ?>

    <!-- Socials Section -->
    <section id="socials">
      <h2 class="section-title">Connect</h2>
      <div class="social-links">
        <a href="https://github.com/0x800a6" target="_blank" rel="noopener noreferrer" class="social-link" title="GitHub">
          <i class="bi bi-github"></i>
          <span>GitHub</span>
        </a>
        <a href="mailto:lexi@lrr.sh" class="social-link" title="Email">
          <i class="bi bi-envelope"></i>
          <span>Email</span>
        </a>
        <a href="https://woof.tech/@lrr" target="_blank" rel="noopener noreferrer" class="social-link" title="Mastodon">
          <i class="bi bi-mastodon"></i>
          <span>Mastodon</span>
        </a>
        <a href="https://twitter.com/lrr_dev" target="_blank" rel="noopener noreferrer" class="social-link" title="Twitter">
          <i class="bi bi-twitter-x"></i>
          <span>Twitter</span>
        </a>
        <a href="https://bsky.app/profile/lrr.sh" target="_blank" rel="noopener noreferrer" class="social-link" title="Bluesky">
          <i class="bi bi-cloud"></i>
          <span>Bluesky</span>
        </a>
        <a href="https://matrix.to/#/@lrr.sh:matrix.org" target="_blank" rel="noopener noreferrer" class="social-link" title="Matrix">
          <i class="bi bi-chat-dots"></i>
          <span>Matrix</span>
        </a>
      </div>
    </section>

    <!-- Discord Server -->
    <section id="discord">
      <h2 class="section-title">Discord</h2>
      <?php include 'components/discord.php'; ?>
    </section>

    <!-- Footer -->
    <?php include 'includes/footer.php'; ?>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>
    <script>
      anime({
        targets: "#title",
        opacity: [0, 1],
        translateY: [-20, 0],
        easing: "easeOutExpo",
        duration: 800,
      });
      anime({
        targets: ".post",
        opacity: [0, 1],
        translateY: [15, 0],
        delay: anime.stagger(200, {
          start: 500
        }),
        duration: 700,
        easing: "easeOutQuad",
      });
    </script>
</body>

</html>