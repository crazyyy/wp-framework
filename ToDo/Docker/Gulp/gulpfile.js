'use strict';

/* set theme name and srcs */
const themename = 'pente';
const assets_src = '../wp-content/themes/' + themename + '/assets/';
// const assets_src = '../assets/';
const scsssrc = assets_src;
const assetssrc = assets_src;
const destsrc = assets_src;
/* import dependencies */
// import gulp from 'gulp';
// import cleanCSS from 'gulp-clean-css';
var gulp = require('gulp');
var cleanCSS = require('gulp-clean-css');

const plugins = require('gulp-load-plugins')({
    pattern: ['gulp-*', 'gulp.*'],
    replaceString: /\bgulp[\-.]/
});

gulp.task('cssminify', function () {
    let source = scsssrc + 'scss/**/*.scss',
        destination = destsrc + 'css/';
    return gulp.src(source)
        .pipe(customPlumber('Error Running Sass'))
        .pipe(plugins.newer(destination))
        .pipe(plugins.sourcemaps.init())
        .pipe(plugins.sass({
            outputStyle: 'compact',
            precision: 5,
            onError: console.error.bind(console, 'Sass error:')
        }))
        .pipe(plugins.autoprefixer('last 3 version'))
        .pipe(cleanCSS())
        .pipe(plugins.rename({extname: '.min.css'}))
        .pipe(plugins.sourcemaps.write('./', {includeContent: false, sourceRoot: destination}))
        .pipe(gulp.dest(destination))
        .pipe(plugins.filter('**/*.min.css'))
        .pipe(plugins.size({
            showFiles: true,
            title: 'task: minifyCSS'
        }))
});

// Optimize script
gulp.task('scripts', function () {
    let source = assetssrc + 'js/**/!(*.min).js',
        destination = destsrc + 'js/',
        condition = destsrc + 'js/**/*.min.js';
    return gulp.src(source)
        .pipe(customPlumber('Error Running Scripts'))
        // .pipe(plugins.ignore.exclude( condition ))
        .pipe(plugins.newer(condition))
        .pipe(customPlumber('Error Compiling Scripts'))
        .pipe(plugins.sourcemaps.init())
        .pipe(plugins.terser())
        .pipe(plugins.rename({extname: '.min.js'}))
        .pipe(plugins.sourcemaps.write('./', {includeContent: false, sourceRoot: destination}))
        .pipe(gulp.dest(destination))
        .pipe(plugins.filter('**/*.min.js'))
        .pipe(plugins.size({
            showFiles: true,
            title: 'task: scripts'
        }))
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
}

module.exports = customPlumber;

// watch for changes
gulp.task('watch', function () {
    gulp.watch(scsssrc + 'scss/**/*.scss', gulp.series('cssminify'));
    gulp.watch(assetssrc + 'js/**/!(*.min).js', gulp.series('scripts'));
});

// Consolidated dev phase task
gulp.task('serve', gulp.series('cssminify', 'scripts', 'watch'));
