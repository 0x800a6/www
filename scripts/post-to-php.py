#!/usr/bin/env python3
"""
Post to PHP Converter

Converts markdown blog posts with YAML frontmatter to PHP templates.
Supports syntax highlighting, validation, and comprehensive error handling.
"""

import sys
import os
import re
import logging
import argparse
import html
import json
from pathlib import Path
from typing import Dict, Optional, List
from datetime import datetime

import markdown
from markdown.extensions import codehilite, fenced_code, tables, toc

# Configure logging
logging.basicConfig(
    level=logging.INFO,
    format='%(asctime)s - %(levelname)s - %(message)s',
    handlers=[
        logging.StreamHandler(),
        logging.FileHandler('post-to-php.log')
    ]
)
logger = logging.getLogger(__name__)


class PostConverterError(Exception):
    """Custom exception for post conversion errors."""
    pass


class FrontmatterError(PostConverterError):
    """Exception raised for frontmatter parsing errors."""
    pass


class ValidationError(PostConverterError):
    """Exception raised for validation errors."""
    pass


def parse_frontmatter(content: str) -> Dict[str, str]:
    """
    Parses YAML frontmatter from a markdown string.
    
    Args:
        content: The markdown content to parse
        
    Returns:
        Dictionary of frontmatter keys and values
        
    Raises:
        FrontmatterError: If frontmatter format is invalid
    """
    if not content or not isinstance(content, str):
        raise FrontmatterError("Content must be a non-empty string")
    
    # Match frontmatter at the very start of the file
    fm_pattern = r'^---\s*\n(.*?)\n---\s*\n'
    match = re.match(fm_pattern, content, re.DOTALL)
    
    if not match:
        logger.warning("No frontmatter found in content")
        return {}
    
    frontmatter = match.group(1)
    fm_dict = {}
    
    try:
        for line_num, line in enumerate(frontmatter.splitlines(), 1):
            line = line.strip()
            if not line or line.startswith('#'):  # Skip empty lines and comments
                continue
                
            if ':' not in line:
                raise FrontmatterError(f"Invalid frontmatter format at line {line_num}: {line}")
            
            key, value = line.split(':', 1)
            key = key.strip()
            value = value.strip().strip('"\'')  # Remove quotes if present
            
            if not key:
                raise FrontmatterError(f"Empty key at line {line_num}")
                
            fm_dict[key] = value
            
    except Exception as e:
        if isinstance(e, FrontmatterError):
            raise
        raise FrontmatterError(f"Error parsing frontmatter: {e}")
    
    logger.info(f"Successfully parsed frontmatter with {len(fm_dict)} fields")
    return fm_dict

def markdown_to_html(content: str) -> str:
    """
    Converts a markdown string to HTML with syntax highlighting support.
    
    Args:
        content: The markdown content to convert
        
    Returns:
        HTML string with syntax highlighting
        
    Raises:
        PostConverterError: If markdown conversion fails
    """
    if not content:
        logger.warning("Empty content provided for markdown conversion")
        return ""
    
    try:
        extensions = [
            'fenced_code',
            'codehilite',
            'tables',
            'toc'
        ]
        
        extension_configs = {
            'codehilite': {
                'css_class': 'language-',
                'use_pygments': False,  # We'll use Prism.js for client-side highlighting
            }
        }
        
        md = markdown.Markdown(extensions=extensions, extension_configs=extension_configs)
        html_content = md.convert(content)
        
        logger.info("Successfully converted markdown to HTML")
        return html_content
        
    except Exception as e:
        raise PostConverterError(f"Failed to convert markdown to HTML: {e}")

def slugify(title: str) -> str:
    """
    Converts a title to a URL-friendly slug.
    
    Args:
        title: The title to convert to a slug
        
    Returns:
        URL-friendly slug string
        
    Raises:
        ValidationError: If title is empty or invalid
    """
    if not title or not isinstance(title, str):
        raise ValidationError("Title must be a non-empty string")
    
    # Lowercase, remove non-alphanumeric except hyphens/spaces, replace spaces with hyphens, strip hyphens
    slug = title.lower().strip()
    slug = re.sub(r'[^\w\s-]', '', slug)
    slug = re.sub(r'[\s_]+', '-', slug)
    slug = slug.strip('-')
    
    if not slug:
        raise ValidationError("Title resulted in empty slug")
    
    logger.debug(f"Generated slug '{slug}' from title '{title}'")
    return slug


