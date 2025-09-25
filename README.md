<h1 align="center">Personal Website</h1>

A minimal, privacy-focused personal website built with PHP and Bootstrap. Features a blog system, markdown content processing, and zero tracking philosophy.

## Table of Contents

- [Features](#features)
- [Quick Start](#quick-start)
- [Development](#development)
- [Content Management](#content-management)
- [Deployment](#deployment)
- [File Structure](#file-structure)
- [Configuration](#configuration)
- [Privacy](#privacy)
- [Contributing](#contributing)
- [License](#license)

## Features

- **Zero Tracking**: No analytics, cookies, or external tracking scripts
- **Self-Hosted Assets**: All fonts and libraries are local (Bootstrap, Google Fonts)
- **Blog System**: Markdown-based blog with automatic content processing
- **Responsive Design**: Mobile-first Bootstrap 5 design
- **Docker Support**: Easy deployment with Docker and Docker Compose
- **Security Headers**: Comprehensive security configuration via `.htaccess`
- **Content Processing**: Automated markdown to JSON conversion
- **SEO Optimized**: Proper meta tags and structured content

## Quick Start

### Using Docker (Recommended)

```bash
git clone https://github.com/0x800a6/www.git
cd website
docker-compose up -d
```

Visit `http://localhost:8080`

### Manual Setup

1. **Prerequisites**: PHP 8.2+, Apache/Nginx, Node.js 18+

2. **Install dependencies**:

```bash
cd scripts
npm install  # or pnpm install
```

3. **Build content**:

```bash
npm run build:content
```

4. **Fetch external assets**:

```bash
npm run fetch:remote
```

5. **Configure web server** to serve the `src/` directory

## Development

### Content Processing

The website uses a Node.js build system to convert markdown content to JSON:

```bash
cd scripts
npm run build:content    # Process markdown files to JSON
npm run fetch:remote     # Download external assets locally
npm run clean           # Remove generated content
```

### Adding Blog Posts

1. Create markdown file in `content/blog/YYYY/MM/slug.md`:

```markdown
---
title: "Your Post Title"
date: "2025-09-20"
summary: "Brief description"
tags: ["tag1", "tag2"]
---

Your markdown content here...
```

2. Run the build process:

```bash
cd scripts
npm run build:content
```

### Local Development

```bash
# Using Docker
docker-compose up -d

# Or with PHP built-in server
cd src
php -S localhost:8000
```

## Content Management

### Personal Data

Edit `src/data/me.json` to update personal information:

```json
{
  "name": "Your Name",
  "bio": "Your bio",
  "avatar": "/static/avatar.gif",
  "contact": {
    "email": "you@example.com",
    "pgp_fingerprint": "YOUR_PGP_FINGERPRINT"
  },
  "greetings": ["Hi, I'm Your Name", "Hello World"]
}
```

### Blog Configuration

The blog system automatically:

- Processes markdown frontmatter
- Generates reading time estimates
- Creates archive pages by year/month
- Builds tag indexes
- Generates RSS feeds (planned)

## Deployment

### Docker Deployment

```bash
# Production deployment
docker-compose up -d --build

# With custom port
docker-compose up -d -p "80:80"
```

### Traditional Hosting

1. Upload `src/` contents to web root
2. Ensure Apache/Nginx can read `.htaccess`
3. Run build process on server or locally before upload

### Environment Variables

None required - the site is designed to work out of the box.

## File Structure

```
website/
├── content/                 # Source markdown content
│   └── blog/
│       └── YYYY/MM/        # Blog posts organized by date
├── scripts/                # Build system
│   ├── content.js          # Main content processor
│   ├── local.js           # Asset downloader
│   ├── hooks/             # Processing hooks
│   └── utils.js           # Utilities
├── src/                   # Web root
│   ├── blog/              # Blog PHP templates
│   ├── content/           # Generated JSON content
│   ├── data/              # Site configuration
│   ├── includes/          # PHP partials
│   ├── static/            # Assets (CSS, JS, images)
│   ├── utils/             # PHP utilities
│   └── index.php          # Homepage
├── docker-compose.yml      # Docker configuration
├── Dockerfile             # Container definition
└── download_list.txt      # External assets to download
```

<details><summary>Detailed Structure</summary>

- **`content/`**: Source markdown files organized by type and date
- **`scripts/`**: Node.js build system for processing content
  - `content.js`: Converts markdown to JSON with metadata
  - `local.js`: Downloads and stores external assets locally
  - `hooks/`: Extensible processing pipeline
- **`src/`**: Web application root
  - `blog/`: PHP templates for blog functionality
  - `content/`: Generated JSON files from markdown
  - `data/`: Site configuration and personal data
  - `includes/`: Reusable PHP components (nav, footer, SEO)
  - `static/`: All static assets (locally hosted)
  - `utils/`: PHP utility functions
- **Docker files**: Container configuration for easy deployment

</details>

## Configuration

### Security

The `.htaccess` file includes:

- Content Security Policy
- Security headers (X-Frame-Options, etc.)
- Directory access protection
- File type restrictions
- Compression and caching rules

### Performance

- **Asset Compression**: Gzip compression for text files
- **Browser Caching**: Long-term caching for static assets
- **Local Assets**: No external CDN dependencies
- **Minimal JavaScript**: Only essential scripts

## Privacy

This website is built with privacy as a core principle:

- ❌ No Google Analytics or tracking pixels
- ❌ No external font loading (Google Fonts hosted locally)
- ❌ No cookies or localStorage usage
- ❌ No IP address logging
- ❌ No fingerprinting or behavioral tracking
- ✅ All assets served from same domain
- ✅ Minimal JavaScript execution
- ✅ No third-party requests

## Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Make your changes
4. Test with `docker-compose up -d`
5. Commit your changes (`git commit -m 'feat: add amazing feature'`)
6. Push to the branch (`git push origin feature/amazing-feature`)
7. Open a Pull Request

### Development Guidelines

- Follow existing code style
- Test changes with Docker
- Update documentation for new features
- Maintain privacy-first principles
- Keep dependencies minimal

## License

This project is licensed under the MIT License. See the [LICENSE](./LICENSE) file for details.

---

**Built with**: PHP 8.2, Bootstrap 5, Node.js build system  
**Philosophy**: Privacy-first, minimal dependencies, maximum control
