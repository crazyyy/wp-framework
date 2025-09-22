'use strict';

/**
 * Gulp workflow for WordPress theme development
 * Includes SCSS, JS, image optimization, fonts, BrowserSync
 */

// ===== Detect environment =====
const isProd = process.env.NODE_ENV === 'production';
const isTest = process.env.NODE_ENV === 'test';
const isDev = !isProd && !isTest;

// ===== Imports =====
import gulp from 'gulp';
import config from 'config';
import plumber from 'gulp-plumber';
import notify from 'gulp-notify';
import changed from 'gulp-changed'; // Only pass through changed files
import newer from 'gulp-newer';
import concat from 'gulp-concat';
import sourcemaps from 'gulp-sourcemaps';
import size from 'gulp-size';

// CSS/SCSS/PostCSS
import dartSass from 'sass';
import gulpSass from 'gulp-sass';
import postcss from 'gulp-postcss';
import autoprefixer from 'autoprefixer';
import cleanCss from 'gulp-clean-css';

// JavaScript
import babel from 'gulp-babel';
import uglify from 'gulp-uglify';

// Images
import imagemin from 'gulp-imagemin';
import svgmin from 'gulp-svgmin';
import svgSprite from 'gulp-svg-sprite';
import webp from 'gulp-webp';

// BrowserSync
import browserSyncLib from 'browser-sync';

// Initialize
const sass = gulpSass(dartSass);
const browserSync = browserSyncLib.create();

// ===== Paths =====
const paths = {
  styles: config.path.styles,
  scripts: config.path.scripts,
  images: config.path.images,
  fonts: config.path.fonts,
  base: config.path.base,
};

// ===== BrowserSync config =====
const browserSyncArgs = {
  port: 9090,
  ui: false,
  logLevel: 'info',
  logConnections: true,
  logFileChanges: true,
  https: {
    key: config.ssl.key,
    cert: config.ssl.cert,
  },
  server: {
    baseDir: paths.base.dest,
  },
};

// ===== Helper functions =====
/**
 * Custom plumber with notifications
 * @param {string} errTitle - Title for error message
 */
function customErrorPlumber(errTitle) {
  return plumber({
    errorHandler: notify.onError({
      title: errTitle || 'Gulp Error',
      message: 'Error: <%= error.message %>',
      sound: 'Bottle',
    }),
  });
}

// ===== Styles =====
export function styles() {
  return gulp
    .src(paths.styles.srcFiles, { base: paths.styles.src })
    .pipe(customErrorPlumber('Error Running Sass'))
    .pipe(changed(paths.styles.dest, { extension: '.css' }))
    .pipe(isDev ? sourcemaps.init() : gulp.noop())
    .pipe(
      sass({
        outputStyle: 'expanded',
        precision: 5,
      })
    )
    .pipe(postcss([autoprefixer()]))
    .pipe(
      cleanCss({
        compatibility: '*',
        level: 1,
      })
    )
    .pipe(isDev ? sourcemaps.write('maps') : gulp.noop())
    .pipe(gulp.dest(paths.styles.dest))
    .pipe(browserSync.stream());
}

// ===== JavaScript =====
export function scripts() {
  return gulp
    .src(paths.scripts.src)
    .pipe(customErrorPlumber('Error Running Scripts'))
    .pipe(changed(paths.scripts.dest))
    .pipe(isDev ? sourcemaps.init() : gulp.noop())
    .pipe(
      babel({
        presets: ['@babel/preset-env'],
      })
    )
    .pipe(uglify())
    .pipe(isDev ? sourcemaps.write('maps') : gulp.noop())
    .pipe(gulp.dest(paths.scripts.dest))
    .pipe(browserSync.stream());
}

// ===== Images =====
export function imagesOptimize() {
  return gulp
    .src(paths.images.srcImg)
    .pipe(changed(paths.images.dest))
    .pipe(
      imagemin(
        [
          imagemin.gifsicle({ interlaced: true }),
          imagemin.mozjpeg({ quality: 82, progressive: true }),
          imagemin.optipng({ optimizationLevel: 5 }),
          imagemin.svgo({
            plugins: [
              { removeViewBox: false },
              { cleanupIDs: false },
              { removeDimensions: true },
            ],
          }),
        ],
        { verbose: true }
      )
    )
    .pipe(size({ showFiles: true, title: 'Images optimized:' }))
    .pipe(gulp.dest(paths.images.dest))
    .pipe(browserSync.stream());
}

