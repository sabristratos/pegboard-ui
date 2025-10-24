import { defineConfig } from 'vite';
import path from 'node:path';
import { fileURLToPath } from 'node:url';

const __dirname = path.dirname(fileURLToPath(import.meta.url));

export default defineConfig({
    build: {
        lib: {
            entry: path.resolve(__dirname, 'resources/js/index.ts'),
            fileName: 'pegboard',
            formats: ['es']
        },
        rollupOptions: {
            external: ['alpinejs'],
            output: {
                globals: {
                    alpinejs: 'Alpine'
                },
                assetFileNames: (assetInfo) => {
                    if (assetInfo.names?.[0] === 'style.css') {
                        return 'pegboard.css';
                    }
                    return assetInfo.names?.[0] || '';
                }
            }
        },
        outDir: 'dist',
        emptyOutDir: true,
        sourcemap: true,
        minify: false
    },
    resolve: {
        alias: {
            '@': path.resolve(__dirname, 'resources/js')
        }
    }
});
