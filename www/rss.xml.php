<?php
// Set the content type to XML
header('Content-Type: application/rss+xml; charset=utf-8');

// Function to get all posts (similar to index.php but without limit)
function get_all_posts()
{
  $files = glob('posts/*.php');
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

// Get the current domain and protocol
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
$domain = $_SERVER['HTTP_HOST'];
$base_url = $protocol . '://' . $domain;

// Get all posts
$posts = get_all_posts();

// Generate the most recent post date for lastBuildDate
$last_build_date = !empty($posts) ? $posts[0]['date'] : date('Y-m-d');
$last_build_date_rfc = date('r', strtotime($last_build_date));

// Start XML output
echo '<?xml version="1.0" encoding="UTF-8"?>';
?>
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
  <channel>
    <title>Lexi's Website</title>
    <link><?php echo $base_url; ?></link>
    <description>Software / Web Developer • Cosplayer • Anime Enthusiast • Arch btw</description>
    <language>en-us</language>
    <lastBuildDate><?php echo $last_build_date_rfc; ?></lastBuildDate>
    <atom:link href="<?php echo $base_url; ?>/rss.xml.php" rel="self" type="application/rss+xml" />
    
    <?php foreach ($posts as $post): ?>
    <item>
      <title><?php echo htmlspecialchars($post['title']); ?></title>
      <link><?php echo $base_url; ?>/posts/<?php echo htmlspecialchars($post['slug']); ?></link>
      <description><?php echo htmlspecialchars($post['description']); ?></description>
      <pubDate><?php echo date('r', strtotime($post['date'])); ?></pubDate>
      <guid isPermaLink="true"><?php echo $base_url; ?>/posts/<?php echo htmlspecialchars($post['slug']); ?></guid>
      <category><?php echo htmlspecialchars($post['language']); ?></category>
    </item>
    <?php endforeach; ?>
    
  </channel>
</rss>
