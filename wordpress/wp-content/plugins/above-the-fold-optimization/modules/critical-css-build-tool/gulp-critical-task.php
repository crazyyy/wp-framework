<?php

/**
 * Gulp.js Critical CSS Task
 *
 * This template creates gulp-critical-task.js.
 *
 * @since      2.6.0
 * @package    abovethefold
 * @subpackage abovethefold/modules/critical-css-build-tool
 * @author     PageSpeed.pro <info@pagespeed.pro>
 */

// load into output buffer
ob_start();

if (defined('JSON_PRETTY_PRINT')) {
	$encodeflag = JSON_PRETTY_PRINT;
} else {
	$encodeflag = true;
}
$cssfilejson = json_encode($taskjs_cssfiles,$encodeflag);
$criticalcss_dir = $this->CTRL->theme_path( 'critical-css' );

$width = 1300;
$height = 900;
$dimensions = false;

if (isset($settings['dimensions']) && !empty($settings['dimensions'])) {

	// single dimension
	if (count($settings['dimensions']) === 1) {
		$width = intval($settings['dimensions'][0][0]);
		$height = intval($settings['dimensions'][0][1]);
	} else {

		$dimensions = array();
		foreach ($settings['dimensions'] as $dim) {
			$dimensions[] = array(
				'width' => intval($dim[0]),
				'height' => intval($dim[1])
			);
		}
	}
}
?>
/**
 * WordPress Gulp.js Critical CSS Task Package
 *
 * This file contains a task to create critical path CSS.
<?php
	if ($settings['update']) {
		print " *\n * @warning This task automatically updates WordPress Critical CSS.\n";
		if ($settings['update']) {
			print " * @criticalcss ".$settings['update']."\n";
		}
	}
?>
 *
 * @package    abovethefold
 * @subpackage abovethefold/modules/critical-css-build-tool
 * @author     PageSpeed.pro <info@pagespeed.pro>
 */
