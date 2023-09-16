=== Developer Pack ===
Contributors: nguyenhongphat0
Donate link: http://github.com/nguyenhongphat0/wordpress-developerpack
Tags: developer, freelancer, code, editor
Requires at least: 4.6
Tested up to: 4.7
Stable tag: 4.3
Requires PHP: 5.2.4
License: GPLv
License URI: https://www.gnu.org/licenses/gpl-3.0.en.html

This plugin contain everything a wordpress developer need.

== Description ==

Developer Pack allow you to view PHP information, download WordPress site source code with advanced options, and online code editing with a powerful code editor. You don't have to use FTP or SSH anymore.
Developer Pack is built for the developers/freelancers. If you don't know how to code PHP or how WordPress work, it is massive dangerous. Please only install it when you know what you are doing!
Remember: This plugin can modify your file system. Use it wisely!

== Installation ==

1. Go to WordPress admin dashboard, upload the zip file of this plugin in the Add plugin page.
2. Activate the plugin through the 'Plugins' screen in WordPress.
3. Use the Developer Pack screen to use this plugin features.

== Frequently Asked Questions ==

= Why I had to use the browser console? =

Sorry for the inconvenience. When this plugin was built, it was aimed at the developer. In my opinion, all developer would have familiar with the browser console. So instead of spending effort on rendering beautiful output, I was focus on doing the core function and put all the output "lazily" in the browser console. However it is quite cool, isn't it?

= What does these red, green and yellow background color of the address bar in code editor mean? =

When you put a filename in the address bar (with relative path to the WordPress root) and hit Enter, the address bar color change background color indicate the existence of the file. If it still white, and file content is loaded in both editor, then the filename is correct. If it is yellow, then the file you entered was a folder, and you can open your browser console to see what files you can navigate to. If it turn red then the file you entered was not exist, right folders/files name of the same directory is listed in the console.

== Screenshots ==

1. You can view your PHP information and download source code with advanced options like include or exclude files, max file size and expand script time limit.
2. You can edit your file online via a powerful code editor that support syntax highlight, code completion, diff review and multicursor. Remember to open your browser console in order to view editor output.

== Changelog ==

= 1.3.0 =
* Showing Developer Pack menu as a Tools's submenu

= 1.2.0 =
* Using CDN for Monaco Editor
* Append directory list result to buffer and output all at once

= 1.1.0 =
* Embed monaco editor to admin dashboard.
* Data validation and sanitize.

== Upgrade Notice ==

= 1.1.0 =
This version include security patch. Please upgrade!

