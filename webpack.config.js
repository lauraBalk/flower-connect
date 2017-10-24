// webpack.config.js
var Encore = require('@symfony/webpack-encore');

Encore
    // directory where all compiled assets will be stored
    .setOutputPath('web/build/')

    // what's the public path to this directory (relative to your project's document root dir)
    .setPublicPath('/build')

    // empty the outputPath dir before each build
    .cleanupOutputBeforeBuild()

    // will output as web/build/app.js
    // .addEntry('app', './assets/js/main.js')
     .addEntry('app', [
    './assets/js/jquery.min.js',
    './assets/js/jquery.easing.1.3.js',
    './assets/js/bootstrap.min.js',
    './assets/js/jquery.waypoints.min.js',
    './assets/js/jquery.flexslider-min.js',
    './assets/js/jquery.magnific-popup.min.js',
    './assets/js/magnific-popup-options.js',
    './assets/js/jquery.style.switcher.js',
    './assets/js/main-switcher.js',
    './assets/js/main.js',
    './assets/js/jquery.cookie.js',
    './assets/js/bootstrap-datepicker.js',
    './assets/js/main-layout.js'
    ])

     .addStyleEntry('global', [
    './assets/css/animate.css',
    './assets/css/flexslider.css',
    './assets/css/icomoon.css',
    './assets/css/magnific-popup.css',
    './assets/css/bootstrap.css',
    './assets/css/simple-line-icons.css',
    './assets/css/datepicker.css',

    ])

     .addStyleEntry('style-switch', './assets/css/style.css')

     .addStyleEntry('switcher', './assets/css/switcher.css')

    // will output as web/build/global.css
    //.addStyleEntry('global', './assets/css/global.scss')

     // allow vue loader
    .enableVueLoader()

    // allow sass/scss files to be processed
    .enableSassLoader()

    // allow legacy applications to use $/jQuery as a global variable
    .autoProvidejQuery()

    .autoProvideVariables({
        $: 'jquery',
        jQuery: 'jquery',
        'window.jQuery': 'jquery',
    })

    .enableSourceMaps(!Encore.isProduction())

    // create hashed filenames (e.g. app.abc123.css)
    // .enableVersioning()
;

// export the final configuration
module.exports = Encore.getWebpackConfig();