'use strict';
/* if work with html set TRUE, else - FALSE */
const htmlOWp = false;
let env_prod = true;

// TODO: add https://github.com/olegskl/gulp-stylelint
// TODO: add https://github.com/morishitter/stylefmt
// TODO: add https://github.com/johno/immutable-css
// TODO: add h Autoprefixer https://github.com/postcss/autoprefixer
// Stylelint https://github.com/stylelint/stylelint
// Postcss-flexbugs-fixes https://github.com/luisrudge/postcss-flexbugs-fixes

// TODO: retina display mixnis transfer from mixin


if (env_prod === true) {
  console.log('\x1b[32m', process.env.NODE_ENV);
  console.log('\x1b[32m', '---------PRODUCTION ---------');
  console.log('\x1b[36m', '---------Sourcemaps DISABLED!---------');
} else {
  console.log('\x1b[31m', process.env.NODE_ENV);
  console.log('\x1b[31m', '---------DEV----------');
  console.log('\x1b[31m', '---------Sourcemaps ENABLED!---------');
}

/* import dependencies */
import config from 'config';
import gulp from 'gulp';
import browserSync from 'browser-sync';

/* PostCSS plugins */
import postcssPresetEnv from 'postcss-preset-env';
import cssnano from 'cssnano';
import easysprite from 'postcss-easysprites';
import urlrev from 'postcss-urlrev';
import discardDuplicates from 'postcss-discard-duplicates';
import discardEmpty from 'postcss-discard-empty';
import combineDuplicatedSelectors from 'postcss-combine-duplicated-selectors';
import mqpacker from 'css-mqpacker'; // install via yarn
import charset from 'postcss-single-charset';
import willChangeTransition from 'postcss-will-change-transition';
import willChange from 'postcss-will-change';
import momentumScrolling from 'postcss-momentum-scrolling';
import webpcss from 'webpcss';


import replace from 'gulp-replace';

const extReplace = require("gulp-ext-replace");
const imageminWebp = require("imagemin-webp");
const imageminPngquant = require('imagemin-pngquant');
const imageminMozjpeg = require('imagemin-mozjpeg');
const imageminAdvpng = require('imagemin-advpng');
const imageminGuetzli = require('imagemin-guetzli');

const plugins = require('gulp-load-plugins')({
  pattern: ['gulp-*', 'gulp.*'],
  replaceString: /\bgulp[\-.]/
});

config.path.base.wp = './wp-content/themes/' + config.theme + '/';
ChangeBasePath(config);
config.path.base.dest = config.path.base.wp;

let processors = [
  charset(),
  willChangeTransition(),
  willChange(),
  momentumScrolling([
    'scroll'
  ]),
  discardDuplicates(),
  discardEmpty(),
  combineDuplicatedSelectors({
    removeDuplicatedProperties: true
  }),
  easysprite({
    imagePath:'./assets/img/sprites',
    spritePath: './assets/img/sprites'
  }),
  // webpcss({
  //   copyBackgroundSize: true
  // }),
];

let processorsAfter = [
  urlrev(),
  postcssPresetEnv({
    stage: 4,
    warnForDuplicates: false
  }),
  cssnano({
    preset: 'advanced',
    reduceIdents: true,
    zindex: false
  })
];

let processorsDisableZIndex= [
  urlrev(),
  postcssPresetEnv({
    stage: 4,
    warnForDuplicates: false
  }),
  cssnano({
    preset: 'default',
    reduceIdents: true,
    zindex: false
  })
];

let processorsAfterSCSS = [
  // https://github.com/hail2u/node-css-mqpacker#options
  // mqpacker({
  //   sort: function (a, b) {
  //     return a.localeCompare(b);
  //   }
  // }),
  urlrev(),
  postcssPresetEnv({
    stage: 4,
    warnForDuplicates: false
  }),
  cssnano({
    preset: 'advanced',
    reduceIdents: true,
    zindex: false
  })
];

/* separated styles */
const arr_less = [
  'assets/less/flags.less',
  'assets/less/landing-book.less',
  'assets/less/install-app-page.less',
  'assets/less/hosters-logo.less',
  'assets/less/template-azure-private-cloud.less',
  'assets/less/template-cloud-platform-for-hosting-provider.less',
  'assets/less/template-company.less',
  'assets/less/template-contacts.less',
  'assets/less/template-docker-containers.less',
  'assets/less/template-enterprise-cloud-page.less',
  'assets/less/template-events.less',
  'assets/less/template-gdpr-compliance.less',
  // 'assets/less/template-hosting-page.less',
  'assets/less/template-investors.less',
  'assets/less/template-java-cloud-hosting.less',
  'assets/less/template-jelastic-paas-support.less',
  'assets/less/template-kubernetes-hosting.less',
  'assets/less/template-load-balancing.less',
  'assets/less/template-manage-personal-data.less',
  'assets/less/template-managed-hosting-for-providers.less',
  'assets/less/template-paas-cloud-hosting.less',
  'assets/less/template-paas-for-developers.less',
  'assets/less/template-partners.less',
  'assets/less/template-pay-as-you-use.less',
  'assets/less/template-pc-free-trial.less',
  'assets/less/template-pricing-page.less',
  'assets/less/template-privacy-policy.less',
  'assets/less/template-private-cloud-platform.less',
  'assets/less/template-request-auto-scalable-cluster.less',
  'assets/less/template-request-functionality.less',
  'assets/less/template-shared-storage.less',
  'assets/less/template-signin.less',
  'assets/less/template-terms-and-conditions.less',
  'assets/less/template-thank-you-download-your-guide.less',
  'assets/less/template-thank-you-get-your-guide-2.less',
  'assets/less/template-thank-you-get-your-guide.less',
  'assets/less/template-whitepapers.less',
  'assets/less/template-wordpress-hosting-business-page.less',
  'assets/less/template-jelastic-company.less',
];
gulp.task('less', function () {
  return gulp
    .src(arr_less)
    .pipe(customPlumber('Error Running less'))
    .pipe(plugins.size({
      showFiles: true,
      title: 'task:less'
    }))
    .pipe(plugins.newer(config.path.styles.dest))
    .pipe(plugins.less())
    .pipe(plugins.postcss(processors))
    .pipe(plugins.rename({
      extname: '.css'
    }))
    .pipe(gulp.dest(config.path.styles.dest))
    .pipe(plugins.size({
      showFiles: true,
      title: 'task:less'
    }))
    .pipe(browserSync.reload({stream: true}));
});

