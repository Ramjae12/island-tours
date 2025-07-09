# 🚀 Rollup.js Configuration

## Installation
```bash
npm uninstall vite laravel-vite-plugin
npm install rollup --save-dev
npm install @rollup/plugin-node-resolve @rollup/plugin-commonjs --save-dev
npm install @rollup/plugin-babel rollup-plugin-postcss --save-dev
npm install rollup-plugin-terser rollup-plugin-livereload --save-dev
```

## Create rollup.config.js
```javascript
import resolve from '@rollup/plugin-node-resolve';
import commonjs from '@rollup/plugin-commonjs';
import babel from '@rollup/plugin-babel';
import postcss from 'rollup-plugin-postcss';
import { terser } from 'rollup-plugin-terser';
import livereload from 'rollup-plugin-livereload';

const production = !process.env.ROLLUP_WATCH;

export default {
    input: 'resources/js/app.js',
    output: {
        file: 'public/js/app.js',
        format: 'iife',
        sourcemap: !production,
    },
    plugins: [
        resolve({
            browser: true,
            dedupe: ['svelte']
        }),
        commonjs(),
        babel({
            babelHelpers: 'bundled',
            exclude: 'node_modules/**',
            presets: ['@babel/preset-env']
        }),
        postcss({
            extract: 'css/app.css',
            minimize: production,
            plugins: [
                require('tailwindcss'),
                require('autoprefixer'),
            ]
        }),
        !production && livereload('public'),
        production && terser()
    ],
    watch: {
        clearScreen: false
    }
};
```

## Package.json scripts
```json
{
    "scripts": {
        "dev": "rollup -c -w",
        "build": "rollup -c",
        "prod": "NODE_ENV=production rollup -c"
    }
}
```

## Benefits:
- ✅ Tree-shaking by default
- ✅ Smaller bundle sizes
- ✅ ES6 modules native support
- ✅ Fast build times
- ✅ Simple configuration
