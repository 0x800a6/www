# Lexi's Personal Website

A modern, Gruvbox-themed personal website built with PHP, featuring a blog system, dotfiles showcase, and technical specifications. The site emphasizes privacy, minimalism, and developer-focused content.

## 🚀 Features

- **Gruvbox Dark Theme**: Consistent color scheme with terminal-inspired design
- **PHP Blog System**: Dynamic blog post generation from Markdown files
- **Dotfiles Showcase**: Interactive configuration file browser with syntax highlighting
- **Technical Specifications**: Author DSL specification and documentation system
- **Privacy-First**: No tracking, analytics, or external scripts beyond CDN resources
- **Responsive Design**: Works perfectly on desktop, tablet, and mobile
- **SEO Optimized**: Comprehensive meta tags, Open Graph, and structured data
- **Syntax Highlighting**: Prism.js integration for code blocks
- **Smooth Animations**: Anime.js for subtle, performant animations

## 📁 Project Structure

```
/
├── www/                          # Web root directory
│   ├── index.php                 # Main homepage with projects showcase
│   ├── posts.php                 # Blog posts listing page
│   ├── dotfiles.php              # Dotfiles showcase with accordion interface
│   ├── rss.xml.php               # RSS feed generator
│   ├── includes/                 # PHP includes
│   │   ├── navbar.php           # Navigation bar with Gruvbox styling
│   │   ├── footer.php           # Site footer
│   │   └── seo.php              # SEO meta tag generator functions
│   ├── post/                     # Individual blog post PHP files
│   │   └── building-a-modern-web-scraper-with-python.php
│   ├── specs/                    # Technical specifications
│   │   ├── index.php            # Specifications directory
│   │   └── author_txt.php       # Author DSL specification
│   └── static/                   # Static assets
│       ├── css/
│       │   └── style.css        # Main stylesheet with Gruvbox theme
│       └── images/              # Images and assets
├── posts/                        # Markdown blog posts
│   └── building-a-modern-web-scraper-with-python.md
├── data/                         # Data files
│   └── dotfiles/                # Configuration files for showcase
│       ├── .bashrc
│       ├── .vimrc
│       ├── i3_config
│       ├── picom.conf
│       ├── kitty.conf
│       └── spotlight.rasi
├── scripts/                      # Utility scripts
│   └── post-to-php.py           # Markdown to PHP converter
├── docker-compose.yml           # Docker Compose configuration
├── Dockerfile                   # Docker configuration
├── requirements.txt             # Python dependencies
└── README.md                    # This file
```

## 🛠 Technologies Used

### Backend

- **PHP 8.2**: Server-side processing and dynamic content generation
- **Apache**: Web server with mod_rewrite support

### Frontend

- **HTML5**: Semantic markup with accessibility features
- **CSS3**: Custom properties, Flexbox, animations, Gruvbox color scheme
- **JavaScript (ES6+)**: Modern JavaScript with anime.js animations
- **Bootstrap 5.3.3**: Responsive framework
- **Prism.js**: Syntax highlighting for code blocks

### Development & Deployment

- **Docker**: Containerized deployment
- **Python 3**: Blog post conversion script
- **Markdown**: Blog post authoring format

## 🚀 Quick Start

### Using Docker (Recommended)

1. **Clone the repository**:

   ```bash
   git clone <repository-url>
   cd www
   ```

2. **Start the development server**:

   ```bash
   docker-compose up -d
   ```

3. **Visit the site**: Open `http://localhost:8080` in your browser

### Local Development

1. **Prerequisites**:

   - PHP 8.2+ with Apache
   - Python 3.8+ (for blog post conversion)

2. **Install Python dependencies**:

   ```bash
   pip install -r requirements.txt
   ```

3. **Start local server**:

   ```bash
   # Using PHP built-in server
   php -S localhost:8000 -t www/

   # Or configure Apache to serve the www/ directory
   ```