def validate_frontmatter(frontmatter: Dict[str, str]) -> None:
    """
    Validates that required frontmatter fields are present and valid.
    
    Args:
        frontmatter: Dictionary of frontmatter fields
        
    Raises:
        ValidationError: If required fields are missing or invalid
    """
    required_fields = ['title', 'language', 'date', 'description']
    missing_fields = []
    
    for field in required_fields:
        if field not in frontmatter or not frontmatter[field].strip():
            missing_fields.append(field)
    
    if missing_fields:
        raise ValidationError(f"Missing required frontmatter fields: {', '.join(missing_fields)}")
    
    # Validate date format (basic check)
    date_str = frontmatter['date']
    try:
        datetime.strptime(date_str, '%Y-%m-%d')
    except ValueError:
        try:
            datetime.strptime(date_str, '%Y-%m-%d %H:%M:%S')
        except ValueError:
            raise ValidationError(f"Invalid date format: {date_str}. Expected YYYY-MM-DD or YYYY-MM-DD HH:MM:SS")
    
    # Validate title length
    if len(frontmatter['title']) > 200:
        raise ValidationError("Title is too long (max 200 characters)")
    
    # Validate description length
    if len(frontmatter['description']) > 500:
        raise ValidationError("Description is too long (max 500 characters)")
    
    logger.info("Frontmatter validation passed")


def escape_php_string(text: str) -> str:
    """
    Escapes a string for safe use in PHP.
    
    Args:
        text: The text to escape
        
    Returns:
        PHP-safe escaped string
    """
    if not text:
        return ""
    
    # Escape backslashes, quotes, and other special characters
    escaped = text.replace('\\', '\\\\')
    escaped = escaped.replace('"', '\\"')
    escaped = escaped.replace('$', '\\$')
    escaped = escaped.replace('\n', '\\n')
    escaped = escaped.replace('\r', '\\r')
    escaped = escaped.replace('\t', '\\t')
    
    return escaped

def generate_seo_meta_tags(frontmatter: Dict[str, str], slug: str) -> str:
    """
    Generates comprehensive SEO and Open Graph meta tags for a blog post.
    
    Args:
        frontmatter: Dictionary containing post metadata
        slug: URL-friendly slug for the post
        
    Returns:
        HTML string containing all SEO meta tags
    """
    title = frontmatter['title']
    description = frontmatter['description']
    language = frontmatter['language']
    date = frontmatter['date']
    
    # Generate keywords from title, language, and description
    keywords = f"{language.lower()}, programming, tutorial, blog, {title.lower().replace(' ', ', ')}"
    
    # Clean up keywords
    keywords = re.sub(r'[^\w\s,-]', '', keywords)
    keywords = re.sub(r'\s+', ', ', keywords)
    keywords = ', '.join([k.strip() for k in keywords.split(',') if k.strip()])
    
    # Generate post URL
    post_url = f"https://lrr.sh/posts/{slug}"
    
    # Escape HTML entities
    escaped_title = html.escape(title)
    escaped_description = html.escape(description)
    escaped_keywords = html.escape(keywords)
    
    seo_meta = f"""    <!-- Primary Meta Tags -->
    <title>{escaped_title} | Lexi's Website</title>
    <meta name="title" content="{escaped_title}" />
    <meta name="description" content="{escaped_description}" />
    <meta name="keywords" content="{escaped_keywords}" />
    <meta name="author" content="Lexi Rose Rogers" />
    <meta name="robots" content="index, follow" />
    <meta name="language" content="English" />
    <meta name="revisit-after" content="7 days" />
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="article" />
    <meta property="og:url" content="{post_url}" />
    <meta property="og:title" content="{escaped_title}" />
    <meta property="og:description" content="{escaped_description}" />
    <meta property="og:image" content="https://lrr.sh/static/images/picture.jpg" />
    <meta property="og:site_name" content="Lexi's Website" />
    <meta property="og:locale" content="en_US" />
    <meta property="article:author" content="Lexi Rose Rogers" />
    <meta property="article:section" content="Blog" />
    <meta property="article:tag" content="{html.escape(language)}" />
    <meta property="article:published_time" content="{date}" />
    
    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image" />
    <meta property="twitter:url" content="{post_url}" />
    <meta property="twitter:title" content="{escaped_title}" />
    <meta property="twitter:description" content="{escaped_description}" />
    <meta property="twitter:image" content="https://lrr.sh/static/images/picture.jpg" />
    
    <!-- Additional SEO -->
    <link rel="canonical" href="{post_url}" />
    <meta name="theme-color" content="#1d2021" />
    <meta name="msapplication-TileColor" content="#1d2021" />
    
    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="/static/images/picture.jpg" />"""
    
    return seo_meta

