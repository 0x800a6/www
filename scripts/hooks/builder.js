/*
 * Hook system for content processing
 */

import fs from 'fs';
import path from 'path';
import { die } from '../utils.js';

const hooks = new Map();

/*
 * Register a hook for a specific path pattern
 * 
 * @param {string} pattern - Glob-like pattern to match paths
 * @param {Function} handler - Function to call with collected items
 */
export function registerHook(pattern, handler) {
    if (!hooks.has(pattern)) {
        hooks.set(pattern, []);
    }
    hooks.get(pattern).push(handler);
}

/*
 * Process all registered hooks with the collected content
 * 
 * @param {Object} index - The complete content index
 * @param {string} outputDir - Where to write additional files
 */
export function processHooks(index, outputDir) {
    for (const [pattern, handlers] of hooks) {
        // Filter index entries that match the pattern
        const matchedEntries = Object.entries(index).filter(([key]) => {
            return matchPattern(key, pattern);
        });
        
        if (matchedEntries.length === 0) {
            continue; // No matches, skip this hook
        }
        
        // Convert back to object format
        const matchedContent = Object.fromEntries(matchedEntries);
        
        // Run all handlers for this pattern
        handlers.forEach(handler => {
            try {
                handler(matchedContent, outputDir);
            } catch (error) {
                die(`Hook failed for pattern "${pattern}": ${error.message}`);
            }
        });
    }
}

/*
 * Simple pattern matching. Supports * wildcards.
 * Yes, this is naive. No, I don't care. It works.
 */
function matchPattern(path, pattern) {
    // Convert glob-like pattern to regex
    const regexPattern = pattern
        .replace(/\*/g, '.*')
        .replace(/\?/g, '.')
        .replace(/\//g, '\\/');
    
    const regex = new RegExp(`^${regexPattern}`);
    return regex.test(path);
}

/*
 * Helper function to ensure directory exists
 */
function ensureDir(dir) {
    if (!fs.existsSync(dir)) {
        fs.mkdirSync(dir, { recursive: true });
    }
}

// Export the helper for hooks to use
export { ensureDir };