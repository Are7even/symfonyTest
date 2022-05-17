const Encore = require('@symfony/webpack-encore');

// Manually configure the runtime environment if not already configured yet by the "encore" command.
// It's useful when you use tools that rely on webpack.config.js file.
if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

Encore
    // directory where compiled assets will be stored
    .setOutputPath('public/build/')
    // public path used by the web server to access the output path
    .setPublicPath('/build')
    // only needed for CDN's or sub-directory deploy
    //.setManifestKeyPrefix('build/')

    /*
     * ENTRY CONFIG
     *
     * Each entry will result in one JavaScript file (e.g. app.js)
     * and one CSS file (e.g. app.css) if your JavaScript imports CSS.
     */
    .addEntry('jquery-3.5.1.min', './assets/js/vendor/jquery-3.5.1.min.js')
    .addEntry('modernizr-3.11.2', './assets/js/vendor/modernizr-3.11.2.min.js')
    .addEntry('jquery-migrate-3.3.0', './assets/js/vendor/jquery-migrate-3.3.0.min.js')
    .addEntry('bootstrap', './assets/js/vendor/bootstrap.bundle.min.js')
    .addEntry('jquery-ui-js', './assets/js/vendor/jquery-ui.min.js')
    .addEntry('slick-js', './assets/js/plugins/slick.min.js')
    .addEntry('material-scrolltop', './assets/js/plugins/material-scrolltop.js')
    .addEntry('jquery.nice-select', './assets/js/plugins/jquery.nice-select.min.js')
    .addEntry('jquery.zoom', './assets/js/plugins/jquery.zoom.min.js')
    .addEntry('venobox-js', './assets/js/plugins/venobox.min.js')

    .addEntry('app', './assets/css/style.css')
    .addEntry('font-awesome', './assets/css/vendor/font-awesome.min.css')
    .addEntry('plaza-icon', './assets/css/vendor/plaza-icon.css')
    .addEntry('jquery-ui', './assets/css/vendor/jquery-ui.min.css')
    .addEntry('slick', './assets/css/plugins/slick.css')
    .addEntry('nice-select', './assets/css/plugins/nice-select.css')
    .addEntry('venobox', './assets/css/plugins/venobox.min.css')

    // enables the Symfony UX Stimulus bridge (used in assets/bootstrap.js)
    .enableStimulusBridge('./assets/controllers.json')

    // When enabled, Webpack "splits" your files into smaller pieces for greater optimization.
    .splitEntryChunks()

    // will require an extra script tag for runtime.js
    // but, you probably want this, unless you're building a single-page app
    .enableSingleRuntimeChunk()

    /*
     * FEATURE CONFIG
     *
     * Enable & configure other features below. For a full
     * list of features, see:
     * https://symfony.com/doc/current/frontend.html#adding-more-features
     */
    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableSourceMaps(!Encore.isProduction())
    // enables hashed filenames (e.g. app.abc123.css)
    .enableVersioning(Encore.isProduction())

    .configureBabel((config) => {
        config.plugins.push('@babel/plugin-proposal-class-properties');
    })

    // enables @babel/preset-env polyfills
    .configureBabelPresetEnv((config) => {
        config.useBuiltIns = 'usage';
        config.corejs = 3;
    })

    // enables Sass/SCSS support
    .enableSassLoader()

    // uncomment if you use TypeScript
    .enableTypeScriptLoader()

    // uncomment if you use React
    //.enableReactPreset()

    // uncomment to get integrity="..." attributes on your script & link tags
    // requires WebpackEncoreBundle 1.4 or higher
    .enableIntegrityHashes(Encore.isProduction())

    // uncomment if you're having problems with a jQuery plugin
    .autoProvidejQuery()
;

module.exports = Encore.getWebpackConfig();
