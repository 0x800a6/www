<?php
require_once (dirname(__FILE__) ."/../utils/data.php");

$me = $me_data; // For backward compatibility

// Default SEO values (customize as needed)
$title = $title ?? 'No Title Provided ' .' — ' . ($me['name'] ?? 'Your Website');
$description = $description ?? 'Welcome to ' . ($me['name'] ?? 'my website') . '. This is a personal portfolio and blog site.';
$url = $_SERVER['REQUEST_URI'];
$site_name = $site_name ?? ($me['name'] ?? 'Your Website');
$twitter_handle = $twitter_handle ?? $me['twitter'] ?? '@yourtwitter';

function getFileExt($file) {
    return pathinfo($file, PATHINFO_EXTENSION);
}
?>
<!-- Basic Meta Tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= htmlspecialchars($title) ?> — <?= htmlspecialchars($me['name'] ?? 'Your Website') ?></title>
<meta name="description" content="<?= htmlspecialchars($description) ?>">

<!-- Open Graph / Facebook -->
<meta property="og:type" content="website">
<meta property="og:url" content="<?= htmlspecialchars($url) ?>">
<meta property="og:title" content="<?= htmlspecialchars($title) ?> — <?= htmlspecialchars($me['name'] ?? 'Your Website') ?>">
<meta property="og:description" content="<?= htmlspecialchars($description) ?>">
<meta property="og:site_name" content="<?= htmlspecialchars($site_name) ?>">

<!-- Twitter -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:url" content="<?= htmlspecialchars($url) ?>">
<meta name="twitter:title" content="<?= htmlspecialchars($title) ?> — <?= htmlspecialchars($me['name'] ?? 'Your Website') ?>">
<meta name="twitter:description" content="<?= htmlspecialchars($description) ?>">
<meta name="twitter:site" content="<?= htmlspecialchars($twitter_handle) ?>">

<!-- Canonical -->
<link rel="canonical" href="<?= htmlspecialchars($url) ?>">

<!-- Robots -->
<meta name="robots" content="index, follow">

<!-- Theme Color -->
<meta name="theme-color" content="#222222">

<!-- Favicon -->
<link rel="icon" type="image/<?php echo getFileExt($me['avatar']); ?>" href="/<?= htmlspecialchars($me['avatar']) ?>">

<!-- OG:locale (optional, set as needed) -->
<meta property="og:locale" content="en_US">

<!-- Twitter:creator (optional, set as needed) -->
<meta name="twitter:creator" content="<?= htmlspecialchars($twitter_handle) ?>">

<!-- Extra: Prevent automatic detection of possible phone numbers -->
<meta name="format-detection" content="telephone=no">