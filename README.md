# Lexi's Portfolio Website

A modern, cyberpunk-themed portfolio website built with PHP, HTML, CSS, and JavaScript. Features a dark hacker aesthetic with terminal-inspired design, privacy-first principles, and comprehensive error handling.

## 🚀 Features

- **Dark Cyberpunk Theme**: Neon accents, glitch effects, and terminal-inspired design
- **PHP Backend**: Dynamic content generation and error handling
- **Smooth Animations**: Powered by anime.js for high-performance animations
- **Interactive Terminal**: Animated terminal windows with realistic command sequences
- **Privacy-First**: No tracking, analytics, or external scripts
- **Comprehensive Error Pages**: Custom 400, 401, 403, 404, and 500 error pages
- **Technical Specifications**: Author DSL specification and documentation system
- **Privacy Manifesto**: Detailed privacy philosophy and digital rights content
- **Responsive Design**: Works perfectly on desktop, tablet, and mobile
- **Accessibility**: WCAG compliant with keyboard navigation and reduced motion support
- **Performance Optimized**: Fast loading with minimal dependencies

## 📁 Project Structure

```
/
├── www/                          # Web root directory
│   ├── index.php                 # Main homepage
│   ├── privacy-manifesto.php     # Privacy manifesto page
│   ├── includes/                 # PHP includes
│   │   ├── header.php           # Site header
│   │   └── footer.php           # Site footer
│   ├── errors/                   # Custom error pages
│   │   ├── 400.php              # Bad Request
│   │   ├── 401.php              # Unauthorized
│   │   ├── 403.php              # Forbidden
│   │   ├── 404.php              # Not Found
│   │   └── 500.php              # Internal Server Error
│   ├── specs/                    # Technical specifications
│   │   ├── index.php            # Specifications directory
│   │   └── author_txt.php       # Author DSL specification
│   └── static/                   # Static assets
│       ├── css/
│       │   ├── styles.css       # Main stylesheet
│       │   └── vendor/          # Third-party CSS
│       ├── js/
│       │   ├── script.js        # Main JavaScript
│       │   └── vendor/          # Third-party JavaScript
│       └── images/              # Images and assets
├── scripts/                      # Build and utility scripts
│   ├── local-to-remote.js       # Asset downloader
│   ├── utils.js                 # Utility functions
│   └── package.json             # Node.js dependencies
├── docker-compose.yml           # Docker Compose configuration
├── Dockerfile                   # Docker configuration
├── download_list.txt            # Asset download list
└── README.md                    # This file
```

## 🛠 Technologies Used

### Backend

- **PHP 8.2**: Server-side processing and dynamic content
- **Apache**: Web server with mod_rewrite and security headers

### Frontend

- **HTML5**: Semantic markup with accessibility features
- **CSS3**: Custom properties, Grid, Flexbox, animations
- **JavaScript (ES6+)**: Modern JavaScript with anime.js
- **anime.js**: Lightweight animation library

### Development & Deployment

- **Docker**: Containerized deployment
- **Node.js**: Build tools and asset management
- **Git**: Version control

## 🚀 Quick Start

### Using Docker (Recommended)

1. **Clone the repository**:

   ```bash
   git clone <repository-url>
   cd portfolio
   ```

2. **Start the development server**:

   ```bash
   docker-compose up -d
   ```

3. **Visit the site**: Open `http://localhost:8080` in your browser

### Local Development

1. **Prerequisites**:

   - PHP 8.2+ with Apache
   - Node.js 16+ (for asset management)

2. **Install dependencies**:

   ```bash
   cd scripts
   npm install
   ```

3. **Download assets**:

   ```bash
   node local-to-remote.js ../download_list.txt
   ```

4. **Start local server**:

   ```bash
   # Using PHP built-in server
   php -S localhost:8000 -t www/

   # Or configure Apache to serve the www/ directory
   ```

## 🐳 Docker Deployment

### Development

```bash
docker-compose up -d
```

### Production

```bash
# Build production image
docker build -t lexi-portfolio .

# Run production container
docker run -d -p 80:80 --name portfolio lexi-portfolio
```

## 📋 Asset Management

The project includes a custom asset downloader that fetches external dependencies:

```bash
# Download all external assets
node scripts/local-to-remote.js download_list.txt
```

This downloads:

- Bootstrap Icons CSS and fonts
- Google Fonts (JetBrains Mono, Inter)
- Anime.js animation library

## 🎨 Customization

### Colors and Theme

Edit CSS custom properties in `www/static/css/styles.css`:

```css
:root {
  --bg-primary: #0a0a0a;
  --neon-cyan: #00ffff;
  --neon-green: #00ff41;
  --neon-purple: #bf00ff;
  /* ... other colors */
}
```

### Content Updates

- **Homepage**: Edit `www/index.php`
- **Privacy Manifesto**: Edit `www/privacy-manifesto.php`
- **Error Pages**: Customize in `www/errors/`
- **Specifications**: Add new specs in `www/specs/`

### Adding New Pages

