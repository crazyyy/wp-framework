'use strict';

/**
 * Gulp workflow for WordPress theme development
 * Includes SCSS, JS, image optimization, fonts, BrowserSync
 */

// ===== Set isHtmlDev to TRUE if work with html, else - FALSE =====
const isHtmlDev = true;

// ===== Detect environment =====
const isProd = process.env.NODE_ENV === 'production';
const isTest = process.env.NODE_ENV === 'test';
const isDev = !isProd && !isTest;


// ToDo: Cosmiconfig searches for and loads configuration for your program https://github.com/cosmiconfig/cosmiconfig
// const lazypipe = require( 'lazypipe' );
// const replace = require( 'gulp-replace' );
// const extReplace = require( 'gulp-ext-replace' );
// const bytediff = require( 'gulp-bytediff' );

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
};

if ( isHtmlDev ) {
  browserSyncArgs.server = {
    baseDir: paths.base.dest,
  };
  browserSyncArgs.logPrefix = 'HTML';
} else {
  browserSyncArgs.proxy = `https://${config.domain}`;
  // browserSyncArgs.host = config.domain;
  browserSyncArgs.logPrefix = 'WP';
}

/* Pre-Config Path */
if ( !isHtmlDev ) {
  config.path.base.wp = `./wp-content/themes/${config.theme}/`;

  // config.path.base.wp = './html/'; /* only for php files located in html */
  changeBasePath( config );
  config.path.base.dest = config.path.base.wp;
}

/* Start Build */
if ( isProd ) {
  console.log( '\x1b[32m', '-------------  PRODUCTION -------------' );
  console.log( '\x1b[36m', '--------- Sourcemaps DISABLED ---------' );
} else if ( isDev ) {
  console.log( '\x1b[31m', '------------- DEVELOPMENT -------------' );
  console.log( '\x1b[31m', '--------- Sourcemaps ENABLED ---------' );
}

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

/**
 * Update config.path destinations to replace base.dest with base.wp
 * @param {Object} config - Configuration object with path definitions
 */
function changeBasePath(config) {
  const { base, images, fonts, styles, scripts } = config.path;

  // List of keys in config.path that need replacement
  const keysToUpdate = ["images", "fonts", "styles", "scripts"];

  // Replace base.dest with base.wp for all listed keys
  for (const key of keysToUpdate) {
    if (config.path[key] && config.path[key].dest) {
      config.path[key].dest = config.path[key].dest.replace(base.dest, base.wp);
    }
  }

  // Handle destHtml separately
  if (base.destHtml) {
    config.path.base.destHtml = base.destHtml.replace(base.dest, base.wp);
  }
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




