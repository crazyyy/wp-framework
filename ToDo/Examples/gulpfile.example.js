import gulp from 'gulp';
const { src, dest, watch, series } = gulp;
import dartSass from 'sass';
import gulpSass from 'gulp-sass';
const sass = gulpSass(dartSass);
import prefix from 'gulp-autoprefixer';
import minify from 'gulp-clean-css';
import terser from 'gulp-terser';
import imagemin from 'gulp-imagemin';
import imagewebp from 'gulp-webp';

https://stackoverflow.com/questions/69862766/getting-error-err-require-esm-while-running-gulp-command
https://gist.github.com/noraj/007a943dc781dc8dd3198a29205bae04
https://bobbyhadz.com/blog/javascript-gulp-error-err-require-esm-of-es-module