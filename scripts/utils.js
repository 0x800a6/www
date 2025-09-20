export const RED = '\x1b[31m';
export const RESET = '\x1b[0m';

export function die(msg) {
    console.error(`${RED}ERROR: ${msg}${RESET}`);
    process.exit(1);
}

export function warn(msg) {
    console.warn(`${RED}WARNING: ${msg}${RESET}`);
}
