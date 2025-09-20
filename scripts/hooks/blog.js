/*
 * Blog-specific processing hook
 */

import fs from 'fs';
import path from 'path';
import { registerHook, ensureDir } from './builder.js';


function createSlug(title, date) {
    // Example: "My First Post!" -> "my-first-post" -> "2025/09/my-first-post"
    let slug = title.toLowerCase()
        .replace(/[^a-z0-9\s-]/g, '') // Remove invalid chars
        .replace(/\s+/g, '-')         // Replace spaces with hyphens
        .replace(/-+/g, '-')          // Collapse multiple hyphens
        .replace(/^-+|-+$/g, '');     // Trim hyphens from start/end
        
    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, '0');
    slug = `${year}/${month}/${slug}`;
    return slug;
}

/*
 * Ensure code blocks have proper language-* classes for highlight.js
 */
function fixCodeBlockLanguages(html) {
    // Only add 'language-' if not already present
    return html.replace(
        /<code class="(?!language-)([a-zA-Z0-9-_]+)">/g,
        '<code class="language-$2">'
    );
}

/*
 * Process blog posts and create a meta.json index
 */
function processBlogPosts(blogContent, outputDir) {
    const blogMeta = [];
    
    // Extract just the metadata and path info for each post
    Object.entries(blogContent).forEach(([contentPath, data]) => {
        // Extract the path parts (e.g., "blog/2025/09/test" -> ["blog", "2025", "09", "test"])
        const pathParts = contentPath.split('/');
        const slug = pathParts[pathParts.length - 1];
        
        // Fix code block language classes for highlight.js
        let html = data.html || '';
        html = fixCodeBlockLanguages(html);

        // Create a lightweight meta entry
        const metaEntry = {
            slug: createSlug(data.meta.title || slug, new Date(data.meta.date || Date.now())),
            path: contentPath,
            content: html, // Use fixed HTML
            ...(data.meta || {}), // Include all frontmatter
        };
        
        // Add reading time estimation (rough calculation)
        if (html) {
            const wordCount = html.replace(/<[^>]*>/g, '').split(/\s+/).length;
            metaEntry.readingTime = Math.ceil(wordCount / 200); // ~200 words per minute
        }
        
        blogMeta.push(metaEntry);
    });
    
    // Sort by date (newest first), fallback to slug
    blogMeta.sort((a, b) => {
        const dateA = new Date(a.date || 0);
        const dateB = new Date(b.date || 0);
        
        if (dateA.getTime() === dateB.getTime()) {
            return a.slug.localeCompare(b.slug);
        }
        
        return dateB - dateA;
    });
    
    // Write the blog meta file
    const blogDir = path.join(outputDir, 'blog');
    ensureDir(blogDir);
    
    const metaPath = path.join(blogDir, 'meta.json');
    fs.writeFileSync(metaPath, JSON.stringify({
        posts: blogMeta,
        count: blogMeta.length,
        lastUpdated: new Date().toISOString()
    }, null, 2));
    
    console.log(`Generated blog meta.json with ${blogMeta.length} posts`);
}

// Register the hook for blog content
registerHook('blog/*', processBlogPosts);