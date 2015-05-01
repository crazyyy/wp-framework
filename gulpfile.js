var gulp = require('gulp'),
  gutil = require('gulp-util'),
  es = require('event-stream'),
  runSequence = require('run-sequence'),
  browserSync = require('browser-sync'),
  reload =  browserSync.reload,
  pngquant = require('imagemin-pngquant'),
  plugins = require("gulp-load-plugins")({
    pattern: ['gulp-*', 'gulp.*'],
    replaceString: /\bgulp[\-.]/
  });

/* if work with html == true, else - false */
var htmlOWp = true,
  wpThemeName = 'wp-framework',
  wpDomain = 'wp-framework.dev';

var AUTOPREFIXER_BROWSERS = [
  'ie >= 8', 'ie_mob >= 10', 'ff >= 20', 'chrome >= 24', 'safari >= 5', 'opera >= 12', 'ios >= 7', 'android >= 2.3', '> 1%', 'last 4 versions', 'bb >= 10'
];

if (htmlOWp === true) {
  var basePaths = {
    src: 'assets/',
    cache: 'application/templates_c/*.php',
    dest: './html/'
  };
} else {
  var basePaths = {
    src: 'assets/',
    cache: 'application/templates_c/*.php',
    dest: './wordpress/wp-content/themes/' + wpThemeName + '/'
  };
}
var paths = {
  images: {
    src: basePaths.src + 'img/',
    dest: basePaths.dest + 'img/'
  },
  scripts: {
    src: basePaths.src + 'js/**',
    dest: basePaths.dest + 'js/'
  },
  styles: {
    src: basePaths.src + 'sass/',
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
  scripts: [paths.scripts.src]
};
var spriteConfig = {
  imgName: 'sprite.png',
  cssName: '_sprite.scss',
  imgPath: '../img/' + 'sprite.png'
};
var changeEvent = function (evt) {
  gutil.log('File', gutil.colors.cyan(evt.path.replace(new RegExp('/.*(?=/' + basePaths.src + ')/'), '')), 'was', gutil.colors.magenta(evt.type));
};

// Copy web fonts to dist
gulp.task('fonts', function () {
  return gulp.src(paths.fonts.src)
    .pipe(gulp.dest(paths.fonts.dest))
    .pipe(plugins.size({title: 'fonts'}));
});

// Temp image cp
gulp.task('imagecp', function () {
  return gulp.src(paths.images.src)
    .pipe(gulp.dest(paths.images.dest))
    .pipe(plugins.size({title: 'img copy'}));
});

// Optimize images
gulp.task('image', function () {
  return gulp.src(paths.images.src + '**/*.{png, jpg, jpeg, .gif}')

    .pipe(plugins.cache(
      plugins.imagemin({
        progressive: true,
        svgoPlugins: [{removeViewBox: false}],
        use: [pngquant()]
      })
    ))
    .pipe(gulp.dest(paths.images.dest))
    .pipe(plugins.size({title: 'images'}));
});

gulp.task('sprite', function () {
  var spriteData = gulp.src(paths.sprite.src + '*.png').pipe(plugins.spritesmith({
    imgName: spriteConfig.imgName,
    cssName: spriteConfig.cssName,
    imgPath: spriteConfig.imgPath,
    cssVarMap: function (sprite) {
      sprite.name = 'sprite-' + sprite.name;
    }
  }));
  spriteData.img
    .pipe(plugins.size({showFiles: true}))
    .pipe(plugins.cache(
      plugins.imageOptimization({
        optimizationLevel: 3,
        progressive: true,
        interlaced: true
      })
    ))
    .pipe(gulp.dest(paths.images.dest))
    .pipe(plugins.size({showFiles: true}))
    .pipe(plugins.webp())
    .pipe(gulp.dest(paths.images.dest))
    .pipe(plugins.size({showFiles: true}));
  spriteData.css.pipe(gulp.dest(paths.styles.src));
});

gulp.task('webp', function () {
  return gulp.src([paths.images.src + '**/*.png', paths.images.src + '**/*.jpg', paths.images.src + '**/*.jpeg', paths.images.src + '**/*.gif'])
    .pipe(plugins.webp())
    .pipe(gulp.dest(paths.images.dest))
    .pipe(plugins.size({showFiles: true}));
});

// Lint JavaScript
gulp.task('jshint', function () {
  return gulp.src(paths.scripts.src)
    .pipe(reload({stream: true, once: true}))
    .pipe(plugins.jshint())
    .pipe(plugins.jshint.reporter('jshint-stylish'));
});

// Optimize script
gulp.task('scripts', function () {
  gulp.src(appFiles.scripts)
    .pipe(plugins.if('*.js', plugins.uglify()))
    .pipe(plugins.size({showFiles: true}))
    .pipe(gulp.dest(paths.scripts.dest));
});

// Compile and automatically prefix stylesheets
gulp.task('styles', function () {
  // For best performance, don't add Sass partials to `gulp.src`
  return gulp.src(appFiles.styles)
    .pipe(plugins.sourcemaps.init())
    .pipe(plugins.sass({
      precision: 10,
      onError: console.error.bind(console, 'Sass error:')
    }))
    .pipe(plugins.autoprefixer({browsers: AUTOPREFIXER_BROWSERS}))
    .pipe(plugins.sourcemaps.write())
    .pipe(gulp.dest(paths.styles.dest))
    // Concatenate and minify styles
    .pipe(plugins.if('*.css', plugins.csso()))
    .pipe(gulp.dest(paths.styles.dest))
    .pipe(plugins.size({title: 'styles'}));
});

gulp.task('clearcache', function () {
  return gulp.src(basePaths.cache, {read: false})
    .pipe(plugins.wait(500))
    .pipe(plugins.rimraf());
});
gulp.task('clearPluginCache', function (done) {
  return plugins.cache.clearAll(done);
});

gulp.task('default', ['clearPluginCache', 'scripts', 'styles', 'fonts'], function () {
  if (htmlOWp === true) {
    browserSync({
      notify: false,
      port: 9000,
      server: {
        baseDir: basePaths.dest,
      }
    });
  } else {
    browserSync({
      notify: false,
      proxy: wpDomain,
      host: wpDomain,
      port: 8080
    });
  }

  // watch for changes
  gulp.watch([
    basePaths.dest + '*.html',
    basePaths.dest + '*.php',
    appFiles.scripts,
    paths.images.src,
    paths.fonts.src
  ]).on('change', reload);

  // gulp.watch(paths.images.src, ['image', reload]);
  gulp.watch(paths.images.src, ['imagecp', reload]);
  gulp.watch(appFiles.styles, ['styles', reload]);
  gulp.watch(paths.sprite.src, ['styles', reload]);
  gulp.watch(paths.fonts.src, ['fonts', reload]);
  gulp.watch(appFiles.scripts, ['jshint']);
  gulp.watch(appFiles.scripts, ['scripts', reload]);

});

gulp.task('serve', ['clearPluginCache', 'sprite', 'image', 'webp', 'scripts', 'styles', 'fonts'], function () {
  if (htmlOWp === true) {
    browserSync({
      notify: false,
      port: 9000,
      server: {
        baseDir: basePaths.dest,
      }
    });
  } else {
    browserSync({
      notify: false,
      proxy: wpDomain,
      host: wpDomain,
      port: 8080
    });
  }

  // watch for changes
  gulp.watch([
    basePaths.dest + '*.html',
    basePaths.dest + '*.php',
    appFiles.scripts,
    paths.fonts.src
  ]).on('change', reload);

  gulp.watch(paths.sprite.src, ['sprite', 'image', 'webp', 'styles', reload]);
  gulp.watch(paths.images.src, ['image', 'webp', reload]);
  gulp.watch(appFiles.styles, ['styles', reload]);
  gulp.watch(paths.sprite.src, ['styles', reload]);
  gulp.watch(paths.fonts.src, ['fonts', reload]);
  gulp.watch(appFiles.scripts, ['jshint']);
  gulp.watch(appFiles.scripts, ['scripts', reload]);

});