// ===== SVG Sprite =====
export function imagesSprite() {
  return gulp
    .src(`${paths.images.src}sprites/**/*.svg`)
    .pipe(customErrorPlumber('Error in SVG sprite'))
    .pipe(svgmin())
    .pipe(
      svgSprite({
        mode: {
          css: {
            dest: 'assets',
            sprite: '../img/sprite.svg',
            render: {
              scss: { dest: '../scss/sprite.scss' },
            },
          },
        },
      })
    )
    .pipe(gulp.dest(paths.base.src))
    .pipe(browserSync.stream());
}

// ===== WebP Conversion =====
export function imagesWebp() {
  return gulp
    .src(`${paths.images.dest}/**/*.+(png|jpg|jpeg)`)
    .pipe(customErrorPlumber('Error Running WebP'))
    .pipe(changed(paths.images.dest, { extension: '.webp' }))
    .pipe(webp())
    .pipe(gulp.dest(paths.images.dest));
}

// ===== Fonts =====
export function fonts() {
  return gulp
    .src(paths.fonts.src)
    .pipe(customErrorPlumber('Error Copying Fonts'))
    .pipe(newer(paths.fonts.dest))
    .pipe(gulp.dest(paths.fonts.dest))
    .pipe(size({ showFiles: true, title: 'Fonts copied:' }))
    .pipe(browserSync.stream());
}

// ===== Watcher =====
export function watch() {
  browserSync.init(browserSyncArgs);

  gulp.watch(paths.base.destHtml).on('change', browserSync.reload);
  gulp.watch(paths.styles.srcFiles, styles);
  gulp.watch(paths.images.srcImg, imagesOptimize);
  gulp.watch(paths.fonts.src, fonts);
  gulp.watch(paths.scripts.src, scripts);
}

// ===== Combined tasks =====
export const images = gulp.series(imagesOptimize, imagesSprite, imagesWebp);
export const build = gulp.parallel(styles, scripts, images, fonts);
export default gulp.series(build, watch);



// // # Gulp workflow for WordPress theme development
// // https://gist.github.com/tomazzaman/158c10361c19434b02ad

// /* Set isHtmlDev to TRUE if work with html, else - FALSE */
// const isHtmlDev = true;

// /* Set environmentProd to TRUE if build for Production, or FALSE if this is development build*/
// const isProd = process.env.NODE_ENV === 'production';
// const isTest = process.env.NODE_ENV === 'test';
// const isDev = !isProd && !isTest;

// /* Import Base dependencies */
// // ToDo: Cosmiconfig searches for and loads configuration for your program https://github.com/cosmiconfig/cosmiconfig
// const config = require( 'config' );
// const gulp = require( 'gulp' );
// const lazypipe = require( 'lazypipe' );
// const replace = require( 'gulp-replace' );
// const extReplace = require( 'gulp-ext-replace' );
// const isChanged = require( 'gulp-changed' );
// const newer = require( 'gulp-newer' );
// const plumber = require( 'gulp-plumber' );
// const notify = require( 'gulp-notify' );

// const bytediff = require( 'gulp-bytediff' );
// const size = require( 'gulp-size' );

// /* Image Processing Dependencies */
// const imagemin = require( 'gulp-imagemin' ); // do not update gulp-imagemin // gulp-imagemin should be "7.1.0"
// const svgmin = require( 'gulp-svgmin' );
// const svgSprite = require( 'gulp-svg-sprite' );
// const webp = require( 'gulp-webp' );

// const concat = require( 'gulp-concat' );

// /* JS Processing Dependencies */
// const babel = require( 'gulp-babel' );
// const uglify = require( 'gulp-uglify' );

// const sourcemaps = require('gulp-sourcemaps');

// /* Stylesheet Dependencies */
// const autoprefixer = require( 'autoprefixer' );
// const sass = require( 'gulp-sass' )( require( 'sass' ) );
// const cleanCss = require('gulp-clean-css');
// // const sass = require('gulp-sass');
// const postcss = require( 'gulp-postcss' );


// /* Import and config BrowserSync */
// const browserSync = require( 'browser-sync' ).create();