/* header and footer styles only for blog */
const arr_less_headfoot= [
  'assets/less/_jlc_grid.less',
  'assets/less/_jlc_ico.less',
  'assets/less/header.less',
  'assets/less/gdprbar.less',
  'assets/less/footer.less'
];
gulp.task('less_headfoot', function () {
  return gulp
    .src(arr_less_headfoot)
    .pipe(customPlumber('Error Running less_headfoot'))
    .pipe(plugins.newer(config.path.styles.dest))
    .pipe(plugins.if(!env_prod, plugins.sourcemaps.init()))
    .pipe(plugins.less())
    .pipe(plugins.postcss(processors))
    .pipe(plugins.concat('headfoot.min.css'))
    .pipe(plugins.if(!env_prod, plugins.sourcemaps.write('maps', {includeContent: true})))
    .pipe(gulp.dest(config.path.styles.dest))
    .pipe(plugins.size({
      showFiles: true,
      title: 'task:less_headfoot'
    }))
    .pipe(browserSync.reload({stream: true}));
});

/* default site style */
const arr_less_style = [
  'assets/less/vendor/_reset.less',
  'assets/less/vendor/_fonts.less',
  'assets/less/vendor/vendor-style.less',
  'assets/less/vendor/rgs.less',
  'assets/less/vendor/responsive.less',
  'assets/less/flags.less',
  'assets/less/components/_youtube-lazyload.less',
  'assets/less/components/_keyframes.less',
  'assets/less/_jlc_ico.less',
  'assets/less/_jlc_grid.less',
  'assets/less/_je-carousel.less',
  'assets/less/_buttons.less',
  'assets/less/signup-block.less',
  'assets/less/hosters.select.less',
  'assets/less/signin.less',
  'assets/less/under-banner.less',
  'assets/less/hosters-simple-carousel.less',
  'assets/less/main.less',
  'assets/less/selectize.less',
  'assets/less/sliders.less',
  'assets/less/video-pop-up.less',
  'assets/less/header.less',
  'assets/less/footer.less',
  'assets/less/gdprbar.less',
  'assets/less/flat-default.less',
  'assets/less/form.less',
  'assets/less/jquery.fancybox.less',
  'assets/less/style.less'
];
gulp.task('less_style', function () {
  return gulp
    .src(arr_less_style)
    .pipe(customPlumber('Error Running less_style'))
    .pipe(plugins.newer(config.path.styles.dest))
    .pipe(plugins.if(!env_prod, plugins.sourcemaps.init()))
    .pipe(plugins.less())
    .pipe(plugins.postcss(processors))
    .pipe(plugins.concat('style.min.css'))
    .pipe(plugins.if(!env_prod, plugins.sourcemaps.write('maps', {includeContent: true})))
    .pipe(gulp.dest(config.path.styles.dest))
    .pipe(plugins.size({
      showFiles: true,
      title: 'task:less_style'
    }))
    .pipe(browserSync.reload({stream: true}));
});

/* home page concated styles */
const arr_less_style_01 = [
  'assets/less/vendor/_reset.less',
  'assets/less/vendor/_fonts.less',
  'assets/less/vendor/vendor-style.less',
  'assets/less/vendor/rgs.less',
  'assets/less/vendor/responsive.less',
  'assets/less/flags.less',
  'assets/less/components/_youtube-lazyload.less',
  'assets/less/components/_keyframes.less',
  'assets/less/_jlc_ico.less',
  'assets/less/_jlc_grid.less',
  'assets/less/_je-carousel.less',
  'assets/less/_buttons.less',
  'assets/less/signup-block.less',
  'assets/less/hosters.select.less',
  'assets/less/signin.less',
  'assets/less/under-banner.less',
  'assets/less/hosters-simple-carousel.less',
  'assets/less/main.less',
  'assets/less/selectize.less',
  'assets/less/sliders.less',
  'assets/less/video-pop-up.less',
  'assets/less/header.less',
  'assets/less/footer.less',
  'assets/less/gdprbar.less',
  'assets/less/flat-default.less',
  'assets/less/form.less',
  'assets/less/jquery.fancybox.less',
  'assets/less/style.less',
  'assets/less/template-front-page.less',
];
gulp.task('less_style_01', function () {
  return gulp
    .src(arr_less_style_01)
    .pipe(customPlumber('Error Running less_style'))
    .pipe(plugins.newer(config.path.styles.dest))
    .pipe(plugins.if(!env_prod, plugins.sourcemaps.init()))
    .pipe(plugins.less())
    .pipe(plugins.postcss(processors))
    .pipe(plugins.concat('template-front-page.css'))
    .pipe(plugins.if(!env_prod, plugins.sourcemaps.write('maps', {includeContent: true})))
    .pipe(gulp.dest(config.path.styles.dest))
    .pipe(plugins.size({
      showFiles: true,
      title: 'task:less_style_01'
    }))
    .pipe(browserSync.reload({stream: true}));
});