def generate_structured_data(frontmatter: Dict[str, str], slug: str) -> str:
    """
    Generates JSON-LD structured data for better SEO.
    
    Args:
        frontmatter: Dictionary containing post metadata
        slug: URL-friendly slug for the post
        
    Returns:
        HTML script tag containing JSON-LD structured data
    """
    title = frontmatter['title']
    description = frontmatter['description']
    language = frontmatter['language']
    date = frontmatter['date']
    
    # Generate post URL
    post_url = f"https://lrr.sh/posts/{slug}"
    
    structured_data = {
        "@context": "https://schema.org",
        "@type": "Article",
        "headline": title,
        "description": description,
        "url": post_url,
        "author": {
            "@type": "Person",
            "name": "Lexi Rose Rogers",
            "url": "https://lrr.sh"
        },
        "publisher": {
            "@type": "Organization",
            "name": "Lexi's Website",
            "url": "https://lrr.sh"
        },
        "datePublished": date,
        "dateModified": date,
        "mainEntityOfPage": {
            "@type": "WebPage",
            "@id": post_url
        },
        "keywords": [language, "programming", "tutorial", "blog"],
        "inLanguage": "en-US"
    }
    
    json_ld = json.dumps(structured_data, indent=2)
    return f"""    <!-- Structured Data -->
    <script type="application/ld+json">
{json_ld}
    </script>"""

def create_template(frontmatter: Dict[str, str], content: str, output_dir: str = "www/posts") -> str:
    """
    Creates a PHP template from a dictionary of frontmatter.
    
    Args:
        frontmatter: Dictionary containing post metadata
        content: The markdown content to convert
        output_dir: Directory where the PHP file will be saved
        
    Returns:
        Complete PHP template string
        
    Raises:
        ValidationError: If frontmatter validation fails
        PostConverterError: If template generation fails
    """
    try:
        # Validate frontmatter
        validate_frontmatter(frontmatter)
        
        # Generate slug and escape strings
        slug = slugify(frontmatter['title'])
        escaped_title = escape_php_string(frontmatter['title'])
        escaped_language = escape_php_string(frontmatter['language'])
        escaped_date = escape_php_string(frontmatter['date'])
        escaped_description = escape_php_string(frontmatter['description'])
        
        # Convert markdown to HTML
        html_content = markdown_to_html(content)
        
        # Generate SEO meta tags
        seo_meta = generate_seo_meta_tags(frontmatter, slug)
        
        # Generate structured data
        structured_data = generate_structured_data(frontmatter, slug)
        
        # Create the PHP template
        template = f"""<?php
$title = "{escaped_title}";
$language = "{escaped_language}";
$date = "{escaped_date}";
$slug = "{slug}";
$description = "{escaped_description}";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    
{seo_meta}
    
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    />
    <link rel="stylesheet" href="/static/css/style.css" />
    <!-- Prism.js for syntax highlighting -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/themes/prism.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/gh/PrismJS/prism-themes@master/themes/prism-gruvbox-dark.css" rel="stylesheet" />
</head>
<body class="container">
    <!-- Navbar -->
    <?php include '../includes/navbar.php'; ?>

    <!-- Post -->
    <article class="post mt-4">
        <h1>{frontmatter['title']}</h1>
        <p class="meta">{frontmatter['language']} • {frontmatter['date']}</p>
        {html_content}
    </article>

    <?php include '../includes/footer.php'; ?>

{structured_data}

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>
    <!-- Prism.js for syntax highlighting -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-core.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/plugins/autoloader/prism-autoloader.min.js"></script>
</body>
</html>"""
        
        logger.info(f"Successfully created template for '{frontmatter['title']}' with SEO meta tags")
        return template
        
    except Exception as e:
        if isinstance(e, (ValidationError, PostConverterError)):
            raise
        raise PostConverterError(f"Failed to create template: {e}")


class PostConverter:
    """
    Main class for converting markdown posts to PHP templates.
    """
    
    def __init__(self, output_dir: str = "www/posts"):
        """
        Initialize the PostConverter.
        
        Args:
            output_dir: Directory where PHP files will be saved
        """
        self.output_dir = Path(output_dir)
        self.output_dir.mkdir(parents=True, exist_ok=True)
        logger.info(f"PostConverter initialized with output directory: {self.output_dir}")
    
    def convert_post(self, post_path: str, force: bool = False) -> str:
        """
        Convert a markdown post to a PHP template.
        
        Args:
            post_path: Path to the markdown post file
            force: Whether to overwrite existing files
            
        Returns:
            Path to the created PHP file
            
        Raises:
            PostConverterError: If conversion fails
        """
        try:
            post_path = Path(post_path)
            
            if not post_path.exists():
                raise PostConverterError(f"Post file not found: {post_path}")
            
            if not post_path.suffix.lower() in ['.md', '.markdown']:
                raise PostConverterError(f"Invalid file type: {post_path.suffix}. Expected .md or .markdown")
            
            logger.info(f"Converting post: {post_path}")
            
            # Read the post content
            with open(post_path, 'r', encoding='utf-8') as file:
                content = file.read()
            
            # Parse frontmatter
            frontmatter = parse_frontmatter(content)
            
            # Remove frontmatter from content for markdown processing
            content_without_fm = re.sub(r'^---\s*\n.*?\n---\s*\n', '', content, flags=re.DOTALL)
            
            # Create template
            template = create_template(frontmatter, content_without_fm, str(self.output_dir))
            
            # Generate output path
            slug = slugify(frontmatter['title'])
            php_path = self.output_dir / f"{slug}.php"
            
            # Check if file exists and handle accordingly
            if php_path.exists() and not force:
                raise PostConverterError(f"PHP file already exists: {php_path}. Use --force to overwrite.")
            
            # Write the PHP file
            with open(php_path, 'w', encoding='utf-8') as file:
                file.write(template)
            
            logger.info(f"Successfully created PHP file: {php_path}")
            return str(php_path)
            
        except Exception as e:
            if isinstance(e, PostConverterError):
                raise
            raise PostConverterError(f"Failed to convert post: {e}")

