"use strict";

var gulp = require('gulp'),
  changed = require('gulp-changed'),
  gulpif = require('gulp-if'),
  imagemin = require('gulp-imagemin'),
  pngquant = require('imagemin-pngquant'),
  size = require('gulp-size'),
  notifier = require('../helpers/notifier'),
  finder = require('../helpers/finder'),
  config = require('../config').images;

gulp.task('images', function(cb) {

  gulp.src(finder(config.src))
    .pipe(gulpif(devBuild, changed(config.dest)))
    .pipe(imagemin(config.imagemin))
    .pipe(size({showFiles: true, title: 'task:images'}))
    .pipe(gulp.dest(config.dest))
    .on('end', function() {
      notifier('images');
      cb();
    });

});
