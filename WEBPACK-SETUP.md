# ⚙️ Direct Webpack Configuration

## Installation
```bash
npm uninstall vite laravel-vite-plugin
npm install webpack webpack-cli webpack-dev-server --save-dev
npm install css-loader style-loader postcss-loader --save-dev
npm install mini-css-extract-plugin html-webpack-plugin --save-dev
```

## Create webpack.config.js
```javascript
const path = require('path');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');

module.exports = {
    entry: {
        app: './resources/js/app.js',
    },
    output: {
        filename: 'js/[name].js',
        path: path.resolve(__dirname, 'public'),
        publicPath: '/',
    },
    module: {
        rules: [
            {
                test: /\.js$/,
                exclude: /node_modules/,
                use: {
                    loader: 'babel-loader',
                    options: {
                        presets: ['@babel/preset-env']
                    }
                }
            },
            {
                test: /\.css$/,
                use: [
                    MiniCssExtractPlugin.loader,
                    'css-loader',
                    {
                        loader: 'postcss-loader',
                        options: {
                            postcssOptions: {
                                plugins: [
                                    require('tailwindcss'),
                                    require('autoprefixer'),
                                ],
                            },
                        },
                    },
                ],
            },
        ],
    },
    plugins: [
        new MiniCssExtractPlugin({
            filename: 'css/[name].css',
        }),
    ],
    devServer: {
        static: './public',
        hot: true,
        port: 3000,
    },
    mode: process.env.NODE_ENV === 'production' ? 'production' : 'development',
};
```

## Package.json scripts
```json
{
    "scripts": {
        "dev": "webpack --mode development",
        "watch": "webpack --mode development --watch",
        "hot": "webpack serve --mode development --hot",
        "prod": "webpack --mode production"
    }
}
```

## Benefits:
- ✅ Full control over configuration
- ✅ Highly customizable
- ✅ Industry standard
- ✅ Extensive plugin ecosystem