// // let browserSyncArgs;
// const browserSyncArgs = {
//   port: 9090,
//   ui: false,
//   logLevel: 'info',
//   logConnections: true,
//   logFileChanges: true,
//   https: {
//     key: config.ssl.key,
//     cert: config.ssl.cert
//   }
// };

// if ( isHtmlDev ) {
//   browserSyncArgs.server = {
//     baseDir: config.path.base.dest
//   };
//   browserSyncArgs.logPrefix = 'BS-HTML:';
// } else {
//   browserSyncArgs.proxy = `https://${config.domain}`;
//   // browserSyncArgs.host = config.domain;
//   browserSyncArgs.logPrefix = 'BS-WP:';
// }

// /* JS Dependencies */

// /* Other Dependencies */

// /* Pre-Config Path */
// if ( !isHtmlDev ) {
//   config.path.base.wp = `./wp-content/themes/${config.theme}/`;

//   // config.path.base.wp = './html/'; /* only for php files located in html */
//   ChangeBasePath( config );
//   config.path.base.dest = config.path.base.wp;
// }

// /* Start Build */
// if ( isProd ) {
//   console.log( '\x1b[32m', '-------------  PRODUCTION -------------' );
//   console.log( '\x1b[36m', '--------- Sourcemaps DISABLED ---------' );
// } else if ( isDev ) {
//   console.log( '\x1b[31m', '------------- DEVELOPMENT -------------' );
//   console.log( '\x1b[31m', '--------- Sourcemaps ENABLED ---------' );
// }

// gulp.task('styles', () => {
//   const srcPath = config.path.styles.srcFiles;
//   const destPath = config.path.styles.dest;

//   return gulp.src(srcPath, { base: config.path.styles.src })
//     .pipe(customErrorPlumber('Error Running Sass'))
//     .pipe(isChanged(destPath, { extension: '.css' }))
//     .pipe(sourcemaps.init())
//     .pipe(sass({
//       outputStyle: 'expanded',
//       precision: 5,
//       onError: console.error.bind(console, 'Sass error:')
//     }))
//     .pipe(postcss([autoprefixer()]))
//     .pipe(cleanCss({
//       compatibility: '*',
//       level: 1
//     }))
//     .pipe(sourcemaps.write('maps', { includeContent: true }))
//     .pipe(gulp.dest(destPath))
//     .pipe(browserSync.reload({ stream: true }));
// });

// /* Optimize images */
// // https://github.com/sindresorhus/gulp-imagemin
// gulp.task( 'image:default', () => gulp
//   .src( config.path.images.srcImg )
//   .pipe( isChanged( config.path.images.dest ) )
//   .pipe( bytediff.start() )
//   .pipe( imagemin( {
//       interlaced: true,
//       progressive: true,
//       optimizationLevel: 5
//     },
//     [
//       imagemin.gifsicle( { interlaced: true } ),
//       imagemin.mozjpeg( { quality: 82, progressive: true } ),
//       imagemin.optipng( { optimizationLevel: 5 } ),
//       imagemin.svgo( {
//         plugins: [
//           { removeUnknownsAndDefaults: false },
//           { removeViewBox: true },
//           { cleanupIDs: false },
//           { removeDimensions: true }
//         ]
//       } )
//     ] ) )
//   .pipe( bytediff.stop( ( data ) => {
//     const difference = data.savings > 0 ? ' smaller.' : ' larger.';

//     return `${data.fileName} is ${data.percent}%${difference}`;
//   } ) )
//   .pipe( size( {
//     showFiles: true,
//     title: 'task:image: '
//   } ) )
//   .pipe( gulp.dest( config.path.images.dest ) )
//   .pipe( browserSync.reload( { stream: true } ) )
// );

// const spriteSvgConfig = {
//   'dest': '.',
//   // 'log': 'verbose',
//   'mode': {
//     'css': {
//       'dest': 'assets',
//       'sprite': '../img/sprite.svg',
//       'render': {
//         'scss': {
//           'dest': '../scss/sprite.scss'
//         }
//       }
//     }
//   }
// };