1. Create new PHP file in `www/`
2. Include header and footer:
   ```php
   <?php include 'includes/header.php'; ?>
   <!-- Your content -->
   <?php include 'includes/footer.php'; ?>
   ```
3. Add navigation link in `www/includes/header.php`

## 🔧 Error Handling

The site includes comprehensive error pages with terminal-themed designs:

- **400 Bad Request**: Malformed request handling
- **401 Unauthorized**: Authentication required
- **403 Forbidden**: Access denied
- **404 Not Found**: Page not found
- **500 Internal Server Error**: Server error

Each error page includes:

- Appropriate HTTP status codes
- Terminal-themed interface
- Contextual error information
- Navigation back to homepage

## 📚 Technical Specifications

The site includes a specifications system for technical documentation:

- **Author DSL**: Configuration language specification
- **Extensible format**: Easy to add new specifications
- **Machine-readable**: Structured metadata for tools

## 🔒 Privacy Features

- **No Tracking**: No Google Analytics, Facebook pixels, or tracking scripts
- **No Cookies**: No cookie consent needed
- **Local Assets**: All assets served locally (after download)
- **Minimal External Requests**: Only essential external resources
- **Privacy Manifesto**: Detailed privacy philosophy and digital rights content

## ♿ Accessibility Features

- **Keyboard Navigation**: Full keyboard support for all interactive elements
- **Screen Reader Support**: Semantic HTML and ARIA labels
- **Reduced Motion**: Respects user's motion preferences
- **High Contrast**: Dark theme with high contrast ratios
- **Focus Indicators**: Clear focus states for keyboard users
- **Skip Links**: Quick navigation for screen readers

## 🚀 Performance Optimization

### Built-in Optimizations

- **Minimal Dependencies**: Only anime.js for animations
- **Efficient CSS**: Uses CSS custom properties and modern selectors
- **Optimized Images**: Minimal images, uses CSS for visual effects
- **Lazy Loading**: Animations only trigger when elements are visible
- **Asset Bundling**: All assets served locally

### Additional Optimizations

- **Gzip Compression**: Configure Apache to compress files
- **Browser Caching**: Set appropriate cache headers
- **CDN**: Serve static assets from a CDN
- **Minification**: Minify CSS and JavaScript for production

## 🧪 Testing

### Manual Testing

1. **Cross-browser testing**: Chrome, Firefox, Safari, Edge
2. **Mobile testing**: Various screen sizes and devices
3. **Accessibility testing**: Screen readers, keyboard navigation
4. **Performance testing**: Lighthouse audits

### Error Testing

Test error pages by visiting:

- `/nonexistent-page` (404)
- `/errors/400.php` (400)
- `/errors/401.php` (401)
- `/errors/403.php` (403)
- `/errors/500.php` (500)

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
- **Fast loading**: Optimized for Core Web Vitals
- **Mobile-friendly**: Responsive design for mobile-first indexing
- **Structured data**: JSON-LD for rich snippets

## 🛡 Security Features

- **No external scripts**: Reduces attack surface
- **Input validation**: PHP input sanitization
- **Error handling**: Proper error responses without information leakage
- **Security headers**: Apache security headers configuration
- **Docker isolation**: Containerized deployment

## 📊 Browser Support

- **Modern Browsers**: Chrome 60+, Firefox 55+, Safari 12+, Edge 79+
- **CSS Features**: CSS Grid, Flexbox, Custom Properties
- **JavaScript**: ES6+ features, Intersection Observer API
- **PHP**: Server-side processing with PHP 8.2+

## 🔄 Updates and Maintenance

### Regular Updates

- Keep anime.js updated for security and performance
- Update PHP dependencies and security patches
- Test on new browser versions
- Update content as needed

### Adding New Features

- Follow the existing code structure
- Maintain accessibility standards
- Test performance impact of new features
- Update documentation

## 📄 License

This project is open source. Feel free to use it as a template for your own portfolio.

## 🤝 Contributing

While this is a personal portfolio, suggestions and improvements are welcome:

- Open issues for bugs or suggestions
- Submit pull requests for improvements
- Share your own cyberpunk-themed modifications
- Contribute to the Author DSL specification

## 🆘 Troubleshooting

### Common Issues

**Animations not working?**

- Check if anime.js is loaded properly
- Ensure JavaScript is enabled in the browser
- Check browser console for errors

**PHP errors?**

- Verify PHP 8.2+ is installed
- Check Apache configuration
- Review PHP error logs

**Assets not loading?**

- Run the asset downloader: `node scripts/local-to-remote.js download_list.txt`
- Check file permissions
- Verify Apache document root

**Docker issues?**

- Ensure Docker and Docker Compose are installed
- Check port 8080 is available
- Review Docker logs: `docker-compose logs`

### Performance Issues

- Disable animations for users with reduced motion preference
- Consider reducing the number of particles in the background
- Check server resources and configuration

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

- **Website**: [0x800a6.dev](https://0x800a6.dev)
- **GitHub**: [github.com/0x800a6](https://github.com/0x800a6)
- **Email**: lexi@0x800a6.dev
- **PGP Key**: CBBCF7CA2AB792900F7D770A5C0C5E888156C86B
