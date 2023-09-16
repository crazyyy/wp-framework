=== Javascript Error Reporting Client ===
Contributors: jdamner
Donate link: https://amner.me/
Tags: javascript, error, developer, reporting, bug, debug, js, console
Requires at least: 5.0
Tested up to: 5.8
Stable tag: 1.0.0
Requires PHP: 7.0
License: GPLv3
License URI: https://www.gnu.org/licenses/gpl-3.0.html

A plugin that collects javascript errors from every client and provides a dashboard for you to review these errors.

== Description ==
Javascript Error Reporting Client is a plugin that collects javascript errors from the visitors to your website and stores them for you to review.

This is ideally used by plugin and theme developers to help debug issues that are difficult to reproduce, or could be specific to a specific user. 

== Frequently Asked Questions ==
= What details are collected? =
* The error message
* The name of the script where the error occured, and the line and column number.
* The user ID of the the WP user encountering the error
* The user's IP address, helpful to tie this error log with other logs such as server logs. 
* The URL of the page where the error occured
* The users HTTP_USER_AGENT string. 
= Can I remove the logged data? =
Yes, when you deactivate the plugin you'll have the choice to remove any stored data.


== Changelog ==

= 1.0 =
* Initial Release