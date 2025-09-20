/*
 * Content processing script
 * 
 * This does the obvious thing: converts markdown, yaml, and ini files
 * to JSON because apparently that's what people want these days.
 * 
 * If you're wondering why this exists, blame the web developers.
 */

import fs from 'fs';
import path from 'path';
import { glob } from 'glob';
import matter from 'gray-matter';
import yaml from 'js-yaml';
import ini from 'ini';
import { marked } from 'marked';
import { fileURLToPath } from 'url';
import { die } from './utils.js';
import { processHooks } from './hooks/builder.js';

// Import hooks to register them
import './hooks/blog.js';

const __filename = fileURLToPath(import.meta.url);
const __dirname = path.dirname(__filename);

const CONTENT_DIR = path.resolve(__dirname, '../content');
const OUTPUT_DIR = path.resolve(__dirname, '../src/content');

/*
 * Create directory if it doesn't exist. Yes, this is necessary
 * because apparently fs.writeFileSync doesn't do this for you. :/
 */
function ensure_dir_exists(dir) {
    if (!fs.existsSync(dir)) {
        fs.mkdirSync(dir, { recursive: true });
    }
}

/*
 * Main processing loop. Find all the files and convert them.
 */
async function process_content() {
    try {
        const files = await glob('**/*.{md,yml,yaml,ini}', { cwd: CONTENT_DIR });
        
        if (files.length === 0) {
            die("No content files found to process.");
            return;
        }
        
        console.log(`Processing ${files.length} files...`);
        
        const index = {}; // Store everything for the index
        
        files.forEach(relative_path => {
            const full_path = path.join(CONTENT_DIR, relative_path);
            let output;
            
            if (relative_path.endsWith('.md')) {
                output = process_markdown(full_path, relative_path);
            } else if (relative_path.match(/\.(yml|yaml)$/)) {
                output = process_yaml(full_path, relative_path);
            } else if (relative_path.endsWith('.ini')) {
                output = process_ini(full_path, relative_path);
            }
            
            // Add to index with the relative path as key (without extension)
            const key = relative_path.replace(/\.(md|yml|yaml|ini)$/, '');
            index[key] = output;
        });
        
        // Write the master index file
        const index_path = path.join(OUTPUT_DIR, 'index.json');
        ensure_dir_exists(OUTPUT_DIR);
        fs.writeFileSync(index_path, JSON.stringify(index, null, 2));
        
        // Process hooks for additional content generation
        processHooks(index, OUTPUT_DIR);
        
        console.log("Content processing complete");
        
    } catch (error) {
        die(`Something went wrong (shocking, I know): ${error.message}`);
    }
}

/*
 * Convert markdown to JSON. We use gray-matter to extract
 * frontmatter (YAML metadata at the top of the file) and marked
 * to convert the markdown content to HTML.
 */
function process_markdown(filepath, relative_path) {
    const content = fs.readFileSync(filepath, 'utf8');
    const { content: markdown_content, data: frontmatter } = matter(content);
    const html = marked.parse(markdown_content);
    
    const output = {
        ...(Object.keys(frontmatter).length ? { meta: frontmatter } : {}),
        html,
    };
    
    const output_path = path.join(OUTPUT_DIR, relative_path.replace(/\.md$/, '.json'));
    ensure_dir_exists(path.dirname(output_path));
    fs.writeFileSync(output_path, JSON.stringify(output, null, 2));
    
    return output; // Return for index
}

/*
 * YAML to JSON conversion. At least YAML is readable, unlike some
 * other configuration formats I could mention (looking at you, XML).
 */
function process_yaml(filepath, relative_path) {
    const content = fs.readFileSync(filepath, 'utf8');
    const data = yaml.load(content);
    
    const output_path = path.join(OUTPUT_DIR, relative_path.replace(/\.(yml|yaml)$/, '.json'));
    ensure_dir_exists(path.dirname(output_path));
    fs.writeFileSync(output_path, JSON.stringify(data, null, 2));
    
    return data; // Return for index
}

/*
 * INI files. Because why not? At least it's simple.
 */
function process_ini(filepath, relative_path) {
    const content = fs.readFileSync(filepath, 'utf8');
    const data = ini.parse(content);
    
    const output_path = path.join(OUTPUT_DIR, relative_path.replace(/\.ini$/, '.json'));
    ensure_dir_exists(path.dirname(output_path));
    fs.writeFileSync(output_path, JSON.stringify(data, null, 2));
    
    return data; // Return for index
}

// Actually do the work
process_content();