<?php
function get_documents()
{
  $files = glob('*.php');
  $files = array_diff($files, ['index.php']);
  sort($files);
  return $files;
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    
    <!-- Primary Meta Tags -->
    <title>Technical Specifications Directory | Lexi's Website</title>
    <meta name="title" content="Technical Specifications Directory" />
    <meta name="description" content="Technical specifications, documentation, and standards for various projects and protocols. Machine-readable and human-readable guidelines for implementation and usage." />
    <meta name="keywords" content="technical specifications, documentation, standards, protocols, author dsl, configuration language, parser" />
    <meta name="author" content="Lexi Rose Rogers" />
    <meta name="robots" content="index, follow" />
    <meta name="language" content="English" />
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website" />
    <meta property="og:url" content="https://lrr.sh/specs/" />
    <meta property="og:title" content="Technical Specifications Directory" />
    <meta property="og:description" content="Technical specifications, documentation, and standards for various projects and protocols. Machine-readable and human-readable guidelines for implementation and usage." />
    <meta property="og:image" content="https://lrr.sh/static/images/picture.jpg" />
    <meta property="og:site_name" content="Lexi's Website" />
    <meta property="og:locale" content="en_US" />
    
    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image" />
    <meta property="twitter:url" content="https://lrr.sh/specs/" />
    <meta property="twitter:title" content="Technical Specifications Directory" />
    <meta property="twitter:description" content="Technical specifications, documentation, and standards for various projects and protocols. Machine-readable and human-readable guidelines for implementation and usage." />
    <meta property="twitter:image" content="https://lrr.sh/static/images/picture.jpg" />
    
    <!-- Additional SEO -->
    <link rel="canonical" href="https://lrr.sh/specs/" />
    <meta name="theme-color" content="#1d2021" />
    
    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="/static/images/picture.jpg" />
    
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />

    <link rel="stylesheet" href="/static/css/style.css">
    <style>
      .section {
        margin: 2rem 0;
        padding: 1.5rem;
        background: #1d2021;
        border: 1px solid #3c3836;
        border-radius: 8px;
      }
      .spec-item {
        background: #1d2021;
        border: 1px solid #3c3836;
        border-radius: 8px;
        padding: 1.5rem;
        margin: 1rem 0;
        transition: all 0.2s ease;
      }
      .spec-item:hover {
        border-color: var(--green);
        box-shadow: 0 0 10px rgba(152, 151, 26, 0.1);
      }
      .spec-title a {
        color: var(--green);
        text-decoration: none;
        font-size: 1.3rem;
        font-weight: bold;
      }
      .spec-title a:hover {
        color: var(--aqua);
      }
      .spec-description {
        color: var(--fg);
        margin: 0.5rem 0;
        line-height: 1.6;
      }
      .spec-meta {
        color: var(--gray);
        font-size: 0.9rem;
        margin-top: 0.5rem;
      }
      .spec-meta strong {
        color: var(--yellow);
      }
      .notice {
        background: #3c3836;
        border: 1px solid var(--yellow);
        border-radius: 6px;
        padding: 1rem;
        margin: 1rem 0;
        color: var(--fg);
      }
      .notice strong {
        color: var(--yellow);
      }
      ul {
        color: var(--fg);
      }
      ul li {
        margin: 0.5rem 0;
      }
      ul li strong {
        color: var(--green);
      }
    </style>
  </head>
  <body class="container">
    <!-- Navbar -->
    <?php include '../includes/navbar.php'; ?>
    
    <!-- Header -->
    <header>
      <h1 id="title">Technical Specifications Directory</h1>
      <p>
        This directory contains technical specifications, documentation, and standards
        for various projects and protocols. Each specification is designed to be
        machine-readable and human-readable, providing clear guidelines for
        implementation and usage.
      </p>
    </header>

    <div class="section" id="available-specs">
      <h2>Available Specifications</h2>
      
      <?php
      $specs = get_documents();
      if (empty($specs)):
        ?>
        <div class="notice">
          <p><strong>No specifications found.</strong> Specifications will appear here as they are added to the directory.</p>
        </div>
      <?php else: ?>
        <?php
        foreach ($specs as $spec_file):
          // Include the spec file to get its variables
          $title = 'Unknown Specification';
          $description = 'No description available';
          $version = 'Unknown';
          $type = 'Unknown';
          $status = 'Unknown';

          // Read the file and extract variables
          $file_content = file_get_contents($spec_file);
          if ($file_content) {
            // Extract PHP variables using regex
            if (preg_match('/\$title\s*=\s*[\'"]([^\'"]*)[\'"];/', $file_content, $matches)) {
              $title = $matches[1];
            }
            if (preg_match('/\$description\s*=\s*[\'"]([^\'"]*)[\'"];/', $file_content, $matches)) {
              $description = $matches[1];
            }
            if (preg_match('/\$version\s*=\s*[\'"]([^\'"]*)[\'"];/', $file_content, $matches)) {
              $version = $matches[1];
            }
            if (preg_match('/\$type\s*=\s*[\'"]([^\'"]*)[\'"];/', $file_content, $matches)) {
              $type = $matches[1];
            }
            if (preg_match('/\$status\s*=\s*[\'"]([^\'"]*)[\'"];/', $file_content, $matches)) {
              $status = $matches[1];
            }
          }
          ?>
        <div class="spec-item">
          <div class="spec-title">
            <!-- Remove .php from the file name -->
            <?php $spec_file = str_replace('.php', '', $spec_file); ?>
            <a href="<?php echo htmlspecialchars($spec_file); ?>"><?php echo htmlspecialchars($title); ?> v<?php echo htmlspecialchars($version); ?></a>
          </div>
          <div class="spec-description">
            <?php echo htmlspecialchars($description); ?>
          </div>
          <div class="spec-meta">
            <strong>Version:</strong> <?php echo htmlspecialchars($version); ?> | 
            <strong>Type:</strong> <?php echo htmlspecialchars($type); ?> | 
            <strong>Status:</strong> <?php echo htmlspecialchars($status); ?>
          </div>
        </div>
        <?php endforeach; ?>
        
        <div class="notice">
          <p><strong>Note:</strong> This directory is actively maintained. New specifications will be added as they are developed and finalized.</p>
        </div>
      <?php endif; ?>
    </div>

    <div class="section" id="spec-format">
      <h2>Specification Format</h2>
      <p>
        All specifications in this directory follow a consistent format:
      </p>
      <ul>
        <li><strong>Purpose</strong> - Clear explanation of what the specification defines</li>
        <li><strong>Syntax</strong> - Detailed grammar and rules</li>
        <li><strong>Examples</strong> - Practical usage examples</li>
        <li><strong>Implementation</strong> - Parser features and utilities</li>
        <li><strong>Testing</strong> - How to validate and test implementations</li>
        <li><strong>Extensibility</strong> - Guidelines for future extensions</li>
      </ul>
    </div>

    <div class="section" id="contributing">
      <h2>Contributing</h2>
      <p>
        Specifications are developed through careful analysis of requirements,
        community feedback, and real-world testing. If you have suggestions for
        improvements or new specifications, please reach out through the contact
        information in the individual specification documents.
      </p>
    </div>
    <!-- Footer -->
    <?php include '../includes/footer.php'; ?>

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
        targets: ".spec-item",
        opacity: [0, 1],
        translateY: [15, 0],
        delay: anime.stagger(200, { start: 500 }),
        duration: 700,
        easing: "easeOutQuad",
      });
    </script>
  </body>
</html>