// /* Make sprite from images */
// gulp.task( 'image:spriteSVG', () => gulp
//   .src( `${config.path.images.src}sprites/**/*.svg` )
//   .pipe( customErrorPlumber( 'Error Running spriteSVG' ) )
//   .pipe( svgmin() )
//   .pipe( svgSprite( spriteSvgConfig ) )
//   .pipe( gulp.dest( config.path.base.src ) )
//   .pipe( size( {
//     showFiles: true,
//     title: 'task: image_sprite: '
//   } ) )
//   .pipe( browserSync.reload( { stream: true } ) )
// );

// /* Convert images to webp */
// gulp.task( 'image:image2webp', () => gulp.src( `${config.path.images.dest}/**/*.+(png|jpg|jpeg)` )
//   .pipe( customErrorPlumber( 'Error Running Webp' ) )
//   .pipe( isChanged( config.path.images.dest, {
//     extension: '.webp'
//   } ) )
//   .pipe( webp() )
//   .pipe( gulp.dest( config.path.images.dest ) ) );

// /* Copy fonts from assets folder to destination */
// gulp.task( 'fonts', () => gulp.src( config.path.fonts.src )
//   .pipe( customErrorPlumber( 'Error Running Fonts' ) )
//   .pipe( newer( config.path.fonts.dest ) )
//   .pipe( gulp.dest( config.path.fonts.dest ) )
//   .pipe( size( {
//     showFiles: true,
//     title: 'task:fonts'
//   } ) )
//   .pipe( browserSync.reload( { stream: true } ) ) );

// const jsConcat = lazypipe()
//   .pipe( concat, 'scripts.js', { newLine: '\n;' } );


// gulp.task('scripts', () => {
//   return gulp.src(config.path.scripts.src)
//     .pipe(customErrorPlumber('Error Running Scripts'))
//     .pipe(isChanged(config.path.scripts.dest))
//     .pipe(customErrorPlumber('Error Compiling Scripts'))
//     .pipe(sourcemaps.init())
//     .pipe(babel({
//       presets: ['@babel/preset-env']
//     }))
//     .pipe(uglify())
//     .pipe(sourcemaps.write('maps', { includeContent: true }))
//     .pipe(gulp.dest(config.path.scripts.dest))
//     .pipe(browserSync.reload({ stream: true }));
// });

// /* Base Gulp tasks */
// gulp.task( 'task:images',
//   gulp.series( 'image:default', 'image:spriteSVG', 'image:image2webp' )
// );

// gulp.task( 'task:images-styles',
//   gulp.series( 'task:images', 'styles' )
// );

// gulp.task( 'parallel-scripts-images-styles',
//   gulp.parallel( 'task:images-styles', 'scripts', 'fonts' )
// );

// gulp.task( 'default', gulp.parallel(
//   'task:images-styles',
//   'scripts',
//   'fonts'
// ) );

// gulp.task( 'build', gulp.parallel(
//   'task:images-styles',
//   'scripts',
//   'fonts'
// ) );


// /* Gulp watcher */
// gulp.task( 'watch', () => {
//   browserSync.init( browserSyncArgs );

//   gulp.watch( config.path.base.destHtml ).on( 'change', browserSync.reload );

//   gulp.watch( config.path.styles.srcFiles, gulp.series( 'styles' ) );

//   gulp.watch( config.path.images.srcImg, gulp.series( 'task:images' ) );

//   gulp.watch( config.path.fonts.src, gulp.series( 'fonts' ) );

//   gulp.watch( config.path.scripts.src, gulp.series( 'scripts' ) );
// } );

// /* Consolidated development phase task */
// gulp.task( 'serve', gulp.series( 'parallel-scripts-images-styles', 'watch' ) );

// /* Custom helper functions */
// /* Plumber function for catching errors */
// // https://github.com/mikaelbr/gulp-notify
// function customErrorPlumber ( errTitle ) {
//   return plumber( {
//     errorHandler: notify.onError( {

//       // Customizing error title
//       title: errTitle || 'Error running Gulp',
//       message: 'Error: <%= error.message %>',
//       templateOptions: {
//         date: new Date()
//       },
//       sound: 'Bottle'
//     } )
//   } );
// }
// module.exports = customErrorPlumber;

