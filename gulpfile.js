/* if work with html set TRUE, else - FALSE */
var htmlOWp = true,
  // set wordpress template folder
  wpThemeName = 'wp-framework',
  // and set wordpress domain
  wpDomain = 'wp-framework.dev';

var AUTOPREFIXER_BROWSERS = [
  'ie >= 8', 'ie_mob >= 10', 'ff >= 20', 'chrome >= 24', 'safari >= 5', 'opera >= 12', 'ios >= 7', 'android >= 2.3', '> 1%', 'last 4 versions', 'bb >= 10'
];

if (htmlOWp === true) {
  var basePaths = {
    src: 'assets/',
    dest: './html/'
  };
} else {
  var basePaths = {
    src: 'assets/',
    dest: './wordpress/wp-content/themes/' + wpThemeName + '/'
  };
}
var paths = {
  images: {
    src: basePaths.src + 'img/',
    srcimg: basePaths.src + 'img/**/*.{png,jpg,jpeg,gif,svg}',
    dest: basePaths.dest + 'img/'
  },
  scripts: {
    src: basePaths.src + 'js/**',
    dest: basePaths.dest + 'js/'
  },
  styles: {
    src: basePaths.src + 'scss/',
    css: basePaths.src + 'css/',
    dest: basePaths.dest + 'css/'
  },
  fonts: {
    src: basePaths.src + 'fonts/**',
    dest: basePaths.dest + 'fonts/'
  },
  sprite: {
    src: basePaths.src + 'sprite/*'
  }
};
var appFiles = {
  styles: paths.styles.src + '**/*.scss',
  scripts: [paths.scripts.src],
};
var changeEvent = function(evt) {
  gutil.log('File', gutil.colors.cyan(evt.path.replace(new RegExp('/.*(?=/' + basePaths.src + ')/'), '')), 'was', gutil.colors.magenta(evt.type));
};
var spriteConfig = {
  imgName: 'super_sprite.png',
  cssName: '_super_sprite.scss',
  imgPath: '../img/' + 'super_sprite.png'
};
var gulp = require('gulp'),
  gutil = require('gulp-util'),
  es = require('event-stream'),
  runSequence = require('run-sequence'),
  browserSync = require('browser-sync'),
  reload = browserSync.reload,
  pngquant = require('imagemin-pngquant'),
  plugins = require("gulp-load-plugins")({
    pattern: ['gulp-*', 'gulp.*'],
    replaceString: /\bgulp[\-.]/
  });

// postcss
var autoprefixer = require('autoprefixer'),
  mqpacker = require('css-mqpacker'),
  csswring = require('csswring'),
  cssnext = require('cssnext');

// Copy web fonts to dist
gulp.task('fonts', function() {
  return gulp.src(paths.fonts.src)
    .pipe(plugins.newer(paths.fonts.dest))
    .pipe(gulp.dest(paths.fonts.dest))
    .pipe(plugins.size({
      showFiles: true,
      title: 'task:fonts'
    }));
});

// Optimize images
gulp.task('images', function() {
  return gulp.src(paths.images.srcimg)
    .pipe(plugins.newer(paths.images.dest))
    .pipe(plugins.imagemin({
      progressive: true,
      interlaced: true,
      svgoPlugins: [{
        removeViewBox: false
      }],
      use: [pngquant()]
    }))
    .pipe(plugins.size({
      showFiles: true,
      title: 'task:images'
    }))
    .pipe(gulp.dest(paths.images.dest));
});


// Generate sprites
gulp.task('sprite', function() {
  var spriteData = gulp.src(paths.sprite.src + '*.png')
    .pipe(plugins.spritesmith({
      imgName: spriteConfig.imgName,
      cssName: spriteConfig.cssName,
      imgPath: spriteConfig.imgPath,
      cssVarMap: function(sprite) {
        sprite.name = 'sprite-' + sprite.name;
      }
    }))
    .pipe(plugins.if('*.png', gulp.dest(paths.images.src)))
    .pipe(plugins.if('*.scss', gulp.dest(paths.styles.src)))
    .pipe(plugins.size({
      showFiles: true,
      title: ' task:sprite'
    }));
});