// Compile and automatically prefix stylesheets
gulp.task('template-enterprise-paas', function() {
  let templateName = 'template-enterprise-paas',
  source = 'assets/scss/' + templateName + '.scss',
  destination = config.path.styles.dest;
  return gulp.src(source)
    .pipe(customPlumber('Error Running Sass'))
    .pipe(plugins.if(!env_prod, plugins.sourcemaps.init()))
    .pipe(plugins.sass({
      outputStyle: 'compact',
      precision: 5,
      onError: console.error.bind(console, 'Sass error:')
    }))
    .pipe(plugins.postcss(processors))
    .pipe(plugins.if(!env_prod, plugins.sourcemaps.write('maps', {includeContent: true})))
    .pipe(gulp.dest(destination))
    .pipe(plugins.size({
      showFiles: true,
      title: 'task: ' + templateName
    }))
    .pipe(browserSync.reload({stream: true}));
});

gulp.task('template-auto-scalable-clustering', function() {
  let templateName = 'template-auto-scalable-clustering',
  source = 'assets/scss/' + templateName + '.scss',
  destination = config.path.styles.dest;
  return gulp.src(source)
    .pipe(customPlumber('Error Running Sass'))
    .pipe(plugins.if(!env_prod, plugins.sourcemaps.init()))
    .pipe(plugins.sass({
      outputStyle: 'compact',
      precision: 5,
      onError: console.error.bind(console, 'Sass error:')
    }))
    .pipe(plugins.postcss(processors))
    .pipe(plugins.if(!env_prod, plugins.sourcemaps.write('maps', {includeContent: true})))
    .pipe(gulp.dest(destination))
    .pipe(plugins.size({
      showFiles: true,
      title: 'task: ' + templateName
    }))
    .pipe(browserSync.reload({stream: true}));
});

gulp.task('template-kubernetes-cloud-services', function() {
  let templateName = 'template-kubernetes-cloud-services',
  source = 'assets/scss/' + templateName + '.scss',
  destination = config.path.styles.dest;
  return gulp.src(source)
    .pipe(customPlumber('Error Running Sass'))
    .pipe(plugins.if(!env_prod, plugins.sourcemaps.init()))
    .pipe(plugins.sass({
      outputStyle: 'compact',
      precision: 5,
      onError: console.error.bind(console, 'Sass error:')
    }))
    .pipe(plugins.postcss(processors))
    .pipe(plugins.if(!env_prod, plugins.sourcemaps.write('maps', {includeContent: true})))
    .pipe(gulp.dest(destination))
    .pipe(plugins.size({
      showFiles: true,
      title: 'task: ' + templateName
    }))
    .pipe(browserSync.reload({stream: true}));
});

gulp.task('template-pay-as-you-use-new-gen', function() {
  let templateName = 'template-pay-as-you-use-new-gen',
  source = 'assets/scss/' + templateName + '.scss',
  destination = config.path.styles.dest;
  return gulp.src(source)
    .pipe(customPlumber('Error Running Sass'))
    .pipe(plugins.if(!env_prod, plugins.sourcemaps.init()))
    .pipe(plugins.sass({
      outputStyle: 'compact',
      precision: 5,
      onError: console.error.bind(console, 'Sass error:')
    }))
    .pipe(plugins.postcss(processors))
    .pipe(plugins.if(!env_prod, plugins.sourcemaps.write('maps', {includeContent: true})))
    .pipe(gulp.dest(destination))
    .pipe(plugins.size({
      showFiles: true,
      title: 'task: ' + templateName
    }))
    .pipe(browserSync.reload({stream: true}));
});



gulp.task('template-newdocker', function() {
  let templateName = 'template-newdocker',
  source = 'assets/scss/' + templateName + '.scss',
  destination = config.path.styles.dest;
  return gulp.src(source)
    .pipe(customPlumber('Error Running Sass'))
    .pipe(plugins.if(!env_prod, plugins.sourcemaps.init()))
    .pipe(plugins.sass({
      outputStyle: 'compact',
      precision: 5,
      onError: console.error.bind(console, 'Sass error:')
    }))
    .pipe(plugins.postcss(processors))
    .pipe(plugins.if(!env_prod, plugins.sourcemaps.write('maps', {includeContent: true})))
    .pipe(gulp.dest(destination))
    .pipe(plugins.size({
      showFiles: true,
      title: 'task: ' + templateName
    }))
    .pipe(browserSync.reload({stream: true}));
});

gulp.task('template-hosting-page', function() {
  let templateName = 'template-hosting-page',
  source = 'assets/scss/' + templateName + '.scss',
  destination = config.path.styles.dest;
  return gulp.src(source)
    .pipe(customPlumber('Error Running Sass'))
    .pipe(plugins.if(!env_prod, plugins.sourcemaps.init()))
    .pipe(plugins.sass({
      outputStyle: 'compact',
      precision: 5,
      onError: console.error.bind(console, 'Sass error:')
    }))
    .pipe(plugins.postcss(processors))
    .pipe(plugins.if(!env_prod, plugins.sourcemaps.write('maps', {includeContent: true})))
    .pipe(gulp.dest(destination))
    .pipe(plugins.size({
      showFiles: true,
      title: 'task: ' + templateName
    }))
    .pipe(browserSync.reload({stream: true}));
});

// .pipe(plugins.if('*.js', plugins.uglify()))
var exclude_condition = 'headfoot.min.css';
gulp.task('style_after', function () {
  return gulp
    .src(config.path.styles.dest + '**/*.css')
    .pipe(plugins.newer(config.path.images.dest))
    .pipe(customPlumber('Error Running less_style'))
    .pipe(plugins.ignore.exclude(exclude_condition))
    .pipe(plugins.postcss(processorsAfterSCSS))
    .pipe(gulp.dest(config.path.styles.dest))
    .pipe(plugins.size({
      showFiles: true,
      title: 'task:style_after'
    }))
    .pipe(browserSync.reload({stream: true}));
});

