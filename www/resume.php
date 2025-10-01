<?php

$url = 'https://docs.google.com/document/d/1ia6ayKeS1CLN5SwVPvzUR2GsDYlSpI9mBDJ4n_gTQ0U/edit?usp=sharing'
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- Primary Meta Tags -->
    <title>Resume | Lexi's Website</title>
    <meta name="title" content="Resume - Lexi's Website" />
    <meta name="description" content="View Lexi's resume, a comprehensive document showcasing her skills, experience, and qualifications." />
    <meta name="keywords" content="resume, Lexi, skills, experience, qualifications" />
    <meta name="author" content="Lexi Rose Rogers" />
    <meta name="robots" content="index, follow" />
    <meta name="language" content="English" />
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website" />
    <meta property="og:url" content="https://lrr.sh/resume" />
    <meta property="og:title" content="Resume - Lexi's Website" />
    <meta property="og:description" content="View Lexi's resume, a comprehensive document showcasing her skills, experience, and qualifications." />
    <meta property="og:image" content="https://lrr.sh/static/images/picture.jpg" />
    <meta property="og:site_name" content="Lexi's Website" />
    <meta property="og:locale" content="en_US" />
    
    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image" />
    <meta property="twitter:url" content="https://lrr.sh/resume" />
    <meta property="twitter:title" content="Resume - Lexi's Website" />
    <meta property="twitter:description" content="View Lexi's resume, a comprehensive document showcasing her skills, experience, and qualifications." />
    <meta property="twitter:image" content="https://lrr.sh/static/images/picture.jpg" />
    
    <!-- Additional SEO -->
    <link rel="canonical" href="https://lrr.sh/resume" />
    <meta name="theme-color" content="#1d2021" />
    <meta name="msapplication-TileColor" content="#1d2021" />
    
    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="/static/images/picture.jpg" />
    
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"
    />

    <link rel="stylesheet" href="/static/css/style.css">
  </head>
  <body class="container">
    <!-- Navbar -->
    <?php include 'includes/navbar.php'; ?>
    
    <!-- Header -->
    <header>
      <h1>Resume</h1>
      <p>View Lexi's resume, a comprehensive document showcasing her skills, experience, and qualifications.</p>
    </header>

    <!-- Resume Section -->
    <section id="resume">
      <div class="resume-container">
        <iframe src="<?php echo $url; ?>" width="100%" height="800px" frameborder="0"></iframe>
      </div>
    </section>

    <!-- Footer -->
    <?php include 'includes/footer.php'; ?>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>