## 📝 Blog System

The website includes a custom blog system that converts Markdown posts to PHP templates:

### Creating a New Blog Post

1. **Create a Markdown file** in the `posts/` directory with YAML frontmatter:

   ```markdown
   ---
   title: Your Post Title
   language: Python
   date: 2025-01-27
   description: Brief description of your post
   ---

   Your markdown content here...
   ```

2. **Convert to PHP**:

   ```bash
   python3 scripts/post-to-php.py posts/your-post.md
   ```

3. **The script generates**:
   - PHP template with SEO meta tags
   - Open Graph and Twitter Card metadata
   - JSON-LD structured data
   - Syntax highlighting support

### Blog Post Features

- **Automatic SEO**: Comprehensive meta tags and structured data
- **Syntax Highlighting**: Prism.js integration for code blocks
- **Responsive Design**: Mobile-friendly layout
- **RSS Feed**: Automatic RSS feed generation at `/rss.xml.php`

## 🎨 Customization

### Colors and Theme

The site uses a Gruvbox Dark color scheme. Edit CSS custom properties in `www/static/css/style.css`:

```css
:root {
  --bg: #282828;
  --fg: #ebdbb2;
  --red: #cc241d;
  --green: #98971a;
  --yellow: #d79921;
  --blue: #458588;
  --purple: #b16286;
  --aqua: #689d6a;
  --gray: #a89984;
}
```

### Content Updates

- **Homepage**: Edit `www/index.php`
- **Blog Posts**: Add Markdown files to `posts/` and convert with the script
- **Dotfiles**: Add configuration files to `data/dotfiles/`
- **Specifications**: Add new specs in `www/specs/`

### Adding New Pages

1. Create new PHP file in `www/`
2. Include navbar and footer:
   ```php
   <?php include 'includes/navbar.php'; ?>
   <!-- Your content -->
   <?php include 'includes/footer.php'; ?>
   ```
3. Add navigation link in `www/includes/navbar.php`

## 🐳 Docker Deployment

### Development

```bash
docker-compose up -d
```

### Production

```bash
# Build production image
docker build -t lexi-website .

# Run production container
docker run -d -p 80:80 --name website lexi-website
```

## 📋 Dotfiles Showcase

The website includes an interactive dotfiles showcase featuring:

- **Accordion Interface**: Collapsible sections for each config file
- **Syntax Highlighting**: Prism.js for proper code formatting
- **Copy Functionality**: One-click copying of configuration snippets
- **Responsive Design**: Works on all device sizes

Supported configuration files:

- `.bashrc` - Bash shell configuration
- `.vimrc` - Vim editor configuration
- `i3_config` - i3 window manager configuration
- `picom.conf` - Picom compositor configuration
- `kitty.conf` - Kitty terminal configuration
- `spotlight.rasi` - Rofi launcher theme

## 🔧 Technical Specifications

The site includes a specifications system for technical documentation:

- **Author DSL**: Configuration language specification for author metadata
- **Extensible Format**: Easy to add new specifications
- **Machine-Readable**: Structured metadata for tools and parsers

## 🔒 Privacy Features

- **No Tracking**: No Google Analytics, Facebook pixels, or tracking scripts
- **No Cookies**: No cookie consent needed
- **Minimal External Requests**: Only essential CDN resources (Bootstrap, Prism.js, anime.js)
- **Local Assets**: All custom assets served locally

## ♿ Accessibility Features

- **Keyboard Navigation**: Full keyboard support for all interactive elements
- **Screen Reader Support**: Semantic HTML and proper heading structure
- **High Contrast**: Dark theme with high contrast ratios
- **Focus Indicators**: Clear focus states for keyboard users
- **Responsive Design**: Works on all screen sizes

## 🚀 Performance Optimization

### Built-in Optimizations

