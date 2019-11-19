// plugin configuration
const path = require('path');

const webpack = require('webpack');
const webpackProvide = new webpack.ProvidePlugin({
    $: "jquery",
    jQuery: "jquery",
    Popper: "popper.js",
    //'window.jQuery': "jquery",
});

const CleanWebpackPlugin = require('clean-webpack-plugin');
const cleanWebpack = new CleanWebpackPlugin(['dist']);

const autoprefixer = require('autoprefixer');

// module build
const appModule = basicModuleConfiguration("main", "./src/scripts/main.js");
appModule.module.rules.push(
    {
        test: /\.scss$/,
        use: [
            "style-loader",
            "css-loader",
            "sass-loader"
        ]
    },
    {
        test: /\.(ttf|otf|eot|svg|woff(2)?)(\?[a-z0-9]+)?$/,
        use: [
            {
                loader: 'file-loader',
                options: {
                    name: "/fonts/[name].[ext]",
                    publicPath: "/wp-content/themes/chouquette/dist"
                }
            }
        ]
    });
appModule.plugins.unshift(cleanWebpack);

const indexModule = basicModuleConfiguration("index", "./src/scripts/index.js");
const fichesMapModule = basicModuleConfiguration("fichesMap", "./src/scripts/fiches-map.js");
const categoryServicesModule = basicModuleConfiguration("categoryServices", "./src/scripts/category-services.js");
const searchModule = basicModuleConfiguration("search", "./src/scripts/search.js");
const singleFicheModule = basicModuleConfiguration("singleFiche", "./src/scripts/single-fiche.js");
const singlePostModule = basicModuleConfiguration("singlePost", "./src/scripts/single-post.js");

module.exports = [appModule, indexModule, fichesMapModule, categoryServicesModule, searchModule, singleFicheModule, singlePostModule];

/**
 * Build module configuration for webpack
 *
 * @param moduleEntryName the entry name
 * @param moduleEntryPath the entry path
 * @returns json object representing the module configuration for webpack
 */
function basicModuleConfiguration(moduleEntryName, moduleEntryPath) {
    return {
        entry: {
            [moduleEntryName]: moduleEntryPath
        },
        mode: "development",
        output: {
            filename: "[name].js",
            path: path.resolve(__dirname, 'dist'),
            libraryTarget: 'var',
            library: "[name]"
        },
        devtool: 'source-map',
        module: {
            rules: [
                {
                    test: /\.js$/,
                    include: [
                        path.resolve(__dirname, 'src'),
                        path.resolve(__dirname, 'node_modules/@google/markerclusterer'),
                        path.resolve(__dirname, 'node_modules/load-google-maps-api')
                    ],
                    use: {
                        loader: 'babel-loader'
                    }
                },
                {
                    test: /\.(js|jsx)$/,
                    enforce: "pre",
                    exclude: /node_modules/,
                    use: "eslint-loader"
                }
            ]
        },
        plugins: [
            webpackProvide,
            autoprefixer
        ],
        resolve: {
            alias: {
                vue: 'vue/dist/vue.esm.js',
                swiperjs: 'swiper/js/swiper.min.js' // using src will fail on IE11
            }
        }
    }
}