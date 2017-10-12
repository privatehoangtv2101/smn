let mix = require('laravel-mix');
var webpack = require("webpack");
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
mix.webpackConfig( {
    entry: {
        vendor: [
            "jquery",
            "lodash",
            "axios",
            "react",
            "react-dom",
            "react-router-dom",
            "redux",
            "react-redux",
            "redux-saga"
        ]
    },
    output: {
        filename: "dist/js/[name].js",
        chunkFilename : 'dist/js/[hash].[id].js'
    },
    module: {
        loaders: [
            {
                test: /\.js$/,
                exclude: /node_modules/,
                loader: 'babel-loader',
                query: {
                    presets: ['react', 'es2015']
                }
            }
        ]
    },
    plugins: [
        new webpack.optimize.CommonsChunkPlugin({
            name: 'vendor',
            minChunks: Infinity
        }),
        new webpack.optimize.CommonsChunkPlugin({
            name: "manifest",
            minChunks: Infinity
        })
    ]
});
mix.react('resources/assets/js/app.js', '')
   .sass('resources/assets/sass/app.scss', 'public/dist/css')
   .version();