gulp.task('style_after_disable_zindex', function () {
  return gulp
    .src(config.path.styles.dest + '**/*.css')
    .pipe(plugins.newer(config.path.images.dest))
    .pipe(customPlumber('Error Running less_style'))
    .pipe(plugins.if(exclude_condition, plugins.postcss(processorsDisableZIndex)))
    .pipe(gulp.dest(config.path.styles.dest))
    .pipe(plugins.size({
      showFiles: true,
      title: 'task:style_after'
    }))
    .pipe(browserSync.reload({stream: true}));
});


gulp.task('style_after_scss', function () {
  return gulp
    .src([config.path.styles.dest + 'template-enterprise-paas.css', config.path.styles.dest + 'template-newdocker.css', config.path.styles.dest + 'template-auto-scalable-clustering.css', config.path.styles.dest + 'template-kubernetes-cloud-services.css',config.path.styles.dest + 'template-hosting-page.css', config.path.styles.dest + 'template-pay-as-you-use-new-gen.css'])
    .pipe(plugins.newer(config.path.images.dest))
    .pipe(customPlumber('Error Running less_style'))
    .pipe(plugins.postcss(processorsAfterSCSS))
    .pipe(gulp.dest(config.path.styles.dest))
    .pipe(plugins.size({
      showFiles: true,
      title: 'task:, style_after_scss'
    }))
    .pipe(browserSync.reload({stream: true}));
});

gulp.task('image_copy', function () {
  return gulp
    .src(config.path.images.srcimgNew)
    .pipe(plugins.newer(config.path.images.src))
    .pipe(gulp.dest(config.path.images.src))
    .pipe(plugins.size({
      showFiles: true,
      title: 'task:images copy'
    }));
});

// Optimize images
gulp.task('image', function () {
  return gulp
    .src(config.path.images.srcimg)
    .pipe(plugins.newer(config.path.images.dest))
    .pipe(plugins.if(
      '*.png',
      plugins.imagemin([
        imageminPngquant(),
        imageminAdvpng(),
      ])
    ))
    .pipe(plugins.if(
      '*.jp*g',
      plugins.imagemin([
        imageminMozjpeg({progressive: true}),
        imageminGuetzli({quality: 95}),
      ])
    ))
    .pipe(plugins.if(
      '*.gif',
      plugins.imagemin([
        plugins.imagemin.gifsicle({
          interlaced: true
        }),
      ])
    ))
    .pipe(plugins.if(
      '*.svg',
      plugins.imagemin([
        plugins.imagemin.svgo({
          plugins: [{
            removeViewBox: true
          }]
        })
      ])
    ))
    .pipe(plugins.size({
      showFiles: true,
      title: 'task:image: '
    }))
    .pipe(gulp.dest(config.path.images.dest))
    .pipe(browserSync.reload({stream: true}));
});

gulp.task('image_sprite', function () {
  return gulp
    .src(config.path.images.src + 'sprites/**/*.{png,svg}')
    // .pipe(plugins.newer(config.path.images.dest))
    .pipe(plugins.if(
      '*.png',
      plugins.imagemin([
        imageminPngquant(),
        imageminAdvpng(),
      ])
    ))
    .pipe(plugins.if(
      '*.svg',
      plugins.imagemin([
        plugins.imagemin.svgo({
          plugins: [{
            removeViewBox: true
          }]
        })
      ])
    ))
    .pipe(plugins.size({
      showFiles: true,
      title: 'task: image_sprite: '
    }))
    .pipe(gulp.dest(config.path.images.dest + 'sprites/'))
    .pipe(browserSync.reload({stream: true}));
});


gulp.task("image2webp", function() {
  return gulp.src([config.path.images.dest + '**/*.{png,jpg,jpeg}'])
    // .pipe(plugins.newer(config.path.images.dest))
    .pipe(plugins.imagemin([
      imageminWebp({
        quality: 95
      })
    ]))
    .pipe(extReplace(".webp"))
    .pipe(gulp.dest(config.path.images.dest));
});

gulp.task("image2webpContent", function() {
  return gulp.src(config.path.images.srcImgContent + '**/*.{png,jpg,jpeg}')
    // .pipe(plugins.newer(config.path.images.dest))
    .pipe(plugins.imagemin([
      imageminWebp({
        quality: 95
      })
    ]))
    .pipe(extReplace(".webp"))
    .pipe(gulp.dest(config.path.images.srcImgContent));
});

// Copy web fonts to dist
gulp.task('fonts', function () {
  return gulp
    .src(config.path.fonts.src)
    .pipe(plugins.newer(config.path.fonts.dest))
    .pipe(gulp.dest(config.path.fonts.dest))
    .pipe(plugins.size({
      showFiles: true,
      title: 'task:fonts'
    }));
});

// Optimize script
const arr_scripts_0 = [
  'assets/js/cross.transport.js',
  'assets/js/install-app-page.js',
  'assets/js/landing-book.js',
  'assets/js/hosters-simple-carousel.js',
  'assets/js/gform-customs.js'
];
gulp.task('scripts_0', function () {
  return gulp
    .src(arr_scripts_0)
    .pipe(plugins.newer(config.path.scripts.dest))
    .pipe(customPlumber('Error Compiling Scripts'))
    .pipe(plugins.if(!env_prod, plugins.sourcemaps.init()))
    .pipe(plugins.if('*.js', plugins.uglify()))
    .pipe(plugins.if(!env_prod, plugins.sourcemaps.write('maps', {includeContent: true})))
    .pipe(plugins.rename({
      suffix: '.min'
    }))
    .pipe(gulp.dest(config.path.scripts.dest))
    .pipe(plugins.size({
      showFiles: true,
      title: 'task:scripts >>  0'
    }))
    .pipe(browserSync.reload({stream: true}));
});

