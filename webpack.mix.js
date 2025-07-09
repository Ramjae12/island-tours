// Import path for alias configuration
const path = require('path');
const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix
    // Process JavaScript
    .js('resources/js/app.js', 'public/js')
    
    // Process CSS (including Tailwind)
    .postCss('resources/css/app.css', 'public/css', [
        require('tailwindcss'),
        require('autoprefixer'),
    ])
    
    // Enable source maps in development
    .sourceMaps()
    
    // Enable versioning for production
    .version()
    
    // Configure options
    .options({
        // Process URLs in CSS files
        processCssUrls: true,
        
        // Enable hot reloading for development
        hmrOptions: {
            host: 'localhost',
            port: 8080
        }
    })
    
    // Configure Webpack
    .webpackConfig({
        resolve: {
            alias: {
                '@': path.resolve('resources/js'),
            },
        },
    });
