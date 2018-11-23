var ExtractTextPlugin = require('extract-text-webpack-plugin');

module.exports = {
    entry: ['./scss/style.scss'],
    output: {
        filename: 'dist/bundle.js'
    },
    module: {
        rules: [
            /*
            your other rules for JavaScript transpiling go in here
            */
            { // css / sass / scss loader for webpack
                test: /\.(css|sass|scss)$/,
                use: ExtractTextPlugin.extract({
                    use: ['css-loader', 'sass-loader'],
                })
            }
        ]
    },
    plugins: [
        new ExtractTextPlugin({ // define where to save the file
            filename: 'css/style.css',
            allChunks: true,
        }),
    ],
};