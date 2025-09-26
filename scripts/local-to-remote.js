import fs from 'fs';
import path from 'path';
import { fileURLToPath } from 'url';
import { die } from './utils.js';
import https from 'https';

const __filename = fileURLToPath(import.meta.url);
const __dirname = path.dirname(__filename);

const args = process.argv.slice(2);

if (args.length === 0) {
    die("No arguments provided. Usage: local-to-remote <DOWNLOAD_LIST_FILE>");
}
if (args.length > 1) {
    die("Too many arguments provided. Usage: local-to-remote <DOWNLOAD_LIST_FILE>");
}

const DOWNLOAD_LIST_FILE = path.resolve(__dirname, args[0]);
if (!fs.existsSync(DOWNLOAD_LIST_FILE)) {
    die(`The specified download list file does not exist: ${DOWNLOAD_LIST_FILE}`);
}

/**
 * Downloads the content from the given URL and returns it as a Buffer.
 * @param {string} url
 * @returns {Promise<Buffer>}
 */
function download(url) {
    return new Promise((resolve, reject) => {
        https.get(url, (res) => {
            if (res.statusCode !== 200) {
                reject(new Error(`Failed to fetch ${url}: ${res.statusCode} ${res.statusMessage}`));
                res.resume();
                return;
            }
            const data = [];
            res.on('data', chunk => data.push(chunk));
            res.on('end', () => resolve(Buffer.concat(data)));
        }).on('error', (err) => {
            reject(new Error(`Error downloading ${url}: ${err.message}`));
        });
    });
}

/**
 * Processes the download list file and downloads each entry sequentially.
 */
async function processLocalDownloads() {
    const lines = fs.readFileSync(DOWNLOAD_LIST_FILE, 'utf-8')
        .split('\n')
        .map(line => line.trim())
        .filter(line => line && !line.startsWith('#') && !line.includes('--- IGNORE ---'));

    if (lines.length === 0) {
        console.log(`No valid entries in ${DOWNLOAD_LIST_FILE}, skipping.`);
        return;
    }

    console.log(`Processing ${lines.length} local download entr${lines.length === 1 ? 'y' : 'ies'}...`);
    const errors = [];

    for (let i = 0; i < lines.length; i++) {
        const line = lines[i];
        const [url, localPath] = line.split('->').map(part => part.trim());
        if (!url || !localPath) {
            console.warn(`Invalid line in download list: ${line}`);
            continue;
        }

        const absoluteLocalPath = path.resolve(__dirname, '..', localPath);
        const localDir = path.dirname(absoluteLocalPath);

        // Skip download if file already exists
        if (fs.existsSync(absoluteLocalPath)) {
            console.log(`[${i+1}/${lines.length}] Skipping existing file: ${absoluteLocalPath}`);
            continue;
        }

        // Ensure the directory exists
        fs.mkdirSync(localDir, { recursive: true });

        console.log(`[${i+1}/${lines.length}] Downloading ${url} to ${absoluteLocalPath}...`);
        try {
            const data = await download(url);
            fs.writeFileSync(absoluteLocalPath, data);
            console.log(`Saved ${absoluteLocalPath}`);
        } catch (err) {
            console.error(`Failed to download ${url}: ${err.message}`);
            errors.push({ url, error: err.message });
        }
    }

    if (errors.length > 0) {
        console.log(`\nCompleted with ${errors.length} error(s):`);
        errors.forEach(e => console.log(`- ${e.url}: ${e.error}`));
    } else {
        console.log("All downloads completed successfully.");
    }
}

processLocalDownloads();