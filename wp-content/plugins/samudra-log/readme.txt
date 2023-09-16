=== Samudra Log ===
Contributors: wakamin
Donate link: https://paypal.me/wakamin
Tags: logging, debugging
Requires at least: 4.7
Tested up to: 5.7
Stable tag: 1.0.2
Requires PHP: 7.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Write log for debugging Wordpress site.

== Description ==

## How to Use?
Use this function to write log.
`
// Variable value can be string, array, or object
$variable = 'Variable value';

// Log file will be in /wp-content/plugins/samudra-log/log/sd_log.log
sd_log($variable);

// Log file will be in /wp-content/plugins/samudra-log/log/my-file.log
sd_log($variable, 'my-file');
`

## Restrict direct access to log file
If you are using Nginx, put this code inside your server block.
`
location ~ /wp-content/plugins/samudra-log/log/.*\.log$ {
    deny all;
    return 404;
}
`

== Frequently Asked Questions ==

= Why not just use WP_DEBUG_LOG? =

WP_DEBUG_LOG write file into wp-content/debug.log. In this file it also contain any error logs.
This plugin make it easy to see specific logging that we want. And adding custom logging file also easy with sd_log($var, 'file-name'). 

== Screenshots ==

1. Plugin settings page.

== Changelog ==

= 1.0.2 =
* Support Wordpress 5.7.2.

= 1.0.1 =
* Support Wordpress 5.5.1.

= 1.0.0 =
* Initial release.

== Upgrade Notice ==

= 1.0.2 =
* Support Wordpress 5.7.2.

= 1.0.1 =
* Support Wordpress 5.5.1.

= 1.0.0 =
Initial release.