'use strict';

/* Set htmlDevelopment to TRUE if work with html, else - FALSE */
const htmlDevelopment = true;

/* Set environmentProd to TRUE if build for Production, or FALSE if this is development build*/
const isProd = process.env.NODE_ENV === 'production';
const isTest = process.env.NODE_ENV === 'test';
const isDev = !isProd && !isTest;

/* Import Base dependencies */

const config = require( 'config' );
const gulp = require( 'gulp' );
const lazypipe = require( 'lazypipe' );
const replace = require( 'gulp-replace' );
const extReplace = require( 'gulp-ext-replace' );

/* Gulp Plugins */
const plugin = require( 'gulp-load-plugins' )( {
  pattern: [ 'gulp-*', 'gulp.*' ],
  replaceString: /\bgulp[\-.]/
} );

/* Import and config BrowserSync */
const browserSync = require( 'browser-sync' ).create();

// let browserSyncArgs;
const browserSyncArgs = {
  port: 9090,
  ui: false,
  logLevel: 'info',
  logConnections: true,
  logFileChanges: true
};

if ( htmlDevelopment ) {
  browserSyncArgs.server = {
    baseDir: config.path.base.dest
  };
  browserSyncArgs.logPrefix = 'BS-HTML:';
} else {
  browserSyncArgs.proxy = config.domain;
  browserSyncArgs.host = config.domain;
  browserSyncArgs.logPrefix = 'BS-WP:';
}

/* Stylesheet Dependencies */
const sass = require( 'gulp-sass' )( require( 'sass' ) );
const autoprefixer = require( 'autoprefixer' );

/* Images Dependencies */
// do not update gulp-imagemin
// gulp-imagemin should be "7.1.0"
const imagemin = require( 'gulp-imagemin' );

/* JS Dependencies */

/* Other Dependencies */

/* Pre-Config Path */
if ( !htmlDevelopment ) {
  config.path.base.wp = `./wp-content/themes/${config.theme}/`;

  // config.path.base.wp = './html/'; /* only for php files located in html */
  ChangeBasePath( config );
  config.path.base.dest = config.path.base.wp;
}

/* Start Build */
if ( isProd ) {
  console.log( '\x1b[32m', process.env.NODE_ENV );
  console.log( '\x1b[32m', '-------------  PRODUCTION -------------' );
  console.log( '\x1b[36m', '--------- Sourcemaps DISABLED ---------' );
} else if ( isDev ) {
  console.log( '\x1b[31m', process.env.NODE_ENV );
  console.log( '\x1b[31m', '------------- DEVELOPMENT -------------' );
  console.log( '\x1b[31m', '--------- Sourcemaps ENABLED ---------' );
}

/* Compile and automatically prefix stylesheets */
gulp.task( 'styles', () => {
  // For best performance, don't add Sass partials to `gulp.src`
  const srcPath = config.path.styles.srcfiles,
    destPath = config.path.styles.dest;

  return gulp.src( srcPath, { base: config.path.styles.src } )
    .pipe( customErrorPlumber( 'Error Running Sass' ) )
    // .pipe(plugin.newer(destPath))
    .pipe( plugin.changed( destPath, { extension: '.css' } ) )
    .pipe( plugin.if( isDev, plugin.sourcemaps.init() ) )
    // .pipe(plugin.sourcemaps.init())
    // TODO: add minifycss if PROD
    .pipe( sass( {
      // https://github.com/sass/node-sass#options
      outputStyle: 'expanded',
      precision: 5,
      onError: console.error.bind( console, 'Sass error:' )
    } ) )
    // .pipe(plugin.postcss(processors))
    .pipe( plugin.postcss( [ autoprefixer() ] ) )
    .pipe( plugin.cleanCss( {
      // https://github.com/clean-css/clean-css#how-to-use-clean-css-api
      compatibility: '*', // (default) - Internet Explorer 10+ compatibility mode
      level: 1 // Optimization levels. The level option can be either 0, 1 (default), or 2, e.g.
    } ) )
    .pipe( plugin.if( isDev, plugin.sourcemaps.write( 'maps', {
      includeContent: true
    } ) ) )
    // .pipe(plugin.sourcemaps.write('maps', {includeContent: true}))
    .pipe( gulp.dest( destPath ) )
    .pipe( plugin.filter( '**/*.css' ) )
    .pipe( plugin.size( {
      showFiles: true,
      title: 'task: SCSS && PostCSS'
    } ) )
    .pipe( browserSync.reload( { stream: true } ) );
} );

