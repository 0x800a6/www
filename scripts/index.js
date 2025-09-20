'use strict';

import path from 'path';
import fs from 'fs';
import { fileURLToPath } from 'url';
import { die, warn, RED, RESET } from "./utils.js"

const __filename = fileURLToPath(import.meta.url);
const __dirname = path.dirname(__filename);


const pkgPath = path.resolve(__dirname, 'package.json');
let pkg;
try {
    pkg = JSON.parse(fs.readFileSync(pkgPath, 'utf8'));
} catch (e) {
    die(`Cannot read package.json: ${e.message}`);
}

const scripts = pkg.scripts;
if (!scripts || typeof scripts !== 'object' || !Object.keys(scripts).length) {
    die('No scripts found in package.json.');
}

warn('You are not supposed to run this script directly.');
console.log(`${RED}Available scripts from package.json:${RESET}`);
for (const name of Object.keys(scripts)) {
    console.log(`  - ${name}`);
}
die('Please run one of those instead.');