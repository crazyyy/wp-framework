/**
 * WordPress Gulp.js Critical Path CSS Generator
 *
 * This controller file manages Gulp.js tasks for the Critical CSS Generator.
 *
 * @package    abovethefold
 * @subpackage abovethefold/modules/critical-css-build-tool
 * @author     PageSpeed.pro <info@pagespeed.pro>
 */
'use strict';

var gulp = require('gulp');
var plugins = require('gulp-load-plugins')();
plugins.fs = require("fs");
plugins.es = require('event-stream');

/**
 * critical css generator
 * @link https://github.com/addyosmani/critical
 */
var critical = require('critical');

var criticalTasks = [];
plugins.fs.readdirSync('./').forEach(function (file) {
    if (file.indexOf('critical-') === 0 && plugins.fs.lstatSync('./'+file+'/').isDirectory()) {

        var taskFile = './'+file+'/gulp-critical-task.js';
        if (!plugins.fs.existsSync(taskFile)) {
            return;
        }

        // create critical task
        gulp.task(file, require(taskFile)(gulp, plugins, critical));

        // Try to include task
        criticalTasks.push(file);
    }
});

/**
 * Clean output directories
 */
gulp.task('clean', function () {
    return gulp.src(['critical-*/output'], { read: false })
        .pipe(plugins.clean());
});

/**
 * Print available Critical CSS tasks
 */
gulp.task('default', function () {

    console.log('\n' + plugins.util.colors.bold.yellow('Available Critical CSS Tasks:') + '\n');

    if (criticalTasks.length === 0) {
        console.log(plugins.util.colors.red('No critical CSS tasks available.'));
    } else {
        criticalTasks.forEach(function(taskName) {
            console.log(' ➤ ' + plugins.util.colors.bold.magenta(taskName));
        });
    }

    console.log('\nUsage:', plugins.util.colors.bold('gulp'), plugins.util.colors.bold.magenta('critical-task-name'),'\n');

});