- **Minimal Dependencies**: Only essential external libraries
- **Efficient CSS**: Uses CSS custom properties and modern selectors
- **Optimized Images**: Minimal images, uses CSS for visual effects
- **Lazy Loading**: Animations only trigger when elements are visible
- **CDN Resources**: External libraries served from reliable CDNs

## 🧪 Testing

### Manual Testing

1. **Cross-browser testing**: Chrome, Firefox, Safari, Edge
2. **Mobile testing**: Various screen sizes and devices
3. **Accessibility testing**: Screen readers, keyboard navigation
4. **Performance testing**: Lighthouse audits

### Blog Post Testing

Test the blog system:

```bash
# Validate a post without creating PHP file
python3 scripts/post-to-php.py posts/your-post.md --dry-run

# Convert a post to PHP
python3 scripts/post-to-php.py posts/your-post.md
```

## 📱 Mobile Optimization

The site is fully responsive with:

- **Mobile-first design**: Optimized for small screens first
- **Touch-friendly**: Large touch targets for mobile users
- **Fast loading**: Minimal resources for mobile networks
- **Readable text**: Appropriate font sizes for mobile screens
- **Optimized animations**: Reduced motion on mobile devices

## 🔍 SEO Considerations

- **Semantic HTML**: Proper heading structure and semantic elements
- **Meta tags**: Title, description, and viewport meta tags
- **Open Graph**: Social media sharing optimization
- **Structured Data**: JSON-LD for rich snippets
- **RSS Feed**: Automatic RSS feed generation
- **Sitemap**: Clean URL structure for search engines

## 🛡 Security Features

- **No external scripts**: Reduces attack surface
- **Input validation**: PHP input sanitization
- **Error handling**: Proper error responses
- **Docker isolation**: Containerized deployment

## 📊 Browser Support

- **Modern Browsers**: Chrome 60+, Firefox 55+, Safari 12+, Edge 79+
- **CSS Features**: CSS Grid, Flexbox, Custom Properties
- **JavaScript**: ES6+ features
- **PHP**: Server-side processing with PHP 8.2+

## 🔄 Updates and Maintenance

### Regular Updates

- Keep external dependencies updated for security
- Update PHP dependencies and security patches
- Test on new browser versions
- Update content as needed

### Adding New Features

- Follow the existing code structure
- Maintain accessibility standards
- Test performance impact of new features
- Update documentation

## 📄 License

This project is open source. Feel free to use it as a template for your own website.

## 🤝 Contributing

While this is a personal website, suggestions and improvements are welcome:

- Open issues for bugs or suggestions
- Submit pull requests for improvements
- Share your own Gruvbox-themed modifications
- Contribute to the Author DSL specification

## 🆘 Troubleshooting

### Common Issues

**Blog posts not converting?**

- Check Python dependencies: `pip install -r requirements.txt`
- Verify Markdown file format and frontmatter
- Check file permissions

**PHP errors?**

- Verify PHP 8.2+ is installed
- Check Apache configuration
- Review PHP error logs

**Docker issues?**

- Ensure Docker and Docker Compose are installed
- Check port 8080 is available
- Review Docker logs: `docker-compose logs`

**Styling issues?**

- Check if CSS file is loading properly
- Verify Bootstrap and Prism.js CDN resources
- Check browser console for errors

## 📞 Support

If you encounter any issues:

1. Check the troubleshooting section above
2. Review browser console for errors
3. Test in different browsers
4. Ensure all files are properly uploaded
5. Check server logs for PHP/Apache errors

---

**Built with love by Lexi (0x800a6)**

_"Building the future, one line at a time"_

## 🔗 Links

- **Website**: [lrr.sh](https://lrr.sh)
- **GitHub**: [github.com/0x800a6](https://github.com/0x800a6)
- **Email**: lexi@lrr.sh
- **Mastodon**: [woof.tech/@lrr](https://woof.tech/@lrr)
- **Twitter**: [@lrr_dev](https://twitter.com/lrr_dev)