const arr_scripts_1 = [
  'assets/js/plugins/ejs.js',
  'assets/js/plugins/jquery.lettering.js',
  'assets/js/plugins/freeWall.js',
  'assets/js/plugins/jquery.endpage-box.js'
];
gulp.task('scripts_1', function () {
  return gulp
    .src(arr_scripts_1)
    .pipe(plugins.newer(config.path.scripts.dest))
    .pipe(customPlumber('Error Compiling Scripts'))
    .pipe(plugins.if(!env_prod, plugins.sourcemaps.init()))
    .pipe(plugins.if('*.js', plugins.uglify()))
    .pipe(plugins.if(!env_prod, plugins.sourcemaps.write('maps', {includeContent: true})))
    .pipe(plugins.rename({
      suffix: '.min'
    }))
    .pipe(gulp.dest(config.path.scripts.dest + 'plugins/'))
    .pipe(plugins.size({
      showFiles: true,
      title: 'task:scripts >>  1'
    }))
    .pipe(browserSync.reload({stream: true}));
});

const arr_scripts_2 = [
  'assets/js/template-paas-for-developers.js'
];
gulp.task('scripts_2', function () {
  return gulp
    .src(arr_scripts_2)
    .pipe(plugins.newer(config.path.scripts.dest))
    .pipe(customPlumber('Error Compiling Scripts'))
    .pipe(plugins.if(!env_prod, plugins.sourcemaps.init()))
    .pipe(plugins.if('*.js', plugins.uglify()))
    .pipe(plugins.rename({
      suffix: '.min'
    }))
    .pipe(plugins.if(!env_prod, plugins.sourcemaps.write('maps', {includeContent: true})))
    .pipe(gulp.dest(config.path.scripts.dest))
    .pipe(plugins.size({
      showFiles: true,
      title: 'task:scripts >>  2'
    }))
    .pipe(browserSync.reload({stream: true}));
});

const arr_scripts_3 = [
  'assets/js/plugins/bootstrap/bootstrap.min.js',
  'assets/js/plugins/bootstrap/tooltip.js',
  'assets/js/plugins/bootstrap/popover.js',
  'assets/js/plugins/bootstrap/tab.js',
  'assets/js/plugins/jquery.cookie.js',
  'assets/js/plugins/jPlaceholder.js',
  'assets/js/plugins/userinfo.js',
  'assets/js/plugins/json.js',
  'assets/js/plugins/slick.js',
  'assets/js/vendor/cssrelpreload.js',
  'assets/js/plugins/videoPopUp.jquery.js',
  'assets/js/cross.transport.js',
  'assets/js/JApp.js',
  'assets/js/signin.js',
  'assets/js/init.js',
  'assets/js/subscribe.js',
  'assets/js/signup.js',
  'assets/js/btn-try-it.js'
]
gulp.task('scripts_3', function () {
  return gulp
    .src(arr_scripts_3)
    .pipe(plugins.size({
      showFiles: true,
      title: 'task:scripts >>  3'
    }))
    .pipe(plugins.newer(config.path.scripts.dest))
    .pipe(customPlumber('Error Compiling Scripts'))
    .pipe(plugins.if(!env_prod, plugins.sourcemaps.init()))
    .pipe(plugins.if('*.js', plugins.uglify()))
    .pipe(plugins.concat('app.min.js'))
    .pipe(plugins.if(!env_prod, plugins.sourcemaps.write('maps', {includeContent: true})))
    .pipe(gulp.dest(config.path.scripts.dest))
    .pipe(plugins.size({
      showFiles: true,
      title: 'task:scripts >>  3'
    }))
    .pipe(browserSync.reload({stream: true}));
});

const arr_scripts_4 = [
  'assets/js/plugins/jeCarousel.js',
  'assets/js/plugins/jeMousehold.js',
  'assets/js/hoster.select.js'
];
gulp.task('scripts_4', function () {
  return gulp
    .src(arr_scripts_4)
    .pipe(plugins.newer(config.path.scripts.dest))
    .pipe(customPlumber('Error Compiling Scripts'))
    .pipe(plugins.if(!env_prod, plugins.sourcemaps.init()))
    .pipe(plugins.if('*.js', plugins.uglify()))
    .pipe(plugins.concat('hosters.select.min.js'))
    .pipe(plugins.if(!env_prod, plugins.sourcemaps.write('maps', {includeContent: true})))
    .pipe(gulp.dest(config.path.scripts.dest))
    .pipe(plugins.size({
      showFiles: true,
      title: 'task:scripts >>  4'
    }))
    .pipe(browserSync.reload({stream: true}));
});

const arr_scripts_5 = [
  'assets/js/plugins/jquery.cookie.js',
  'assets/js/headerfooter.js',
];
gulp.task('scripts_5', function () {
  return gulp
    .src(arr_scripts_5)
    .pipe(plugins.newer(config.path.scripts.dest))
    .pipe(customPlumber('Error Compiling Scripts'))
    .pipe(plugins.if(!env_prod, plugins.sourcemaps.init()))
    .pipe(plugins.if('*.js', plugins.uglify()))
    .pipe(plugins.concat('headerfooter.min.js'))
    .pipe(plugins.if(!env_prod, plugins.sourcemaps.write('maps', {includeContent: true})))
    .pipe(gulp.dest(config.path.scripts.dest))
    .pipe(plugins.size({
      showFiles: true,
      title: 'task:scripts >>  5'
    }))
    .pipe(browserSync.reload({stream: true}));
});

const arr_scripts_6 = [
  'assets/js/template-front-page.js',
];
gulp.task('scripts_6', function () {
  return gulp
    .src(arr_scripts_6)
    .pipe(plugins.newer(config.path.scripts.dest))
    .pipe(customPlumber('Error Compiling Scripts'))
    .pipe(plugins.if(!env_prod, plugins.sourcemaps.init()))
    .pipe(plugins.if('*.js', plugins.uglify()))
    .pipe(plugins.concat('template-front-page.min.js'))
    .pipe(plugins.if(!env_prod, plugins.sourcemaps.write('maps', {includeContent: true})))
    .pipe(gulp.dest(config.path.scripts.dest))
    .pipe(plugins.size({
      showFiles: true,
      title: 'task:scripts >>  6'
    }))
    .pipe(browserSync.reload({stream: true}));
});

