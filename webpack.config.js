const Encore = require('@symfony/webpack-encore');

Encore
    // dossier où seront stockés les assets compilés
    .setOutputPath('public/build/')

    // chemin public utilisé par le serveur web pour accéder au dossier précédent
    .setPublicPath('/build')

    // Purger le contenu du dossier outputPath à chaque build
    .cleanupOutputBeforeBuild()

    // Afficher les notifications OS
    .enableBuildNotifications()


    // Activer le mappage de source
    .enableSourceMaps(!Encore.isProduction())

    // Activer la versioning des fichiers en production
    .enableVersioning(Encore.isProduction())

    // Activer Sass/SCSS
    .enableSassLoader()

    // Configuration des entrées de l'application
    .addEntry('RouletteGame', './assets/js/indexRoulette.js')


    // Activer Vue.js
     .enableVueLoader()

    // Activer React
     .enableReactPreset()

    // Activer TypeScript
     .enableTypeScriptLoader()

    // Activer Babel
    .configureBabel((babelConfig) => {
    })

    Encore.enableSingleRuntimeChunk();


// Activer le support pour les fichiers .vue
// .enableVueLoader(() => {}, { runtimeCompilerBuild: false })


module.exports = Encore.getWebpackConfig();
