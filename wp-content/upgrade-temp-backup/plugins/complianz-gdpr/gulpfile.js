const gulp = require('gulp');
const rtlcss = require('gulp-rtlcss');
const concat = require('gulp-concat');
const cssbeautify = require('gulp-cssbeautify');
const cssuglify = require('gulp-uglifycss');
const jsuglify = require('gulp-uglify');
const sass = require('gulp-sass')(require('sass'));
const spawn = require('child_process').spawn;

/**
 * Watches for changes in specific JavaScript and SCSS files and triggers the corresponding build tasks.
 * Also starts an npm process in the 'settings' directory.
 *
 */
function defaultTask(cb) {
	gulp.watch('./assets/css/document.scss', { ignoreInitial: false }, buildCssDocument);
	// Watch for changes in 'document-grid.scss' and run 'buildCssDocumentGrid' task
	gulp.watch('./assets/css/document-grid.scss', { ignoreInitial: false }, buildCssDocumentGrid);
	// Watch for changes in 'admin.scss' and run 'buildCssAdmin' task
	gulp.watch('./assets/css/admin.scss', { ignoreInitial: false }, buildCssAdmin);
	// Watch for changes in 'cookieblocker.scss' and run 'buildCssCookieblocker' task
	gulp.watch('./assets/css/cookieblocker.scss', { ignoreInitial: false }, buildCssCookieblocker);
	// Watch for changes in JavaScript files in the 'cookiebanner/js' directory and run 'buildJsCookiebanner' task
	gulp.watch('./cookiebanner/js/complianz.js', { ignoreInitial: false }, buildJsCookiebanner);
	// Watch for changes in 'document.scss' and run 'buildCssDocument' task
	// Start an npm process in the 'settings' directory
	// spawn('npm', ['start'], { cwd: 'settings', stdio: 'inherit' });
	// Signal completion
	cb();
}
exports.default = defaultTask

/**
 * Builds the Cookiebanner JavaScript files by concatenating and minifying them.
 *
 */
function buildJsCookiebanner() {
	return gulp.src('cookiebanner/js/complianz.js')
		.pipe(concat('complianz.min.js'))
		.pipe(jsuglify())
		.pipe(gulp.dest('./cookiebanner/js')); // Final output for minified version
}
exports['build:js:cookiebanner'] = buildJsCookiebanner;

/**
 * Builds all JavaScript files by running the specified tasks in series.
 *
 */
function buildJsAll(cb) {
	return gulp.series(
		buildJsCookiebanner
	)(cb);
}
exports['build:js:all'] = buildJsAll;

/**
 * Builds all CSS files by running the specified tasks in series.
 *
 */
function buildCssAll(cb) {
	return gulp.series(
		buildCssDocument,
		buildCssDocumentGrid,
		buildCssAdmin,
		buildCssCookieblocker,
	)(cb);
}
exports['build:css:all'] = buildCssAll;

/**
 * Builds the Document CSS by compiling SCSS to CSS, beautifying, minifying.
 *
 */
function buildCssDocument() {
	return 	gulp.src('./assets/css/document.scss')
		.pipe(sass(({outputStyle: 'expanded'})).on('error', sass.logError))
		.pipe(cssbeautify()) // Beautify the CSS
		.pipe(gulp.dest('./assets/css'))
		.pipe(cssuglify()) // Minify the CSS
		.pipe(concat('document.min.css'))
		.pipe(gulp.dest('./assets/css'));
}
exports['build:css:document'] = buildCssDocument;

/**
 * Builds the DocumentGrid CSS by compiling SCSS to CSS, beautifying, minifying.
 *
 */
function buildCssDocumentGrid() {
	return 	gulp.src('./assets/css/document-grid.scss')
		.pipe(sass(({outputStyle: 'expanded'})).on('error', sass.logError))
		.pipe(cssbeautify()) // Beautify the CSS
		.pipe(gulp.dest('./assets/css'))
		.pipe(cssuglify()) // Minify the CSS
		.pipe(concat('document-grid.min.css'))
		.pipe(gulp.dest('./assets/css'));
}
exports['build:css:document-grid'] = buildCssDocumentGrid;

/**
 * Builds the Admin CSS by compiling SCSS to CSS, beautifying, minifying, and generating RTL CSS.
 *
 */
function buildCssAdmin() {
	return 	gulp.src('./assets/css/admin.scss')
		.pipe(sass(({outputStyle: 'expanded'})).on('error', sass.logError))
		.pipe(cssbeautify()) // Beautify the CSS
		.pipe(gulp.dest('./assets/css'))
		.pipe(cssuglify()) // Minify the CSS
		.pipe(concat('admin.min.css'))
		.pipe(gulp.dest('./assets/css'))
		.pipe(rtlcss())
		.pipe(gulp.dest('./assets/css/rtl'));
}
exports['build:css:admin'] = buildCssAdmin;

/**
 * Builds the Cookieblocker CSS by compiling SCSS to CSS, beautifying, minifying.
 *
 */
function buildCssCookieblocker() {

	return 	gulp.src('./assets/css/cookieblocker.scss')
		.pipe(sass(({outputStyle: 'expanded'})).on('error', sass.logError))
		.pipe(cssbeautify()) // Beautify the CSS
		.pipe(gulp.dest('./assets/css'))
		.pipe(cssuglify()) // Minify the CSS
		.pipe(concat('cookieblocker.min.css'))
		.pipe(gulp.dest('./assets/css'));
}
exports['build:css:cookieblocker'] = buildCssCookieblocker;