const arr_scripts_7 = [
  'assets/js/plugins/jquery.imgpreload.min.js',
  'assets/js/hybridCloudAnim.js',
  // 'assets/js/main.js'
];
gulp.task('scripts_7', function () {
  return gulp
    .src(arr_scripts_7)
    .pipe(plugins.newer(config.path.scripts.dest))
    .pipe(customPlumber('Error Compiling Scripts'))
    .pipe(plugins.if(!env_prod, plugins.sourcemaps.init()))
    .pipe(plugins.babel({presets: ['env']}))
    .pipe(plugins.if('*.js', plugins.uglify()))
    .pipe(plugins.concat('main.min.js'))
    .pipe(plugins.if(!env_prod, plugins.sourcemaps.write('maps', {includeContent: true})))
    .pipe(gulp.dest(config.path.scripts.dest))
    .pipe(plugins.size({
      showFiles: true,
      title: 'task:scripts >>  7'
    }))
    .pipe(browserSync.reload({stream: true}));
});

const arr_scripts_8 = [
  'assets/js/template-company-page.js'
];
gulp.task('scripts_8', function () {
  return gulp
    .src(arr_scripts_8)
    .pipe(plugins.newer(config.path.scripts.dest))
    .pipe(customPlumber('Error Compiling Scripts'))
    .pipe(plugins.if(!env_prod, plugins.sourcemaps.init()))
    .pipe(plugins.if('*.js', plugins.uglify()))
    .pipe(plugins.concat('template-company-page.min.js'))
    .pipe(plugins.if(!env_prod, plugins.sourcemaps.write('maps', {includeContent: true})))
    .pipe(gulp.dest(config.path.scripts.dest))
    .pipe(plugins.size({
      showFiles: true,
      title: 'task:scripts >>  8'
    }))
    .pipe(browserSync.reload({stream: true}));
});

const arr_scripts_9 = [
  'assets/js/vendor/easing.js',
  'assets/js/vendor/respond.js',
  'assets/js/vendor/swipe.min.js',
  'assets/js/vendor/sticky.js',
  'assets/js/vendor/jquery.mousewheel.min.js',
  'assets/js/vendor/flexslider.min.js',
  'assets/js/vendor/imagesloaded.js',
  'assets/js/vendor/appear.js',
  'assets/js/vendor/init.js',
  'assets/js/headerfooter.js'
];
gulp.task('scripts_9', function () {
  return gulp
    .src(arr_scripts_9)
    .pipe(plugins.newer(config.path.scripts.dest))
    .pipe(customPlumber('Error Compiling Scripts'))
    .pipe(plugins.if('*.js', plugins.uglify()))
    .pipe(plugins.concat('script.min.js'))
    .pipe(gulp.dest(config.path.scripts.dest))
    .pipe(plugins.size({
      showFiles: true,
      title: 'task:scripts >>  9'
    }))
    .pipe(browserSync.reload({stream: true}));
});

const arr_scripts_10 = [
  'assets/js/plugins/jquery.cookie.js',  // TODO TRASFER JQUERY TO VANILA
  'assets/js/headerfooter.js',  // TODO TRASFER JQUERY TO VANILA
  'assets/js/components/component-to-top.js',  // TODO TRASFER JQUERY TO VANILA
  'assets/js/components/component-youtube-lazy.js',
  'assets/js/components/component-signup-widget.js',
];
gulp.task('scripts_10', function () {
  return gulp
    .src(arr_scripts_10)
    .pipe(plugins.newer(config.path.scripts.dest))
    .pipe(customPlumber('Error Compiling Scripts'))
    .pipe(plugins.babel({
			presets: ['env']
		}))
    .pipe(plugins.if(!env_prod, plugins.sourcemaps.init()))
    .pipe(plugins.if('*.js', plugins.uglify({
      // mangle: true,
      // Not support except
      mangle: {toplevel: true},
      compress: true
      // Not support preserveComments
    })))
    .pipe(plugins.concat('template-newdocker.min.js'))
    .pipe(plugins.if(!env_prod, plugins.sourcemaps.write('maps', {includeContent: true})))
    .pipe(gulp.dest(config.path.scripts.dest))
    .pipe(plugins.filter('**/*.js'))
    .pipe(plugins.size({
      showFiles: true,
      title: 'task:scripts >>  10'
    }))
    .pipe(browserSync.reload({stream: true}));
});

const arr_scripts_11 = [
  // 'assets/js/JApp.js',
  'assets/js/plugins/jquery.cookie.js',  // TODO TRASFER JQUERY TO VANILA
  'assets/js/headerfooter.js',  // TODO TRASFER JQUERY TO VANILA
  'assets/js/components/component-to-top.js',   // TODO TRASFER JQUERY TO VANILA
  'assets/js/components/component-slider-reviews.js',
  'assets/js/components/component-youtube-lazy.js',
  'assets/js/template-enterprise-paas.js',
];
gulp.task('scripts_11', function () {
  return gulp
    .src(arr_scripts_11)
    .pipe(plugins.newer(config.path.scripts.dest))
    .pipe(customPlumber('Error Compiling Scripts'))
    .pipe(plugins.babel({
			presets: ['env']
		}))
    .pipe(plugins.if(!env_prod, plugins.sourcemaps.init()))
    .pipe(plugins.if('*.js', plugins.uglify({
      // mangle: true,
      // Not support except
      mangle: {toplevel: true},
      compress: true
      // Not support preserveComments
    })))
    .pipe(plugins.concat('template-enterprise-paas.min.js'))
    .pipe(plugins.if(!env_prod, plugins.sourcemaps.write('maps', {includeContent: true})))
    .pipe(gulp.dest(config.path.scripts.dest))
    .pipe(plugins.filter('**/*.js'))
    .pipe(plugins.size({
      showFiles: true,
      title: 'task:scripts >>  11'
    }))
    .pipe(browserSync.reload({stream: true}));
});

