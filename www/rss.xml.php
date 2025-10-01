<?php
// Set the content type to XML with proper headers
header('Content-Type: application/rss+xml; charset=utf-8');
header('Cache-Control: public, max-age=3600'); // Cache for 1 hour

// Function to get all posts from both PHP and Markdown sources
function get_all_posts()
{
  $posts = array();
  
  // Get PHP posts from post/ directory
  $php_files = glob('post/*.php');
  foreach ($php_files as $file) {
    $content = file_get_contents($file);
    
    // Extract variables using regex
    $title = extract_php_variable($content, 'title');
    $slug = extract_php_variable($content, 'slug');
    $language = extract_php_variable($content, 'language');
    $date = extract_php_variable($content, 'date');
    $description = extract_php_variable($content, 'description');
    
    if ($title && $slug && $date) {
      $posts[] = array(
        'file' => $file,
        'title' => $title,
        'slug' => $slug,
        'language' => $language ?: 'Any',
        'date' => $date,
        'description' => $description ?: 'No description available',
        'type' => 'php'
      );
    }
  }
  
  // Get Markdown posts from posts/ directory (parent directory)
  $md_files = glob('../posts/*.md');
  foreach ($md_files as $file) {
    $content = file_get_contents($file);
    
    // Extract frontmatter
    if (preg_match('/^---\s*\n(.*?)\n---\s*\n(.*)$/s', $content, $matches)) {
      $frontmatter = $matches[1];
      $body = $matches[2];
      
      $title = extract_yaml_value($frontmatter, 'title');
      $language = extract_yaml_value($frontmatter, 'language');
      $date = extract_yaml_value($frontmatter, 'date');
      $description = extract_yaml_value($frontmatter, 'description');
      
      if ($title && $date) {
        // Create slug from title
        $slug = strtolower(preg_replace('/[^a-zA-Z0-9]+/', '-', $title));
        $slug = trim($slug, '-');
        
        $posts[] = array(
          'file' => $file,
          'title' => $title,
          'slug' => $slug,
          'language' => $language ?: 'Any',
          'date' => $date,
          'description' => $description ?: 'No description available',
          'type' => 'markdown'
        );
      }
    }
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

function extract_yaml_value($yaml_content, $key) {
  // Simple YAML key-value extraction
  $pattern = '/^' . preg_quote($key, '/') . '\s*:\s*["\']?([^"\'\n]+)["\']?$/m';
  if (preg_match($pattern, $yaml_content, $matches)) {
    return trim($matches[1], '"\'');
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

// Function to escape XML content properly
function escape_xml($text) {
  return htmlspecialchars($text, ENT_XML1 | ENT_COMPAT, 'UTF-8');
}

// Function to generate proper post URL based on type
function get_post_url($post, $base_url) {
  if ($post['type'] === 'php') {
    return $base_url . '/post/' . $post['slug'];
  } else {
    return $base_url . '/posts/' . $post['slug'];
  }
}

// Start XML output
echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
?>
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom" xmlns:content="http://purl.org/rss/1.0/modules/content/">
  <channel>
    <title><![CDATA[Lexi's Website]]></title>
    <link><?php echo escape_xml($base_url); ?></link>
    <description><![CDATA[Software / Web Developer • Cosplayer • Anime Enthusiast • Arch btw]]></description>
    <language>en-us</language>
    <lastBuildDate><?php echo $last_build_date_rfc; ?></lastBuildDate>
    <pubDate><?php echo $last_build_date_rfc; ?></pubDate>
    <ttl>60</ttl>
    <generator>PHP RSS Generator</generator>
    <atom:link href="<?php echo escape_xml($base_url); ?>/rss.xml.php" rel="self" type="application/rss+xml" />
    <image>
      <url><?php echo escape_xml($base_url); ?>/static/images/picture.jpg</url>
      <title><![CDATA[Lexi's Website]]></title>
      <link><?php echo escape_xml($base_url); ?></link>
    </image>
    
    <?php foreach ($posts as $post): 
      $post_url = get_post_url($post, $base_url);
      $pub_date = date('r', strtotime($post['date']));
    ?>
    <item>
      <title><![CDATA[<?php echo escape_xml($post['title']); ?>]]></title>
      <link><?php echo escape_xml($post_url); ?></link>
      <description><![CDATA[<?php echo escape_xml($post['description']); ?>]]></description>
      <pubDate><?php echo $pub_date; ?></pubDate>
      <guid isPermaLink="true"><?php echo escape_xml($post_url); ?></guid>
      <category><![CDATA[<?php echo escape_xml($post['language']); ?>]]></category>
      <author><![CDATA[Lexi Rose Rogers &lt;lexi@lrr.sh&gt;]]></author>
    </item>
    <?php endforeach; ?>
    
  </channel>
</rss>
