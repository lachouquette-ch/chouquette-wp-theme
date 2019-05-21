const path = require('path');

const webpack = require('webpack');
const webpackProvide = new webpack.ProvidePlugin({
    $: "jquery",
    jQuery: "jquery",
    Popper: "popper.js",
    'window.jQuery': "jquery",
});

const CleanWebpackPlugin = require('clean-webpack-plugin');
const cleanWebpack = new CleanWebpackPlugin(['dist']);

const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const miniCssExtract = new MiniCssExtractPlugin({
    filename: "style.css",
    chunkFilename: "[id].css",
});

module.exports = {
    context: path.resolve(__dirname, 'src'),
    entry: {
        app: './app.js'
    },
    output: {
        path: path.resolve(__dirname, 'dist'),
        filename: "[name].js"
    },
    devtool: 'source-map',
    module: {
        rules: [
            {
                test: /\.scss$/,
                use: [
                    MiniCssExtractPlugin.loader,
                    'css-loader',
                    'sass-loader'
                ],
            },
            {
                test: /\.css$/,
                include: /node_modules/,
                loaders: ['style-loader', 'css-loader'],
            },
            {
                test: /\.(ttf|otf|eot|svg|woff(2)?)(\?[a-z0-9]+)?$/,
                loader: 'file-loader?name=fonts/[name].[ext]'
            },
            {
                test: require.resolve('jquery'),
                use: [{
                    loader: 'expose-loader',
                    options: '$'
                }]
            }
        ]
    },
    optimization: {
        splitChunks: {
            cacheGroups: {
                commons: {
                    test: /[\\/]node_modules[\\/]/,
                    name: "vendor",
                    chunks: "all"
                }
            }
        }
    },
    devtool: 'inline-source-map',
    devServer: {
        hot: true,
        open: true,
        watchOptions: {
            poll: true
        }
    },
    plugins: [
        cleanWebpack,
        webpackProvide,
        miniCssExtract,
        new webpack.HotModuleReplacementPlugin()
    ]
};