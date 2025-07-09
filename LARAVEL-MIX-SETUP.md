# 🎯 Laravel Mix Setup Guide

## Installation
```bash
npm uninstall vite laravel-vite-plugin
npm install laravel-mix --save-dev
```

## Create webpack.mix.js
```javascript
const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')
   .postCss('resources/css/app.css', 'public/css', [
       require('tailwindcss'),
       require('autoprefixer'),
   ])
   .options({
       processCssUrls: false
   });

// For production
if (mix.inProduction()) {
    mix.version();
}
```

## Update package.json scripts
```json
{
    "scripts": {
        "dev": "npm run development",
        "development": "mix",
        "watch": "mix watch",
        "watch-poll": "mix watch -- --watch-options-poll=1000",
        "hot": "mix watch --hot",
        "prod": "npm run production",
        "production": "mix --production"
    }
}
```

## Benefits:
- ✅ Mature and stable
- ✅ Excellent Laravel integration
- ✅ Large community support
- ✅ Extensive plugin ecosystem
- ✅ Hot module replacement
- ✅ Built-in PostCSS support
