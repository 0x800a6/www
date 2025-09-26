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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Specifications Directory - Lexi (0x800a6)</title>
    <meta name="description" content="Directory of technical specifications and documentation for various projects and standards.">
    <meta name="keywords" content="specifications, documentation, standards, technical specs, author dsl">
    <meta name="author" content="Lexi (0x800a6)">
    <meta name="robots" content="index, follow">
    <meta name="theme-color" content="#0a0a0a">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://0x800a6.dev/specs/">
    <meta property="og:title" content="Specifications Directory - Lexi (0x800a6)">
    <meta property="og:description" content="Directory of technical specifications and documentation">
    <meta property="og:image" content="https://0x800a6.dev/og-image.png">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="https://0x800a6.dev/specs/">
    <meta property="twitter:title" content="Specifications Directory - Lexi (0x800a6)">
    <meta property="twitter:description" content="Directory of technical specifications and documentation">
    <meta property="twitter:image" content="https://0x800a6.dev/og-image.png">
    <link rel="canonical" href="https://0x800a6.dev/specs/">

    <style>
      
      body {
        background: #f5f5f5;
        color: #000;
        font-family: monospace;
        line-height: 1.5;
        padding: 2em;
      }
      h1,
      h2,
      h3 {
        border-bottom: 1px solid #999;
        padding-bottom: 0.3em;
        margin-top: 2em;
      }
      pre {
        background: #eee;
        padding: 1em;
        overflow-x: auto;
      }
      code {
        color: #c00;
      }
      .section {
        margin-top: 2em;
      }
      a {
        color: #006;
        text-decoration: underline;
      }
      .notice {
        background: #ffc;
        padding: 0.5em;
        margin: 1em 0;
        border: 1px solid #cc0;
      }
      table {
        border-collapse: collapse;
        margin: 1em 0;
      }
      th,
      td {
        border: 1px solid #999;
        padding: 0.3em 0.5em;
      }
      .spec-item {
        background: #fff;
        border: 1px solid #ccc;
        padding: 1em;
        margin: 1em 0;
        border-radius: 3px;
      }
      .spec-title {
        font-size: 1.2em;
        font-weight: bold;
        margin-bottom: 0.5em;
      }
      .spec-description {
        color: #666;
        margin-bottom: 0.5em;
      }
      .spec-meta {
        font-size: 0.9em;
        color: #888;
      }
    </style>
  </head>
  <body>
    <h1>Technical Specifications Directory</h1>
    <p>
      This directory contains technical specifications, documentation, and standards
      for various projects and protocols. Each specification is designed to be
      machine-readable and human-readable, providing clear guidelines for
      implementation and usage.
    </p>

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

    <div class="section" id="navigation">
      <h2>Navigation</h2>
      <ul>
        <li><a href="../">← Back to Main Site</a></li>
        <li><a href="../privacy-manifesto">Privacy Manifesto</a></li>
        <li><a href="../index">Home</a></li>
      </ul>
    </div>
  </body>
</html>
