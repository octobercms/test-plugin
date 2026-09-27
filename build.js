/**
 * October Test Vendor Build Script
 *
 * - Bundles the TipTap editor from vendor_drm/tiptap (DRM protected, only built if present)
 * - Pass --watch to rebuild unminified with inline sourcemaps on every change
 */
import * as esbuild from 'esbuild';
import fs from 'fs';
import path from 'path';
import { fileURLToPath } from 'url';

const __dirname = path.dirname(fileURLToPath(import.meta.url));
const rootDir = path.resolve(__dirname, '../../..');
const vendorDir = path.join(__dirname, 'assets/vendor');
const isWatch = process.argv.includes('--watch');

console.log('\n  Building vendor files...\n');

// TipTap Editor (DRM protected - only build if present)
const tiptapDir = path.join(rootDir, 'vendor_drm/tiptap');
if (fs.existsSync(path.join(tiptapDir, 'src/index.js'))) {
    if (!fs.existsSync(path.join(tiptapDir, 'node_modules'))) {
        console.error('  ✗ vendor_drm/tiptap/node_modules is missing, run npm install in vendor_drm/tiptap\n');
        process.exit(1);
    }

    const options = {
        entryPoints: [path.join(tiptapDir, 'src/index.js')],
        bundle: true,
        format: 'iife',
        outfile: path.join(vendorDir, 'tiptap/tiptap.js'),
        minify: !isWatch,
        sourcemap: isWatch ? 'inline' : false,
        globalName: 'TiptapEditor',
        logLevel: isWatch ? 'info' : 'warning'
    };

    if (isWatch) {
        const context = await esbuild.context(options);
        await context.watch();
        console.log('  Watching vendor_drm/tiptap for changes...\n');
    }
    else {
        await esbuild.build(options);
        console.log('  ✓ tiptap/tiptap.js and tiptap.css (bundled)');
    }
}
else {
    console.log('  - vendor_drm/tiptap not found, skipped');
}

if (!isWatch) {
    console.log('\n  Done.\n');
}
