const Encore = require('@symfony/webpack-encore');

Encore
    // directory where compiled assets will be stored
    .setOutputPath('public/build/')

    .copyFiles({
        from: './assets/images',
        // optional target path, relative to the output dir
        // to: 'images/[path][name].[ext]',
        // if versioning is enabled, add the file hash too
        // to: 'images/[path][name].[hash:8].[ext]',
        // only copy files matching this pattern
        // pattern: /\.(png|jpg|jpeg)$/
    })

    // public path used by the web server to access the output path
    .setPublicPath('/build')
    // only needed for CDN's or sub-directory deploy
    // .setManifestKeyPrefix('build/')

    /*
     * ENTRY CONFIG
     *
     * Add 1 entry for each "page" of your app
     * (including one that's included on every page - e.g. "app")
     *
     * Each entry will result in one JavaScript file (e.g. app.js)
     * and one CSS file (e.g. app.css) if you JavaScript imports CSS.
     */
    .addEntry('app', './assets/js/app.js')
    .addEntry('board', './assets/js/board.js')
    .addEntry('advisor', './assets/scss/advisor.scss')
    .addEntry('advisorForm', './assets/js/advisorForm.js')
    .addEntry('advisors', './assets/js/advisors.js')
    .addEntry('clientBoard', './assets/js/clientBoard.js')
    .addEntry('cvAdvisor', './assets/js/cvAdvisor.js')
    .addEntry('login', './assets/scss/login.scss')
    .addEntry('register', './assets/scss/register.scss')
    .addEntry('statut', './assets/scss/statut.scss')
    .addEntry('footer', './assets/scss/footer.scss')
    .addEntry('linkedin', './assets/scss/linkedin.scss')


// .addEntry('page2', './assets/js/page2.js')

// .addEntry('page2', './assets/js/page2.js')


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

    // enables @babel/preset-env polyfills
    .configureBabel(() => {}, {
        useBuiltIns: 'usage',
        corejs: 3,
    })

    // enables Sass/SCSS support
    .enableSassLoader()

// uncomment if you use TypeScript
// .enableTypeScriptLoader()


// uncomment to get integrity="..." attributes on your script & link tags
// requires WebpackEncoreBundle 1.4 or higher
// .enableIntegrityHashes()

// uncomment if you're having problems with a jQuery plugin
// .autoProvidejQuery()

// uncomment if you use API Platform Admin (composer req api-admin)
// .enableReactPreset()
// .addEntry('admin', './assets/js/admin.js')
// eslint-disable-next-line semi-style
;

module.exports = Encore.getWebpackConfig();
