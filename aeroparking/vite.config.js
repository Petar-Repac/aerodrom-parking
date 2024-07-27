import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { resolve } from 'path';
import { globSync } from 'glob';
import commonjs from '@rollup/plugin-commonjs';
import nodeResolve from '@rollup/plugin-node-resolve';
import legacy from '@vitejs/plugin-legacy';
import { version } from './package.json';

// Get all asset files from the public directory
const assetFiles = globSync('public/**/*.{js,css}').map(file => resolve(__dirname, file));

export default defineConfig({
    plugins: [
        laravel({
            input: assetFiles,  // Only include public assets
            refresh: true,
        }),
        nodeResolve({
            browser: true,
            preferBuiltins: false,
            extensions: ['.js', '.jsx', '.ts', '.tsx'],
        }),
        legacy({
            targets: ['defaults', 'not IE 11']
        }),
        commonjs({
            include: /node_modules/,
        }),
    ],
    build: {
        rollupOptions: {
            input: assetFiles,  // Use assetFiles directly
            external: [
                // '@popperjs/core',
                '_',
                // 'jquery',
                // 'desandro-matches-selector',
                // 'ev-emitter',
                // 'get-size',
                // 'fizzy-ui-utils',
                // 'outlayer',
                // 'masonry-layout',
                // 'isotope-layout',
            ],
            output: {
                entryFileNames: `[name].${version}.js`,
                chunkFileNames: `[name].${version}.js`,
                assetFileNames: `[name].${version}.[ext]`,
            },
        },
    },
    resolve: {
        alias: {
            '@': resolve(__dirname, 'resources/js'),
        },
    },
});