/* Optimize images */
// https://github.com/sindresorhus/gulp-imagemin
gulp.task( 'image:default', () => gulp
  .src( config.path.images.srcimg )
  .pipe( plugin.changed( config.path.images.dest ) )
  .pipe( plugin.bytediff.start() )
  .pipe( imagemin( {
    interlaced: true,
    progressive: true,
    optimizationLevel: 5
  },
  [
    imagemin.gifsicle( { interlaced: true } ),
    imagemin.mozjpeg( { quality: 75, progressive: true } ),
    imagemin.optipng( { optimizationLevel: 5 } ),
    imagemin.svgo( {
      plugins: [
        { removeViewBox: true },
        { cleanupIDs: false }
      ]
    } )
  ] ) )
  .pipe( plugin.bytediff.stop( function( data ) {
    const difference = ( data.savings > 0 ) ? ' smaller.' : ' larger.';

    return data.fileName + ' is ' + data.percent + '%' + difference;
  } ) )
  .pipe( plugin.size( {
    showFiles: true,
    title: 'task:image: '
  } ) )
  .pipe( gulp.dest( config.path.images.dest ) )
  .pipe( browserSync.reload( { stream: true } ) )
);

const spriteSvgConfig = {
  'dest': '.',
  // 'log': 'verbose',
  'mode': {
    'css': {
      'dest': 'assets',
      'sprite': '../img/sprite.svg',
      'render': {
        'scss': {
          'dest': '../scss/sprite.scss'
        }
      }
    }
  }
};

/* Make sprite from images */
gulp.task( 'image:spriteSVG', () => gulp
  .src( `${config.path.images.src}sprites/**/*.svg` )
  .pipe( customErrorPlumber( 'Error Running spriteSVG' ) )
  .pipe( plugin.svgmin() )
  .pipe( plugin.svgSprite( spriteSvgConfig ) )
  .pipe( gulp.dest( config.path.base.src ) )
  .pipe( plugin.size( {
    showFiles: true,
    title: 'task: image_sprite: '
  } ) )
  .pipe( browserSync.reload( { stream: true } ) )
);

/* Convert images to webp */
gulp.task( 'image:image2webp', () => {
  return gulp.src( `${config.path.images.dest}/**/*.+(png|jpg|jpeg)` )
    .pipe( customErrorPlumber( 'Error Running Webp' ) )
    .pipe( plugin.changed( config.path.images.dest, {
      extension: '.webp'
    } ) )
    .pipe( plugin.webp() )
    .pipe( gulp.dest( config.path.images.dest ) );
} );

/* Copy fonts from assets folder to destination */
gulp.task( 'fonts', () => gulp.src( config.path.fonts.src )
  .pipe( customErrorPlumber( 'Error Running Fonts' ) )
  .pipe( plugin.newer( config.path.fonts.dest ) )
  .pipe( gulp.dest( config.path.fonts.dest ) )
  .pipe( plugin.size( {
    showFiles: true,
    title: 'task:fonts'
  } ) )
  .pipe( browserSync.reload( { stream: true } ) ) );

const jsConcat = lazypipe()
  .pipe( plugin.concat, 'scripts.js', { newLine: '\n;' } );

/* Optimize JS scripts */

// const lintBase = (files, options) => {
//   return src(files)
//     .pipe($.eslint(options))
//     .pipe(server.reload({stream: true, once: true}))
//     .pipe($.eslint.format())
//     .pipe($.if(!server.active, $.eslint.failAfterError()));
// }
// function lint() {
//   return lintBase('app/scripts/**/*.js', { fix: true })
//     .pipe(dest('app/scripts'));
// };
// function lintTest() {
//   return lintBase('test/spec/**/*.js');
// };