def setup_argument_parser() -> argparse.ArgumentParser:
    """
    Set up the command-line argument parser.
    
    Returns:
        Configured ArgumentParser instance
    """
    parser = argparse.ArgumentParser(
        description="Convert markdown blog posts with YAML frontmatter to PHP templates with comprehensive SEO support",
        formatter_class=argparse.RawDescriptionHelpFormatter,
        epilog="""
Examples:
  %(prog)s posts/my-post.md
  %(prog)s posts/my-post.md --output custom/posts
  %(prog)s posts/my-post.md --force
  %(prog)s posts/my-post.md --verbose
  %(prog)s posts/my-post.md --dry-run

Required frontmatter fields:
  title: Post title
  language: Programming language or topic
  date: Publication date (YYYY-MM-DD or YYYY-MM-DD HH:MM:SS)
  description: Post description for SEO

Features:
  - Comprehensive SEO meta tags (Open Graph, Twitter Cards)
  - JSON-LD structured data for search engines
  - Automatic keyword generation from title and language
  - Syntax highlighting with Prism.js
  - Responsive Bootstrap layout
        """
    )
    
    parser.add_argument(
        'post_path',
        help='Path to the markdown post file to convert'
    )
    
    parser.add_argument(
        '-o', '--output',
        default='www/posts',
        help='Output directory for PHP files (default: www/posts)'
    )
    
    parser.add_argument(
        '-f', '--force',
        action='store_true',
        help='Overwrite existing PHP files without prompting'
    )
    
    parser.add_argument(
        '-v', '--verbose',
        action='store_true',
        help='Enable verbose logging output'
    )
    
    parser.add_argument(
        '--dry-run',
        action='store_true',
        help='Parse and validate the post without creating the PHP file'
    )
    
    parser.add_argument(
        '--version',
        action='version',
        version='%(prog)s 2.0.0'
    )
    
    return parser


def main():
    """
    Main entry point for the script.
    """
    parser = setup_argument_parser()
    args = parser.parse_args()
    
    # Configure logging level
    if args.verbose:
        logging.getLogger().setLevel(logging.DEBUG)
        logger.debug("Verbose logging enabled")
    
    try:
        # Initialize converter
        converter = PostConverter(output_dir=args.output)
        
        if args.dry_run:
            logger.info("Dry run mode - validating post without creating PHP file")
            
            # Read and validate the post
            post_path = Path(args.post_path)
            if not post_path.exists():
                raise PostConverterError(f"Post file not found: {post_path}")
            
            with open(post_path, 'r', encoding='utf-8') as file:
                content = file.read()
            
            frontmatter = parse_frontmatter(content)
            validate_frontmatter(frontmatter)
            
            # Remove frontmatter and validate markdown conversion
            content_without_fm = re.sub(r'^---\s*\n.*?\n---\s*\n', '', content, flags=re.DOTALL)
            html_content = markdown_to_html(content_without_fm)
            
            slug = slugify(frontmatter['title'])
            php_path = converter.output_dir / f"{slug}.php"
            
            print(f"✓ Post validation successful!")
            print(f"  Title: {frontmatter['title']}")
            print(f"  Slug: {slug}")
            print(f"  Output path: {php_path}")
            print(f"  Content length: {len(content_without_fm)} characters")
            print(f"  HTML length: {len(html_content)} characters")
            
        else:
            # Convert the post
            php_path = converter.convert_post(args.post_path, force=args.force)
            print(f"✓ Successfully created: {php_path}")
            
    except PostConverterError as e:
        logger.error(f"Conversion failed: {e}")
        print(f"❌ Error: {e}", file=sys.stderr)
        sys.exit(1)
    except KeyboardInterrupt:
        logger.info("Conversion cancelled by user")
        print("\n⚠️  Conversion cancelled", file=sys.stderr)
        sys.exit(1)
    except Exception as e:
        logger.error(f"Unexpected error: {e}", exc_info=True)
        print(f"❌ Unexpected error: {e}", file=sys.stderr)
        sys.exit(1)


if __name__ == "__main__":
    main()