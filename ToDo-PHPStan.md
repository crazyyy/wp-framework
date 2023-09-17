# Optimize the code

https://gist.github.com/Ruzgfpegk/4fd666180e40bb8a0e0608ad35fb5a88

You probably inherited a theme made by someone else.

This someone else was probably paid way better than you, for a horrible result.

Use the feedback provided by your IDE (Eclipse, PhpStorm, …) and/or pipeline tools (PHPCS, PHPMD, …).

Some may find it bad practice, but I prefer to set such tools locally as global packages for Composer: (after installing Composer) (Windows)

Here's my own usual list of packages typically used with WordPress projects, for reference:

composer global require squizlabs/php_codesniffer
composer global require automattic/phpcs-neutron-standard
composer global require automattic/phpcs-neutron-ruleset
composer global require dealerdirect/phpcodesniffer-composer-installer
composer global require phpmd/phpmd
composer global require phpstan/phpstan
composer global require szepeviktor/phpstan-wordpress
composer global require php-stubs/woocommerce-stubs
Packages with then be stored in your local user folder (for Windows: %APPDATA%\Composer\vendor).

And don't forget to update both Composer and the packages from time to time:

composer global self-update
composer global update --optimize-autoloader
Here's a sample PHPStan configuration file for WordPress you'd need to place at the root of your project (its default name being phpstan.neon), once the dependencies above are installed (%rootDir% below being the root folder of PHPStan, like "/path/to/vendor/phpstan/phpstan"):

includes:
- phar://phpstan.phar/conf/bleedingEdge.neon
- %rootDir%/../../szepeviktor/phpstan-wordpress/extension.neon

parameters:
level: max
inferPrivatePropertyTypeFromConstructor: true
parallel:
maximumNumberOfProcesses: 4

scanDirectories:
- DocumentRoot/wp-content/themes/parent_theme_if_there_is_one
- DocumentRoot/wp-content/plugins/plugin_used_by_the_theme

paths:
- DocumentRoot/wp-content/themes/theme_to_check

ignoreErrors:
- '#^Function apply_filters(_ref_array)? invoked with [34567] parameters, 2 required\.$#'

bootstrapFiles:
# php-stubs/wordpress-stubs/wordpress-stubs.php is already loaded by szepeviktor/phpstan-wordpress
# Uncomment the following as needed:
#- %rootDir%/../../php-stubs/woocommerce-stubs/woocommerce-stubs.php
#- %rootDir%/../../php-stubs/woocommerce-stubs/woocommerce-packages-stubs.php

excludes_analyse:
#- DocumentRoot/wp-content/themes/theme_to_check/folder_to_ignore
You'd then launch the analyze from the console at the root of your folder by typing:

> phpstan analyse
For JetBrains IDE users, the plugin Php Inspections (EA Extended) or its paid variant Php Inspections (EA Ultimate) can help a lot, on top of other inspectors, to clean up the code, for instance locating cases of

for(
$i = 0;
$i <= slow_function_called_every_time_for_the_same_result();
$i++) { stuff(); }
and helping you turn them into this:

$target = slow_function_only_called_once();
for( $i = 0; $i <= $target; $i++) { stuff(); }
The static analyzers PHPStan and Psalm are supported natively in PhpStorm 2020.3 and up (Psalm also has WordPress support).

If the website got slower with time, there are chances that there's a weird O(n^2) loop somewhere.

Beware of multilingual plugins like qTranslate X (which is abandoned by the way), especially when used in conjunction with search tools.

Get a decent knowledge of the various WordPress functions, are they can be used in completely backwards ways by people who don't read the docs beyond the first result.

Limit function calls: if functions like get_stylesheet_directory_uri() are called at each resource path in a page, put their values in variables and use those instead. You could declare them in functions.php and set them as global:

global $templateDirectoryUri, $stylesheetDirectoryUri;
$templateDirectoryUri   = get_template_directory_uri();   // Parent theme path if applicable, "normal" if not
$stylesheetDirectoryUri = get_stylesheet_directory_uri(); // Child theme path if applicable, "normal" if not
And then in other theme files:

<?php
global $templateDirectoryUri, $stylesheetDirectoryUri;
?>
<!-- [...] -->
<meta name="thumbnail" content="<?= $stylesheetDirectoryUri ?>/images/thumbnail-top.jpg" />
PHP: The Right Way is a good resource on how to produce "modern" PHP, and if you delve in more serious coding (especially when writing plugins) it may be a good idea to brush up on your Design Patterns knowledge with DesignPatternsPHP.

You can also check the compliance of your theme against current WordPress standards by using the Theme Check plugin.

Xdebug
If you need to troubleshoot performance issues or application bugs, install Xdebug on a server (preferably a test or development one) and set it up.

As always, read the docs. You may need to learn how to use it from inside your IDE.

My own usual settings for Xdebug v2 are:

zend_extension = xdebug.so
xdebug.remote_enable = On
xdebug.remote_port = 9000
xdebug.profiler_enable = off
xdebug.profiler_enable_trigger = On
xdebug.profiler_enable_trigger_value = YOUR_OWN_PROFILE_TRIGGER
xdebug.profiler_output_name = cachegrind.out.%t.%p
xdebug.profiler_output_dir = "/tmp"
xdebug.trace_enable_trigger = On
xdebug.trace_enable_trigger_value = YOUR_OWN_TRACE_TRIGGER
xdebug.trace_output_name = trace.%H.%p
xdebug.trace_output_dir = "/tmp"
xdebug.show_local_vars = 0
Which translates in Xdebug v3 as (see the upgrade guide):

zend_extension = xdebug
xdebug.mode = profile,trace
xdebug.start_with_request = trigger
xdebug.trigger_value = "YOUR_OWN_TRIGGER"
xdebug.output_dir = "/tmp"
xdebug.client_port = 9003
xdebug.profiler_output_name = cachegrind.out.%t.%p
xdebug.trace_output_name = trace.%H.%p
xdebug.show_local_vars = 0
Combine it with XDebug Helper for Firefox or for Chrome, generate a trace and/or a profile, and analyze them.

A profile will lead you to the parts of the code taking the most time to execute (or being executed the most), and the trace will list everything that's being done for one query.

It may take time, but you can find some weird shit through this process.

The PhpStorm IDE is a good tool to analyze a profiling session, but it's not the only one.

Note that PhpStorm can be integrated with XDebug for real-time debugging if you're tired of using var_dump().

To examine traces made by XDebug, the cross-platform xdebug-trace-viewer tool can be used (you just have to use xdebug.trace_format=1).