gulp.task( 'scripts', () => gulp.src( config.path.scripts.src )
  .pipe( customErrorPlumber( 'Error Running Scripts' ) )
  .pipe( plugin.newer( config.path.scripts.dest ) )
  .pipe( customErrorPlumber( 'Error Compiling Scripts' ) )
  .pipe( plugin.if( isDev, plugin.sourcemaps.init() ) )
  .pipe( plugin.babel( {
    presets: [ 'env' ]
  } ) )
  .pipe( plugin.if( [ 'scripts.js' /*,'scripts2.js'*/], jsConcat() ) )
  .pipe( plugin.if( '*.js', plugin.uglify() ) )
  .pipe( plugin.if( isDev, plugin.sourcemaps.write(
    'maps',
    { includeContent: true }
  ) ) )
  .pipe( gulp.dest( config.path.scripts.dest ) )
  .pipe( plugin.filter( '**/*.js' ) )
  .pipe( plugin.size( {
    showFiles: true,
    title: 'task:scripts:'
  } ) )
  .pipe( browserSync.reload( { stream: true } ) ) );

/* Base Gulp tasks */
gulp.task( 'task:images',
  gulp.series( 'image:default', 'image:spriteSVG', 'image:image2webp' )
);

gulp.task( 'task:images-styles',
  gulp.series( 'task:images', 'styles' )
);

gulp.task( 'parallel-scripts-images-styles',
  gulp.parallel( 'task:images-styles', 'scripts', 'fonts' )
);

gulp.task( 'default', gulp.parallel(
  'task:images-styles',
  'scripts',
  'fonts'
) );

gulp.task( 'build', gulp.parallel(
  'task:images-styles',
  'scripts',
  'fonts'
) );


/* Gulp watcher */
gulp.task( 'watch', () => {
  browserSync.init( browserSyncArgs );

  gulp.watch( config.path.base.desthtml ).on( 'change', browserSync.reload );

  gulp.watch( config.path.styles.srcfiles, gulp.series( 'styles' ) );

  gulp.watch( config.path.images.srcimg, gulp.series( 'task:images' ) );

  gulp.watch( config.path.fonts.src, gulp.series( 'fonts' ) );

  gulp.watch( config.path.scripts.src, gulp.series( 'scripts' ) );
} );

/* Consolidated development phase task */
gulp.task( 'serve', gulp.series( 'parallel-scripts-images-styles', 'watch' ) );

/* Custom helper functions */
/* Plumber function for catching errors */
// https://github.com/mikaelbr/gulp-notify
function customErrorPlumber ( errTitle ) {
  return plugin.plumber( {
    errorHandler: plugin.notify.onError( {

      // Customizing error title
      title: errTitle || 'Error running Gulp',
      message: 'Error: <%= error.message %>',
      templateOptions: {
        date: new Date()
      },
      sound: 'Bottle'
    } )
  } );
}
module.exports = customErrorPlumber;

function ChangeBasePath ( config ) {
  config.path.images.dest = config.path.images.dest.replace(
    config.path.base.dest, config.path.base.wp
  );
  config.path.fonts.dest = config.path.fonts.dest.replace(
    config.path.base.dest, config.path.base.wp
  );
  config.path.styles.dest = config.path.styles.dest.replace(
    config.path.base.dest, config.path.base.wp
  );
  config.path.scripts.dest = config.path.scripts.dest.replace(
    config.path.base.dest, config.path.base.wp
  );
  config.path.base.desthtml = config.path.base.desthtml.replace(
    config.path.base.dest, config.path.base.wp
  );
}

// https://www.npmjs.com/package/gulp-sourcemaps
// https://www.npmjs.com/package/gulp-changed
// https://www.npmjs.com/package/gulp-newer
// https://www.npmjs.com/package/cross-env
// https://www.npmjs.com/package/yargs
// https://github.com/postcss/autoprefixer

// TODO:
// https://www.npmjs.com/search?q=keywords:postcss
// https://www.npmjs.com/package/dotenv
// https://www.npmjs.com/search?q=config
// https://www.npmjs.com/package/configstore
// https://www.npmjs.com/package/cosmiconfig
// https://www.npmjs.com/package/uglify-js
// https://www.npmjs.com/package/terser
// https://www.npmjs.com/package/svgo
// https://www.npmjs.com/package/cssnano
// https://www.npmjs.com/package/csso
// https://github.com/ben-eb/gulp-csso
// https://www.npmjs.com/package/stylelint-scss
// https://www.npmjs.com/package/gulp-reporter
// https://github.com/adametry/gulp-eslint
// https://www.npmjs.com/package/chalk
// https://www.npmjs.com/search?q=gulp%20webfont

// .pipe(plugins.notify("Hello Gulp!"))
// .pipe(plugins.notify("Found file: <%= file.relative %>!"))
