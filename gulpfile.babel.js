'use strict';
/* if work with html set TRUE, else - FALSE */
const htmlOWp = true;

/* import dependencies */
import config from 'config';

import gulp from 'gulp';
import browserSync from 'browser-sync';
import lazypipe from 'lazypipe';

const plugins = require("gulp-load-plugins")({
  pattern: ['gulp-*', 'gulp.*'],
  replaceString: /\bgulp[\-.]/
});

/* PostCSS plugins */
import cssnext from 'postcss-preset-env';
import cssnano from 'cssnano';
import easysprite from 'postcss-easysprites';
// https://github.com/glebmachine/postcss-easysprites
import urlrev from 'postcss-urlrev';
import mqpacker from 'css-mqpacker';
import discardDuplicates from 'postcss-discard-duplicates';
import discardEmpty from 'postcss-discard-empty';
import combineDuplicatedSelectors from 'postcss-combine-duplicated-selectors';
import unprefix from 'postcss-unprefix';
import charset from 'postcss-single-charset';
import focus from 'postcss-focus';

const postCSSprocessors = [
  charset(),
  unprefix(),
  discardDuplicates(),
  discardEmpty(),
  mqpacker({
    sort: true
  }),
  combineDuplicatedSelectors({
    removeDuplicatedProperties: true
  }),
  easysprite({
      imagePath: './assets/img',
      spritePath: './assets/img'
  }),
  urlrev(),
  focus(),
  cssnext({
    browsers: [
      'ie >= 8',
      'ie_mob >= 10',
      'ff >= 20',
      'chrome >= 24',
      'safari >= 5',
      'opera >= 12',
      'ios >= 7',
      'android >= 2.3',
      '> 1%',
      'last 5 versions',
      'bb >= 10'
    ],
    warnForDuplicates: false
  }),
  cssnano({
    zindex: false,
    discardComments: {
      removeAll: true
    },
    discardUnused: {
      fontFace: false
    }
  })
];

if (htmlOWp === false) {
  config.path.base.wp = './wordpress/wp-content/themes/' + config.theme + '/';
  // config.path.base.wp = './html/'; /* only for php files located in html */
  ChangeBasePath(config);
  config.path.base.dest = config.path.base.wp;
}

/* browserSync config */
let args;
if (htmlOWp === true) {
  args = {
    notify: false,
    port: 9080,
    server: {
      baseDir: config.path.base.dest,
    }
  }
} else {
  args = {
    notify: false,
    port: 9090,
    proxy: config.domain,
    host: config.domain
  }
}

/* sprites */
import svgSprite from 'gulp-svg-sprites';
import svg2png from 'gulp-svg2png';


// Compile and automatically prefix stylesheets
gulp.task('styles', function() {
  // For best performance, don't add Sass partials to `gulp.src`
  let source = config.path.styles.srcfiles,
  // destination = config.path.styles.css;
  destination = config.path.styles.dest;
  return gulp.src(source)
    .pipe(customPlumber('Error Running Sass'))
    .pipe(plugins.newer(destination))
    .pipe(plugins.sourcemaps.init())
    .pipe(plugins.sass({
      outputStyle: 'compact',
      precision: 5,
      onError: console.error.bind(console, 'Sass error:')
    }))
    .pipe(plugins.postcss(postCSSprocessors))
    .pipe(plugins.sourcemaps.write('maps', {
      includeContent: true
    }))
    .pipe(gulp.dest(destination))
    .pipe(plugins.filter('**/*.css'))
    .pipe(plugins.size({
      showFiles: true,
      title: 'task:postcss'
    }))
    .pipe(browserSync.reload({stream: true}));
});

// Optimize images
gulp.task('images', function() {
  return gulp.src(config.path.images.srcimg)
    .pipe(customPlumber('Error Running Images'))
    .pipe(plugins.newer(config.path.images.dest))
    .pipe(plugins.bytediff.start())
    .pipe(plugins.imagemin([
      plugins.imagemin.gifsicle({
        interlaced: true
      }),
      plugins.imagemin.jpegtran({
        progressive: true
      }),
      plugins.imagemin.optipng({
        optimizationLevel: 5
      }),
      plugins.imagemin.svgo({
        plugins: [{
          removeViewBox: false,
          collapseGroups: true
        }]
      })
    ]))
    .pipe(plugins.bytediff.stop(function(data) {
      var difference = (data.savings > 0) ? ' smaller.' : ' larger.';
      return data.fileName + ' is ' + data.percent + '%' + difference;
    }))
    .pipe(plugins.size({
      showFiles: true,
      title: 'task:images'
    }))
    .pipe(gulp.dest(config.path.images.dest))
    .pipe(browserSync.reload({stream: true}));
});