// find images in css end encode it to base64
gulp.task('base64', function() {
  return gulp.src(paths.styles.src + '_base64.scss')
    .pipe(plugins.base64({
      extensions: ['svg', 'png', 'gif', 'jpg', /\.jpg#datauri$/i],
      maxImageSize: 20 * 1024, // bytes
      debug: false
    }))
    .pipe(gulp.dest(paths.styles.src));
});

// Optimize script
gulp.task('scripts', function() {
  gulp.src(appFiles.scripts)
    .pipe(plugins.newer(paths.scripts.dest))
    .pipe(customPlumber('Error Compiling Scripts'))
    .pipe(plugins.sourcemaps.init())
    .pipe(plugins.if('*.js', plugins.uglify()))
    .pipe(plugins.sourcemaps.write('maps', {
      includeContent: true
    }))
    .pipe(gulp.dest(paths.scripts.dest))
    .pipe(plugins.size({
      showFiles: true,
      title: 'task:scripts:'
    }));
});

// Compile and automatically prefix stylesheets
gulp.task('scss', function() {
  // For best performance, don't add Sass partials to `gulp.src`
  return gulp.src(appFiles.styles)
    .pipe(customPlumber('Error Running Sass'))
    .pipe(plugins.newer(paths.styles.css))
    .pipe(plugins.sourcemaps.init())
    .pipe(plugins.sass({
      outputStyle: 'compressed',
      precision: 10,
      onError: console.error.bind(console, 'Sass error:')
    }))
    .pipe(plugins.sourcemaps.write('maps', {
      includeContent: true
    }))
    .pipe(gulp.dest(paths.styles.css))
    .pipe(plugins.size({
      showFiles: true,
      title: 'task:styles'
    }));
});


// postcss autoprefix
gulp.task('postcss', function() {
  var processors = [
    autoprefixer({
      browsers: ['ie >= 8', 'ie_mob >= 10', 'ff >= 20', 'chrome >= 24', 'safari >= 5', 'opera >= 12', 'ios >= 7', 'android >= 2.3', '> 1%', 'last 4 versions', 'bb >= 10']
    }),
    mqpacker,
    csswring,
    cssnext()
  ];
  return gulp.src(paths.styles.css + '**/*.css')
    .pipe(customPlumber('Error Compiling PostCSS'))
    .pipe(plugins.newer(paths.styles.dest))
    .pipe(plugins.sourcemaps.init())
    .pipe(plugins.postcss(processors))
    .pipe(plugins.sourcemaps.write('maps', {
      includeContent: true
    }))
    .pipe(gulp.dest(paths.styles.dest))
    .pipe(plugins.size({
      showFiles: true,
      title: 'task:postcss'
    }));
});

// clear gulp cache
gulp.task('cache:clear', function(done) {
  return plugins.cache.clearAll(done);
});

// Browser Sync
gulp.task('browserSync', function() {
  if (htmlOWp === true) {
    browserSync({
      notify: false,
      port: 9080,
      server: {
        baseDir: basePaths.dest,
      }
    });
  } else {
    browserSync({
      notify: false,
      proxy: wpDomain,
      host: wpDomain,
      port: 9090
    });
  }
});

gulp.task('styles', function(callback) {
  runSequence(
    ['scss'], ['postcss'],
    callback
  )
})

// Consolidated dev phase task
gulp.task('serve', function(callback) {
  runSequence(
    'cache:clear', ['sprite', 'base64', 'images'], ['scripts'], ['scss', 'fonts'], ['postcss'], ['browserSync', 'watch'],
    callback
  );
});

gulp.task('watch', function() {
  // watch for changes
  gulp.watch([
    basePaths.dest + '**/*.{html,htm,php}'
  ]).on('change', reload);

  gulp.watch(paths.sprite.src, ['cache:clear', 'sprite', 'images', 'styles', reload]);
  gulp.watch(paths.images.srcimg, ['images', reload]);
  gulp.watch(paths.styles.src + '/_base64.scss', ['base64', reload]);
  gulp.watch(appFiles.styles, ['styles', reload]);
  gulp.watch(paths.sprite.src, ['styles', reload]);
  gulp.watch(paths.fonts.src, ['fonts', reload]);
  gulp.watch(appFiles.scripts, ['scripts', reload]);
});

// Custom Plumber function for catching errors
function customPlumber(errTitle) {
  return plugins.plumber({
    errorHandler: plugins.notify.onError({
      // Customizing error title
      title: errTitle || 'Error running Gulp',
      message: 'Error: <%= error.message %>',
      sound: "Bottle"
    })
  });
};
module.exports = customPlumber;
