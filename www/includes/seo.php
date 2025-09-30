<?php
/**
 * SEO Meta Tags Generator
 * Provides consistent SEO and Open Graph meta tags across the website
 */

function generate_seo_meta($options = []) {
    // Default values
    $defaults = [
        'title' => 'Lexi\'s Website',
        'description' => 'Software & Web Developer, Cosplayer, Anime Enthusiast, and Privacy Advocate.',
        'keywords' => 'software developer, web developer, cosplayer, anime, arch linux',
        'url' => 'https://lrr.sh/',
        'image' => 'https://lrr.sh/static/images/picture.jpg',
        'type' => 'website', // website, article, profile
        'author' => 'Lexi Rose Rogers',
        'site_name' => 'Lexi\'s Website',
        'locale' => 'en_US',
        'robots' => 'index, follow',
        'theme_color' => '#1d2021',
        'canonical' => null,
        'article_author' => null,
        'article_section' => null,
        'article_tag' => null
    ];
    
    // Merge with provided options
    $seo = array_merge($defaults, $options);
    
    // Set canonical URL if not provided
    if ($seo['canonical'] === null) {
        $seo['canonical'] = $seo['url'];
    }
    
    // Set article author if not provided
    if ($seo['article_author'] === null) {
        $seo['article_author'] = $seo['author'];
    }
    
    // Generate the meta tags HTML
    $meta_html = '';
    
    // Primary Meta Tags
    $meta_html .= "    <!-- Primary Meta Tags -->\n";
    $meta_html .= "    <title>" . htmlspecialchars($seo['title']) . "</title>\n";
    $meta_html .= "    <meta name=\"title\" content=\"" . htmlspecialchars($seo['title']) . "\" />\n";
    $meta_html .= "    <meta name=\"description\" content=\"" . htmlspecialchars($seo['description']) . "\" />\n";
    $meta_html .= "    <meta name=\"keywords\" content=\"" . htmlspecialchars($seo['keywords']) . "\" />\n";
    $meta_html .= "    <meta name=\"author\" content=\"" . htmlspecialchars($seo['author']) . "\" />\n";
    $meta_html .= "    <meta name=\"robots\" content=\"" . htmlspecialchars($seo['robots']) . "\" />\n";
    $meta_html .= "    <meta name=\"language\" content=\"English\" />\n";
    
    // Open Graph / Facebook
    $meta_html .= "    \n    <!-- Open Graph / Facebook -->\n";
    $meta_html .= "    <meta property=\"og:type\" content=\"" . htmlspecialchars($seo['type']) . "\" />\n";
    $meta_html .= "    <meta property=\"og:url\" content=\"" . htmlspecialchars($seo['url']) . "\" />\n";
    $meta_html .= "    <meta property=\"og:title\" content=\"" . htmlspecialchars($seo['title']) . "\" />\n";
    $meta_html .= "    <meta property=\"og:description\" content=\"" . htmlspecialchars($seo['description']) . "\" />\n";
    $meta_html .= "    <meta property=\"og:image\" content=\"" . htmlspecialchars($seo['image']) . "\" />\n";
    $meta_html .= "    <meta property=\"og:site_name\" content=\"" . htmlspecialchars($seo['site_name']) . "\" />\n";
    $meta_html .= "    <meta property=\"og:locale\" content=\"" . htmlspecialchars($seo['locale']) . "\" />\n";
    
    // Article-specific meta tags
    if ($seo['type'] === 'article') {
        $meta_html .= "    <meta property=\"article:author\" content=\"" . htmlspecialchars($seo['article_author']) . "\" />\n";
        if ($seo['article_section']) {
            $meta_html .= "    <meta property=\"article:section\" content=\"" . htmlspecialchars($seo['article_section']) . "\" />\n";
        }
        if ($seo['article_tag']) {
            $meta_html .= "    <meta property=\"article:tag\" content=\"" . htmlspecialchars($seo['article_tag']) . "\" />\n";
        }
    }
    
    // Twitter
    $meta_html .= "    \n    <!-- Twitter -->\n";
    $meta_html .= "    <meta property=\"twitter:card\" content=\"summary_large_image\" />\n";
    $meta_html .= "    <meta property=\"twitter:url\" content=\"" . htmlspecialchars($seo['url']) . "\" />\n";
    $meta_html .= "    <meta property=\"twitter:title\" content=\"" . htmlspecialchars($seo['title']) . "\" />\n";
    $meta_html .= "    <meta property=\"twitter:description\" content=\"" . htmlspecialchars($seo['description']) . "\" />\n";
    $meta_html .= "    <meta property=\"twitter:image\" content=\"" . htmlspecialchars($seo['image']) . "\" />\n";
    
    // Additional SEO
    $meta_html .= "    \n    <!-- Additional SEO -->\n";
    $meta_html .= "    <link rel=\"canonical\" href=\"" . htmlspecialchars($seo['canonical']) . "\" />\n";
    $meta_html .= "    <meta name=\"theme-color\" content=\"" . htmlspecialchars($seo['theme_color']) . "\" />\n";
    $meta_html .= "    <meta name=\"msapplication-TileColor\" content=\"" . htmlspecialchars($seo['theme_color']) . "\" />\n";
    
    // Favicon
    $meta_html .= "    \n    <!-- Favicon -->\n";
    $meta_html .= "    <link rel=\"icon\" type=\"image/svg+xml\" href=\"/static/images/picture.jpg\" />\n";
    
    return $meta_html;
}

/**
 * Generate structured data (JSON-LD) for better SEO
 */
function generate_structured_data($type = 'Person', $data = []) {
    $defaults = [
        'Person' => [
            '@context' => 'https://schema.org',
            '@type' => 'Person',
            'name' => 'Lexi Rose Rogers',
            'url' => 'https://lrr.sh',
            'description' => 'Software & Web Developer, Cosplayer, Anime Enthusiast, and Privacy Advocate',
            'jobTitle' => 'Software Developer',
            'knowsAbout' => ['Software Development', 'Web Development', 'Cosplay', 'Anime', 'Arch Linux'],
            'sameAs' => []
        ],
        'WebSite' => [
            '@context' => 'https://schema.org',
            '@type' => 'WebSite',
            'name' => 'Lexi\'s Website',
            'url' => 'https://lrr.sh',
            'description' => 'Personal website of Lexi Rose Rogers - Software Developer & Cosplayer',
            'author' => [
                '@type' => 'Person',
                'name' => 'Lexi Rose Rogers'
            ]
        ],
        'Article' => [
            '@context' => 'https://schema.org',
            '@type' => 'Article',
            'headline' => '',
            'author' => [
                '@type' => 'Person',
                'name' => 'Lexi Rose Rogers'
            ],
            'publisher' => [
                '@type' => 'Organization',
                'name' => 'Lexi\'s Website'
            ],
            'datePublished' => '',
            'dateModified' => ''
        ]
    ];
    
    $structured_data = array_merge($defaults[$type] ?? $defaults['Person'], $data);
    
    return '<script type="application/ld+json">' . json_encode($structured_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . '</script>';
}
?>