// function ChangeBasePath ( config ) {
//   config.path.images.dest = config.path.images.dest.replace(
//     config.path.base.dest, config.path.base.wp
//   );
//   config.path.fonts.dest = config.path.fonts.dest.replace(
//     config.path.base.dest, config.path.base.wp
//   );
//   config.path.styles.dest = config.path.styles.dest.replace(
//     config.path.base.dest, config.path.base.wp
//   );
//   config.path.scripts.dest = config.path.scripts.dest.replace(
//     config.path.base.dest, config.path.base.wp
//   );
//   config.path.base.destHtml = config.path.base.destHtml.replace(
//     config.path.base.dest, config.path.base.wp
//   );
// }


/* Compile and automatically prefix stylesheets */
// gulp.task( 'styles', () => {
//   // For best performance, don't add Sass partials to `gulp.src`
//   const srcPath = config.path.styles.srcFiles,
//     destPath = config.path.styles.dest;
//
//   return gulp.src( srcPath, { base: config.path.styles.src } )
//     .pipe( customErrorPlumber( 'Error Running Sass' ) )
//     // .pipe(plugin.newer(destPath))
//     .pipe( plugin.changed( destPath, { extension: '.css' } ) )
//     .pipe( plugin.if( isDev, plugin.sourcemaps.init() ) )
//     // .pipe(plugin.sourcemaps.init())
//     // TODO: add minify css if PROD
//     // TODO: add both version of css - minified and normal css and change loading at functions
//     .pipe( sass( {
//       // https://github.com/sass/node-sass#options
//       outputStyle: 'expanded',
//       precision: 5,
//       onError: console.error.bind( console, 'Sass error:' )
//     } ) )
//     // .pipe(plugin.postcss(processors))
//     .pipe( plugin.postcss( [ autoprefixer() ] ) )
//     .pipe( plugin.cleanCss( {
//       // https://github.com/clean-css/clean-css#how-to-use-clean-css-api
//       compatibility: '*', // (default) - Internet Explorer 10+ compatibility mode
//       level: 1 // Optimization levels. The level option can be either 0, 1 (default), or 2, e.g.
//     } ) )
//     .pipe( plugin.if( isDev, plugin.sourcemaps.write( 'maps', {
//       includeContent: true
//     } ) ) )
//     // .pipe(plugin.sourcemaps.write('maps', {includeContent: true}))
//     .pipe( gulp.dest( destPath ) )
//     .pipe( plugin.filter( '**/*.css' ) )
//     .pipe( plugin.size( {
//       showFiles: true,
//       title: 'task: SCSS && PostCSS'
//     } ) )
//     .pipe( browserSync.reload( { stream: true } ) );
// } );


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

// gulp.task( 'scripts', () => gulp.src( config.path.scripts.src )
//   .pipe( customErrorPlumber( 'Error Running Scripts' ) )
//   .pipe( plugin.changed( config.path.scripts.dest ) )
//   .pipe( customErrorPlumber( 'Error Compiling Scripts' ) )
//   .pipe( plugin.if( isDev, plugin.sourcemaps.init() ) )
//   .pipe( plugin.babel( {
//     presets: [ '@babel/preset-env' ]
//   } ) )
//   .pipe( plugin.if( [ 'scripts.js' /*,'scripts2.js'*/], jsConcat() ) )
//   .pipe( plugin.if( '*.js', plugin.uglify() ) )
//   .pipe( plugin.if( isDev, plugin.sourcemaps.write(
//     'maps',
//     { includeContent: true }
//   ) ) )
//   .pipe( gulp.dest( config.path.scripts.dest ) )
//   .pipe( plugin.filter( '**/*.js' ) )
//   .pipe( plugin.size( {
//     showFiles: true,
//     title: 'task:scripts:'
//   } ) )
//   .pipe( browserSync.reload( { stream: true } ) )
// );

// .pipe(plugins.notify("Hello Gulp!"))
// .pipe(plugins.notify("Found file: <%= file.relative %>!"))

// ToDo: check gulpfile from facebook https://github.com/facebook/relay
// ToDo: check good framework https://github.com/wowthemesnet/Wow-Gulp-WP-Starter
// ToDo: check good framework https://github.com/justcoded/web-starter-kit


// https://www.npmjs.com/package/gulp-newer
// https://www.npmjs.com/package/cross-env

// https://www.npmjs.com/package/yargs
// https://github.com/topics/gulp4
// https://github.com/topics/gulp
// https://github.com/luangjokaj/wordpressify
// https://github.com/topics/wordpress-theme


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
