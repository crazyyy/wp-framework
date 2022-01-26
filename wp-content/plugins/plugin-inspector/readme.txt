=== Plugin Inspector ===
Contributors: gioni
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=SR8RJXFU35EW8
Tags: check, checker, test, inspect, debug, debugging, plugin check, developer, development, vulnerability, vulnerabilities, scan, scanner, security
Requires at least: 3.3
Tested up to: 4.7
Stable tag: 1.5
License: GPLv2

Checks plugins for deprecated WordPress functions, known security vulnerabilities and some unsafe PHP functions

== Description ==

The Plugin Inspector plugin is an easy way to check plugins installed on your WordPress and make sure that plugins do not use deprecated WordPress functions and some unsafe functions like eval, base64_decode, system, exec, etc. Some of those functions may be used to load malicious code (malware) from the external source directly to the site or WordPress database.

**Features**

* Scans plugins for deprecated WordPress functions
* Scans plugins for unsafe functions like eval, base64_decode, system, exec, etc.
* Checks plugins to find vulnerabilities listed in WPScan Vulnerability Database
* Beautiful source code viewer with highlighting

Plugin Inspector allows you to view all the deprecated functions complete with path, line number, deprecation function name, and the new recommended function to use. The checks are run through a simple admin page and all results are displayed at once. This is very handy for plugin developers or anybody who want to know more about installed plugins.

All code that uses the deprecated functions should be converted to use its replacement if one exists. Because deprecated functions are no longer supported may be removed from future versions of WordPress.

To check the theme files, please, use Theme Check plugin.

**Another reliable plugins from trusted author**

* [Protect sites with Cerber Security plugin](https://wordpress.org/plugins/wp-cerber/)

Protects site against brute force attacks. Restrict login by IP access lists. Limit login attempts. Comprehensive control of user activity.

* [Translate sites with Google Translate Widget](https://wordpress.org/plugins/goo-translate-widget/)

Make your website instantly available in 90+ languages with Google Translate Widget. Add the power of Google automatic translations with one click.

== Installation ==

1. Upload the Plugin Inspector folder to the plugins directory in your WordPress installation.
2. Activate the plugin through the WordPress admin interface.

== Frequently Asked Questions ==

= What PHP functions Plugin Inspector treats as unsafe? =

Generally, most of those functions are safe, but under certain circumstances those functions may be used to hack site or to load and execute malicious code (malware). This list is not full and will be constantly updating. Any suggestions are welcome.

* eval
* system
* base64_decode
* shell_exec
* exec
* assert
* passthru
* pcntl_exec
* proc_open
* popen
* dl
* create_function
* call_user_func
* call_user_func_array
* file_get_contents
* socket_create
* curl_exec
* wp_remote_request
* wp_remote_get
* wp_remote_post
* wp_safe_remote_post
* wp_remote_head

== Screenshots ==

1. Plugin Inspector is scanning files and looking for deprecated and unsafe function
2. Beautiful source code viewer with highlighted issues

== Changelog ==

= 1.5 =
* Added cool and convenient code viewer to view found issues in the PHP code.
* Code optimization

= 1.0 =
* Initial version