const arr_scripts_12 = [
  'assets/js/plugins/jquery.cookie.js',  // TODO TRASFER JQUERY TO VANILA
  'assets/js/headerfooter.js',  // TODO TRASFER JQUERY TO VANILA
  'assets/js/components/component-to-top.js',   // TODO TRASFER JQUERY TO VANILA
  'assets/js/components/component-youtube-lazy.js',
  'assets/js/template-auto-scalable.js',
];
gulp.task('scripts_12', function () {
  return gulp
    .src(arr_scripts_12)
    .pipe(plugins.newer(config.path.scripts.dest))
    .pipe(customPlumber('Error Compiling Scripts'))
    .pipe(plugins.babel({
			presets: ['env']
		}))
    .pipe(plugins.if(!env_prod, plugins.sourcemaps.init()))
    .pipe(plugins.if('*.js', plugins.uglify({
      // mangle: true,
      // Not support except
      mangle: {toplevel: true},
      compress: true
      // Not support preserveComments
    })))
    .pipe(plugins.concat('template-auto-scalable.min.js'))
    .pipe(plugins.if(!env_prod, plugins.sourcemaps.write('maps', {includeContent: true})))
    .pipe(gulp.dest(config.path.scripts.dest))
    .pipe(plugins.filter('**/*.js'))
    .pipe(plugins.size({
      showFiles: true,
      title: 'task:scripts >>  12'
    }))
    .pipe(browserSync.reload({stream: true}));
});

const arr_scripts_13 = [
  'assets/js/plugins/jquery.cookie.js',  // TODO TRASFER JQUERY TO VANILA
  'assets/js/headerfooter.js',  // TODO TRASFER JQUERY TO VANILA
  'assets/js/components/component-to-top.js',   // TODO TRASFER JQUERY TO VANILA
  'assets/js/components/component-slider-hosters.js',
  'assets/js/plugins/videoPopUp.jquery.js',   // TODO TRASFER JQUERY TO VANILA
  'assets/js/template-hosting-page.js',   // TODO TRASFER JQUERY TO VANILA
];
gulp.task('scripts_13', function () {
  return gulp
    .src(arr_scripts_13)
    .pipe(plugins.newer(config.path.scripts.dest))
    .pipe(customPlumber('Error Compiling Scripts'))
    .pipe(plugins.babel({
			presets: ['env']
		}))
    .pipe(plugins.if(!env_prod, plugins.sourcemaps.init()))
    .pipe(plugins.if('*.js', plugins.uglify({
      // mangle: true,
      // Not support except
      mangle: {toplevel: true},
      compress: true
      // Not support preserveComments
    })))
    .pipe(plugins.concat('template-hosting-page.min.js'))
    .pipe(plugins.if(!env_prod, plugins.sourcemaps.write('maps', {includeContent: true})))
    .pipe(gulp.dest(config.path.scripts.dest))
    .pipe(plugins.filter('**/*.js'))
    .pipe(plugins.size({
      showFiles: true,
      title: 'task:scripts >>  13'
    }))
    .pipe(browserSync.reload({stream: true}));
});

const arr_scripts_14 = [
  'assets/js/plugins/jquery.cookie.js',  // TODO TRASFER JQUERY TO VANILA
  'assets/js/headerfooter.js',  // TODO TRASFER JQUERY TO VANILA
  'assets/js/components/component-to-top.js',   // TODO TRASFER JQUERY TO VANILA
  'assets/js/components/component-youtube-lazy.js',
  'assets/js/template-kubernetes-cloud-services.js',
];
gulp.task('scripts_14', function () {
  return gulp
    .src(arr_scripts_14)
    .pipe(plugins.newer(config.path.scripts.dest))
    .pipe(customPlumber('Error Compiling Scripts'))
    .pipe(plugins.babel({
			presets: ['env']
		}))
    .pipe(plugins.if(!env_prod, plugins.sourcemaps.init()))
    .pipe(plugins.if('*.js', plugins.uglify({
      // mangle: true,
      // Not support except
      mangle: {toplevel: true},
      compress: true
      // Not support preserveComments
    })))
    .pipe(plugins.concat('template-kubernetes-cloud-services.min.js'))
    .pipe(plugins.if(!env_prod, plugins.sourcemaps.write('maps', {includeContent: true})))
    .pipe(gulp.dest(config.path.scripts.dest))
    .pipe(plugins.filter('**/*.js'))
    .pipe(plugins.size({
      showFiles: true,
      title: 'task:scripts >>  14'
    }))
    .pipe(browserSync.reload({stream: true}));
});