// Generate sprites
gulp.task('sprites:png', function() {
  return gulp.src(config.path.images.spritePng)
    .pipe(customPlumber('Error Running Sprite PNG'))
    .pipe(plugins.spritesmith({
      imgName: config.sprite.imgName,
      cssName: config.sprite.cssName,
      imgPath: config.sprite.imgPath,
      cssVarMap: function(sprite) {
        sprite.name = 'sprite-' + sprite.name;
      }
    }))
    .pipe(plugins.if('*.png', gulp.dest(config.path.images.src)))
    .pipe(plugins.if('*.scss', gulp.dest(config.path.styles.src)))
    .pipe(plugins.size({
      showFiles: true,
      title: 'task:png sprite'
    }));
});

gulp.task('sprites:svg', function () {
  return gulp.src(config.path.images.spriteSvg)
    .pipe(customPlumber('Error Running Sprite SVG'))
    .pipe(plugins.size({
        showFiles: true,
        title: 'task:svg sprite >>'
    }))
    .pipe(svgSprite({
      baseSize: 16,
      common: 'svgico',
      selector: 'svgico-%f',
      cssFile: 'scss/_sprite_svg.scss',
      svg: {
        sprite: 'img/_sprite_svg.svg'
      },
      pngPath: '../img/_sprite_svg.png',
      preview: {
        sprite: 'svg-sprite-preview.html'
      },
      padding: 5
    }))
    .pipe(gulp.dest('assets')) // Write the sprite-sheet + CSS + Preview
    .pipe(plugins.size({
      showFiles: true,
      title: 'task:svg sprite >>'
    }))
    .pipe(plugins.filter('**/*.svg')) // Filter out everything except the SVG file
    .pipe(plugins.size({
      showFiles: true,
      title: 'task:svg sprite >> svg'
    }))
    .pipe(svg2png()) // Create a PNG
    .pipe(gulp.dest('assets'))
    .pipe(plugins.size({
      showFiles: true,
      title: 'task:svg sprite >> png'
    }));
});

// Copy web fonts to dist
gulp.task('fonts', function() {
  return gulp.src(config.path.fonts.src)
    .pipe(customPlumber('Error Running Fonts'))
    .pipe(plugins.newer(config.path.fonts.dest))
    .pipe(gulp.dest(config.path.fonts.dest))
    .pipe(plugins.size({
      showFiles: true,
      title: 'task:fonts'
    }))
    .pipe(browserSync.reload({stream: true}));
});


var jsConcat = lazypipe()
  .pipe(plugins.concat, 'scripts.js', {newLine: '\n;'})

// Optimize script
gulp.task('scripts', function() {
  return gulp.src(config.path.scripts.src)
    .pipe(customPlumber('Error Running Scripts'))
    .pipe(plugins.newer(config.path.scripts.dest))
    .pipe(customPlumber('Error Compiling Scripts'))
    .pipe(plugins.sourcemaps.init())
    .pipe(plugins.babel({
			presets: ['env']
		}))
    .pipe(plugins.if(['scripts.js' /*,'scripts2.js'*/], jsConcat()))
    .pipe(plugins.if('*.js', plugins.uglify()))
    .pipe(plugins.sourcemaps.write('maps', {
      includeContent: true
    }))
    .pipe(gulp.dest(config.path.scripts.dest))
    .pipe(plugins.filter('**/*.js'))
    .pipe(plugins.size({
      showFiles: true,
      title: 'task:scripts:'
    }))
    .pipe(browserSync.reload({stream: true}));
});

gulp.task('task:sprites', gulp.parallel('sprites:svg', 'sprites:png'));
gulp.task('task:images', gulp.series('task:sprites', 'images'));
gulp.task('task:images-styles', gulp.series('task:images', 'styles'));
gulp.task('parallel-scripts-images-styles', gulp.parallel('task:images-styles', 'scripts', 'fonts'));

// watch for changes
gulp.task('watch', function() {

  browserSync.init(args);

  gulp.watch(config.path.base.desthtml).on('change', browserSync.reload);

  gulp.watch(config.path.styles.srcfiles, gulp.series('styles'));

  gulp.watch(config.path.images.spritePng, gulp.series('sprites:png'));
  gulp.watch(config.path.images.spriteSvg, gulp.series('sprites:svg'));
  gulp.watch(config.path.images.srcimg, gulp.series('images'));

  gulp.watch(config.path.fonts.src, gulp.series('fonts'));

  gulp.watch(config.path.scripts.src, gulp.series('scripts'));

});

// Consolidated dev phase task
gulp.task('serve', gulp.series('parallel-scripts-images-styles', 'watch'));

gulp.task('default', gulp.series('parallel-scripts-images-styles'));

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

function ChangeBasePath(config) {
  config.path.images.dest = config.path.images.dest.replace(config.path.base.dest, config.path.base.wp);
  config.path.fonts.dest = config.path.fonts.dest.replace(config.path.base.dest, config.path.base.wp);
  config.path.styles.dest = config.path.styles.dest.replace(config.path.base.dest, config.path.base.wp);
  config.path.scripts.dest = config.path.scripts.dest.replace(config.path.base.dest, config.path.base.wp);
  config.path.base.desthtml = config.path.base.desthtml.replace(config.path.base.dest, config.path.base.wp);
}
