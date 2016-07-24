"use strict";

var gulp = require('gulp'),
  del = require('del'),
  config = require('../config').clean;

gulp.task('clean', function(cb) {

  del([].concat(
      config._public_js + '**/*',
      config._public_img + '**/*',
      config._public_css + '**/*',
      config._public_fonts + '**/*'
    ),
    cb
  );

});