module.exports = function (gulp, plugins, critical) {
    return function (cb) {

    	var taskname = <?php print json_encode($taskname); ?>;
    	var taskpath = taskname + '/';

    	// check if html file exists in package
    	if (!plugins.fs.existsSync(taskpath + 'page.html')) {
    		throw new Error('page.html does not exist in package');
            return false;
        }

    	// check if full css file exists in package
    	if (!plugins.fs.existsSync(taskpath + 'full.css')) {
    		throw new Error('full.css does not exist in package');
            return false;
        }

        var extraCSS = false;

    	// check if extra css file exists in package
    	if (plugins.fs.existsSync(taskpath + 'extra.css')) {
    		extraCSS = true;
        }

<?php
	if ($settings['update']) {
?>
		// check if css file exists in package
    	if (plugins.fs.existsSync('css/' + <?php print json_encode($settings['update']); ?>)) {

    		// extract config comment to preserve on auto update
    		var csscontent = plugins.fs.readFileSync('css/' + <?php print json_encode($settings['update']); ?>, 'utf-8');
			var match = csscontent.match(/\/\*\*(.|\n)+?\*\//g);
			if (!match || !match[0]) {
				throw new Error(<?php print json_encode($settings['update']); ?> + ' does not contain a valid config header.');
            	return false;
			}
    		var configheader = match[0] + '\n';
        } else {
        	var configheader = '/*\n * '+<?php print json_encode($settings['update']); ?>+'\n */\n';
        }
<?php
	}
?>

        // optimization tasks
        var TASKS = {};

        // Clean output directory
        TASKS['clean'] = function() {
        	return new Promise(function(resolve, reject) {

				console.log('\nCleaning output directory', plugins.util.colors.red.bold('/'+taskpath+'output/'),'...');

				gulp.src([taskpath + 'output'], { read: false })
        			.pipe(plugins.clean())
					.on('error', reject)
					.on('data', function () {}) 
					.on('end', resolve);

			});
        };

        // create citical CSS
        TASKS['critical'] = function() {

        	console.log('\n' + plugins.util.colors.yellow.bold('Creating <?php if ($settings['update'] && $settings['update'] !== 'global.css') { print 'Conditional '; } ?>Critical Path CSS...'));

			/**
	    	 * Perform critical CSS generation
	    	 * @link https://github.com/addyosmani/critical
	    	 */
	    	return critical.generate({
		        inline: false, // generate
		        base: taskpath ,
		        src: 'page.html',
		        dest: 'output/critical.css',
		        minify: false,
				css: <?php print str_replace('"TASKPATH','taskpath + "',$cssfilejson); ?>,
				extract: false,
<?php
	if ($dimensions) {
		print '				dimensions: ' . json_encode($dimensions,$encodeflag) . ",\n";
	} else {
		print '				width: 1300,
				height: 900,' . "\n";
	}
?>
				pathPrefix: '../../../../', // wordpress root from /themes/THEME-NAME/abovethefold/
				timeout: 120000
		    });
        };

        // concatenate extra.css
        TASKS['concat'] = function() {
			return new Promise(function(resolve, reject) {

				if (!extraCSS) {
					resolve();
					return;
				}

				console.log(plugins.util.colors.white.bold(' ➤ Append extra.css to critical.css...'));

				// append extra.css
				gulp.src([taskpath + 'output/critical.css', taskpath + 'extra.css'])
				    .pipe(plugins.concat('critical+extra.css'))
			        .pipe(gulp.dest(taskpath + 'output'))
	    			.on('error', reject)
			        .on('end', resolve);

			});
        };

        // minify
        TASKS['minify'] = function() {
        	return new Promise(function(resolve, reject) {

				console.log(plugins.util.colors.white.bold(' ➤ Minify critical CSS...'));

				// append extra.css
				gulp.src(['!*.min.css',taskpath + 'output/*.css'])
					.pipe(plugins.cssmin({
			            "keepSpecialComments": false,
			            "advanced": true,
			            "aggressiveMerging": true,
			            "showLog": true
					}))<?php if ($settings['update']) {
						print '.pipe(plugins.header(configheader))';
					} ?>
    				.pipe(plugins.rename({ suffix: '.min' }))
			        .pipe(gulp.dest(taskpath + 'output/'))
	    			.on('error', reject)
			        .on('end', resolve);
			})
        };

        // copy critical-css to storage location
        TASKS['copy'] = function() {
			return new Promise(function(resolve, reject) {

<?php
	if (!$settings['update']) {
		print 'resolve();';
	} else {

		$filename = $settings['update'];

		// default 664
		$permissions = array(
            'owner' => array(
                'read' => true,
                'write' => true,
                'execute' => false
            ),
            'group' => array(
                'read' => true,
                'write' => true,
                'execute' => false
            ),
            'others' => array(
                'read' => true,
                'write' => false,
                'execute' => false
            )
        ); 

		$chmodfile = ( ! defined('FS_CHMOD_FILE') ) ? intval( substr(sprintf('%o', fileperms( ABSPATH . 'index.php' )),-4), 8 ) : FS_CHMOD_FILE;
		$chmod = (string)decoct($chmodfile);
		if (strlen($chmod) === 3) {

			$chmodparts = str_split($chmod);
			$perm_user = intval($chmodparts[0]);
			$perm_group = intval($chmodparts[1]);
			$perm_others = intval($chmodparts[2]);

			if ($perm_user === 7) {
				$permissions['owner']['execute'] = true;
			}
			if ($perm_group === 7) {
				$permissions['group']['execute'] = true;
			}
			if ($perm_others === 7) {
				$permissions['others']['execute'] = true;
			}
			if ($perm_others <= 4 && $perm_others !== 2) {
				$permissions['others']['write'] = false;
			}
			if ($perm_others === 0) {
				$permissions['others']['read'] = false;
			}
		}

?>
				console.log('\n' + plugins.util.colors.green.bold('Update <?php if ($settings['update'] !== 'global.css') { print 'Conditional '; } ?>Critical CSS storage file...'));
				console.log(' ➤ ' + plugins.util.colors.green('/abovethefold/css/<?php print $filename; ?>'));

				// append extra.css
				gulp.src([taskpath + 'output/critical.min.css'])
    				.pipe(plugins.rename('<?php print $filename; ?>'))
    				.pipe(plugins.chmod(<?php print json_encode($permissions,$encodeflag); ?>)) // WordPress permissions
    				.pipe(plugins.chown(<?php print (string) getmyuid() . "," . (string) getmygid(); ?>)) // set to PHP user
			        .pipe(gulp.dest('css'))
			        .pipe(plugins.es.map(function(file, callback) {
		                plugins.fs.chown(file.path, file.stat.uid, file.stat.gid, callback);
		            }))
	    			.on('error', reject)
			        .on('end', resolve);
<?php
	}
?>
			});

        };

        // print size
        TASKS['size'] = function() {
        	return new Promise(function(resolve, reject) {

				console.log('\nCritical CSS processor completed successfully.<?php
	if (!$settings['update']) {
		print ' The critical CSS files are located in /'.$taskname.'/output/';
	} 
?>');

				gulp.src(taskpath + 'output/*')
	    			.pipe(plugins.size( { showFiles: true } ))
	    			.on('error', reject)
			        .on('end', resolve)
			        .pipe(gulp.dest('output', { overwrite: false } ));
			});
        };

        // process optimization tasks
        TASKS['clean']()
        	.then(function() {
	        	return TASKS['critical']()
	        }).then(function() {
	        	return TASKS['concat']()
	        }).then(function() {
	        	return TASKS['minify']()
			}).then(function() {
	        	return TASKS['copy']()
			}).then(function() {
	        	return TASKS['size']()
			}).then(
        		function() {
					cb();
				}
        	);

    };
};
<?php

// load js
$taskjs = ob_get_clean();