gulp.task('version', function () {
  const today = new Date();
  const version = today.getDate() + today.getHours();
  const file_folder = './wp-content/themes/salient/includes/jelastic/';
  const file = file_folder + './defines.php';
  console.log('New .css and .js version is ' + version);
  return gulp
    .src(file)
    .pipe(customPlumber('Error Changing Site Styles & Scripts Version'))
    .pipe(replace(/(\'J_STYLES_VERSION\',\x20)(.+?)(\);)/g, '$1' + version + ');'))
    .pipe(replace(/(\'J_SCRIPTS_VERSION\',\x20)(.+?)(\);)/g, '$1' + version + ');'))
    .pipe(gulp.dest(file_folder))
});

gulp.task('images', gulp.series(
  'image_copy',
  'image',
  // 'image2webp',
));

gulp.task('less2css', gulp.parallel(
  'less',
  'less_style',
  'less_style_01',
  'template-enterprise-paas',
  'template-newdocker',
  'template-hosting-page',
  'template-auto-scalable-clustering',
  'template-kubernetes-cloud-services',
  'less_headfoot',
));

gulp.task('styles', gulp.series(
  'less2css',
  'style_after',
  'style_after_scss',
  'style_after_disable_zindex',
  'image_sprite',
  'version',
));

gulp.task('scripts', gulp.parallel(
  'scripts_0',
  'scripts_1',
  'scripts_2',
  'scripts_3',
  'scripts_4',
  'scripts_5',
  'scripts_6',
  'scripts_7',
  'scripts_8',
  'scripts_9',
  'scripts_10',
  'scripts_11',
  'scripts_12',
  'scripts_13',
  'scripts_14',
  'version'
));

/* browserSync config */
let args = {
  notify: false,
  port: 9090,
  proxy: config.domain,
  host: config.domain
}

gulp.task('set-dev-node-env', function() {
  return process.env.NODE_ENV = 'development';
});

gulp.task('set-prod-node-env', function() {
  return process.env.NODE_ENV = 'production';
});

gulp.task('default', gulp.parallel(
  gulp.series(
    // 'set-prod-node-env',
    'styles',
    'images'
  ),
  // 'image2webpContent', // tempolary disable it
  'scripts',
  'fonts',
));

gulp.task('build', gulp.parallel(
  gulp.series(
    // 'set-prod-node-env',
    'styles',
    'images'
  ),
  'image2webp', // tempolary disable it
  'image2webpContent', // tempolary disable it
  'scripts',
  'fonts',
));


// watch for changes
gulp.task('watch', function() {

  gulp.series(
    'set-dev-node-env',
  );

  browserSync.init(args);

  gulp.watch(config.path.base.desthtml).on('change', browserSync.reload);

  gulp.watch('assets/scss/template-newdocker.scss', gulp.series('template-newdocker', 'style_after_scss'));

  gulp.watch('assets/scss/template-enterprise-paas.scss', gulp.series('template-enterprise-paas', 'style_after_scss'));

  gulp.watch('assets/scss/template-auto-scalable-clustering.scss', gulp.series('template-auto-scalable-clustering', 'style_after_scss'));

  gulp.watch('assets/scss/template-kubernetes-cloud-services.scss', gulp.series('template-kubernetes-cloud-services', 'style_after_scss'));

  gulp.watch('assets/scss/template-pay-as-you-use-new-gen.scss', gulp.series('template-pay-as-you-use-new-gen', 'style_after_scss'));

  gulp.watch('assets/scss/template-hosting-page.scss', gulp.series('template-hosting-page', 'style_after_scss'));

  gulp.watch(arr_less, gulp.series('less', 'style_after', 'style_after_scss'));

  gulp.watch(arr_less_headfoot, gulp.series('less_headfoot', 'style_after', 'style_after_scss'));

  gulp.watch(arr_less_style, gulp.series('less_style', 'style_after', 'style_after_scss'));

  gulp.watch(arr_less_style_01, gulp.series('less_style_01', 'style_after', 'style_after_scss'));

  // gulp.watch(config.path.styles.dest + '**/*.css', gulp.series('style_after', 'style_after_scss'));

  gulp.watch(config.path.images.srcimgNew, gulp.series('image_copy'));

  gulp.watch(config.path.images.srcimg, gulp.series('image'));

  gulp.watch(config.path.images.src + 'sprites/**/*.{png,svg}', gulp.series('image_sprite', 'style_after', 'style_after_scss'));

  gulp.watch(arr_scripts_0, gulp.series('scripts_0'));

  gulp.watch(arr_scripts_1, gulp.series('scripts_1'));

  gulp.watch(arr_scripts_2, gulp.series('scripts_2'));

  gulp.watch(arr_scripts_3, gulp.series('scripts_3'));

  gulp.watch(arr_scripts_4, gulp.series('scripts_4'));

  gulp.watch(arr_scripts_5, gulp.series('scripts_5'));

  gulp.watch(arr_scripts_6, gulp.series('scripts_6'));

  gulp.watch(arr_scripts_7, gulp.series('scripts_7'));

  gulp.watch(arr_scripts_8, gulp.series('scripts_8'));

  gulp.watch(arr_scripts_9, gulp.series('scripts_9'));

  gulp.watch(arr_scripts_10, gulp.series('scripts_10'));

  gulp.watch(arr_scripts_11, gulp.series('scripts_11'));

  gulp.watch(arr_scripts_12, gulp.series('scripts_12'));

  gulp.watch(arr_scripts_13, gulp.series('scripts_13'));

  gulp.watch(arr_scripts_14, gulp.series('scripts_14'));
  // gulp.watch(config.path.scripts.src, gulp.series('scripts'));

});



// watch for changes
gulp.task('watch-docker', function() {

  let env_prod = true;

  browserSync.init(args);

  gulp.watch(config.path.base.desthtml).on('change', browserSync.reload);

  gulp.watch('assets/scss/template-newdocker.scss', gulp.series('template-newdocker'));

  gulp.watch(config.path.styles.dest + '**/*.css', gulp.series('style_after', 'style_after_scss', 'style_after_disable_zindex'));


  gulp.watch(config.path.images.src + 'sprites/**/*.{png,svg}', gulp.series('image_sprite'));

  gulp.watch(arr_scripts_10, gulp.series('scripts_10'));

  gulp.watch(arr_scripts_11, gulp.series('scripts_11'));

  gulp.watch(arr_scripts_12, gulp.series('scripts_12'));

  gulp.watch(arr_scripts_13, gulp.series('scripts_13'));

  gulp.watch(arr_scripts_14, gulp.series('scripts_14'));
  // gulp.watch(config.path.scripts.src, gulp.series('scripts'));

});


// Custom Plumber function for catching errors
function customPlumber(errTitle) {
  return plugins.plumber({
    errorHandler: plugins.notify.onError({
      // Customizing error title
      title: errTitle || 'Error running Gulp',
      message: 'Error: <%= error.message %>',
      sound: 'Bottle'
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
