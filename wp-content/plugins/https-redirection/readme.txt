=== Easy HTTPS Redirection (SSL) ===
Contributors: Tips and Tricks HQ
Donate link: https://www.tipsandtricks-hq.com/development-center
Tags: ssl, https, force ssl, insecure content, redirection, automatic redirection, htaccess, https redirection, ssl certificate, secure page, secure, force https
Requires at least: 5.5
Tested up to: 6.2
Stable tag: 1.9.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

The plugin allows an automatic redirection to the "HTTPS" version/URL of the site. Make your site SSL compatible easily.

== Description ==

= Only use this plugin if you have installed SSL certificate on your site and HTTPS is working correctly =

After you install SSL certificate on your site, you should use the "HTTPS" URL of your webpages. 

You want to force search engines to index your HTTPS version of the webpage(s).

This plugin will help you automatically setup a redirection to the https version of an URL when anyone tries to access the non-https version.

Lets say for example, you want to use HTTPS URL for the following page on your site:

www.example.com/checkout

This plugin will enforce that so if anyone uses an URL like the following in the browser's address bar:
http://www.example.com/checkout 

It will automatically redirect to the following HTTPS version of the page:
https://www.example.com/checkout

So you are always forcing the visitor to view the HTTPS version of the page or site in question.

You can force your entire domain to be auto redirected to the HTTPS URL or selectively choose a few pages to be re-directed.

= Video Tutorials =

https://www.youtube.com/watch?v=oyJgRFCM6u8

https://www.youtube.com/watch?v=LtyBraB64v8

= Force Load Static Files Using HTTPS =

If you started using SSL from day 1 of your site then all your static files are already embedded using HTTPS URL. You have no issue there.

However, if you have an existing website where you have a lot of static files that are embedded in your posts and pages using NON-HTTPS URL then you will need to change those. Otherwise, the browser will show an SSL warning to your visitors.

This plugin has an option that will allow you to force load those static files using HTTPS URL dynamically. 

This will help you make the webpage fully compatible with SSL.

= Features =

* Actions: Do an auto redirect for the whole domain. So every URL will be redirected to the HTTPS version automatically.
* Actions: Do an auto redirect for a few pages. The user can enter the URLs that will be auto redirected to the HTTPS version.
* Force load static files (images, js, css etc) using a HTTPS URL.

View more details on the [HTTPS Redirection plugin](https://www.tipsandtricks-hq.com/wordpress-easy-https-redirection-plugin) page.

== Installation ==

1. Upload `https-redirection` folder to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Plugin settings are located in 'Settings', 'HTTPS Redirection'.

== Frequently Asked Questions ==

= How will the plugin work with the existing .htaccess file?=

If the file exists, the plugin will update existing .htaccess file.

= What should I do if the .htaccess file does not exist? =

The plugin will store the settings in the database and add all the necessary conditions to the settings of WordPress automatically.

= What should I do if after making changes in the .htaccess file with the help of the plugin my site stops working? =

The.htaccess is located in the site root. With your FTP program or via Сpanel go to the site root, open the .htaccess file and delete the necessary strings manually.
Please make use of the following information: http://codex.wordpress.org/FTP_Clients

= How to use the other language files with the HTTPS Redirection? = 

Here is an example for German language files.

1. In order to use another language for WordPress it is necessary to set the WP version to the required language and in configuration wp file - `wp-config.php` in the line `define('WPLANG', '');` write `define('WPLANG', 'de_DE');`. If everything is done properly the admin panel will be in German.

2. Make sure that there are files `de_DE.po` and `de_DE.mo` in the plugin (the folder languages in the root of the plugin).

3. If there are no such files it will be necessary to copy other files from this folder (for example, for Russian or Italian language) and rename them (you should write `de_DE` instead of `ru_RU` in the both files).

4. The files are edited with the help of the program Poedit - http://www.poedit.net/download.php - please load this program, install it, open the file with the help of this program (the required language file) and for each line in English you should write translation in German.

5. If everything has been done properly all the lines will be in German in the admin panel and on frontend.

== Screenshots ==

1. Plugin settings page.

== Changelog ==

= v1.9.2 =
- Added rule to handle sites that are sitting behind a reverse-proxy. Thanks to @canadiannaginata for pointing it out.

= v1.9.1 =
- WP 5.3 warning fix for the add_submenu_page() function call. Thanks to @vfontj for pointing this out.

= v1.9 =
- WP Fastest Cache cache is automatically cleared when plugin settings are changed. This is to prevent "mixed content" warning from browsers.
- Fixed rare conflict with WP Fastest Cache (thanks to emrevona).

= v1.8 =
- Apply HTTPS redirection on the whole domain will be the default selected option after plugin install. You an change this option when you actually go to enable the feature.

= v1.7 =
- Additional options are only accessible when "Enable automatic redirection to the "HTTPS" is enabled.
- https://www.yoursite.com/some-page is replaced with site's actual https address in Settings information box.
- Added reminder for user to clear cache of optimization plugins similar to W3 Total Cache or WP Super Cache.

= v1.6 =
- Improved the "Force Load Static Files Using HTTPS" feature.
- The htaccess redirection is now detected based on SERVER_PORT (this is should work better on most servers).

= v1.5 =
- WordPress 4.6 compatibility.

= v1.4 =
- Improved the settings area to only show the options if pretty permalink feature is enabled.

= v1.3 =
- Updated the htaccess rules for HTTPS redirection to be more robust to prevent errors on some servers.

= v1.2 =
- Added a new option to automatically force load static files using HTTPS URL.

= v1.1 =
- Fixed a bug with the settings page.

= v1.0 =
* First commit to WordPress repository

== Upgrade Notice ==

None