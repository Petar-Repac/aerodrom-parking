import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { resolve } from 'path';
import { globSync } from 'glob';
import commonjs from '@rollup/plugin-commonjs';
import nodeResolve from '@rollup/plugin-node-resolve';
import babel from '@rollup/plugin-babel';
import legacy from '@vitejs/plugin-legacy';
import { version } from './package.json';

// Get all asset files from the public directory
const assetFiles = globSync('public/**/*.{js,css,woff,woff2,eot,ttf,svg,webp,jpg,png}').map(file => resolve(__dirname, file));

export default defineConfig({
    plugins: [
        laravel({
            input: assetFiles,  // Only include public assets
            refresh: true,
        }),
        commonjs({
            include: [/node_modules/, /public\/vendor\/easepick\/js\/main.js/],  // Include the specific file causing issues
            ignore: (id) => id.endsWith('.json')  // Ignore JSON files if any issues occur
        }),
        nodeResolve({
            browser: true,
            preferBuiltins: false,
            extensions: ['.js', '.jsx', '.ts', '.tsx'],
        }),
        babel({
            babelHelpers: 'bundled',
            presets: ['@babel/preset-env'],
            exclude: 'node_modules/**',  // Only transpile our source code
            extensions: ['.js', '.jsx', '.ts', '.tsx'],  // Ensure Babel processes these file types
        }),
        legacy({
            targets: ['defaults', 'not IE 11']
        })
    ],
    build: {
        rollupOptions: {
            input: assetFiles,  // Use assetFiles directly
            external: [
                '@popperjs/core',
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
