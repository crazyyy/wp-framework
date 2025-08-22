=== Easy HTTPS Redirection (SSL) ===
Contributors: Tips and Tricks HQ
Donate link: https://www.tipsandtricks-hq.com/development-center
Tags: ssl, https, force ssl, insecure content, redirection, automatic redirection, htaccess, https redirection, ssl certificate, secure page, secure, force https
Requires at least: 6.5
Tested up to: 6.8
Stable tag: 2.0.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

The plugin allows an automatic redirection to the "HTTPS" version/URL of the site. Make your site SSL compatible easily.

== Description ==

= Only use this plugin if you have installed SSL certificate on your site and HTTPS is working correctly =

Once you've installed an SSL certificate on your site, it's important to ensure that your webpages are accessed via their secure HTTPS URLs.

To improve SEO and user security, you want search engines and visitors to always use the HTTPS version of your pages. This plugin makes that easy by automatically redirecting users to the HTTPS version whenever they try to access the non-HTTPS (HTTP) version of a page.

=== Example ===

Let's say you want to ensure the following page is always accessed over HTTPS:

`https://www.example.com/checkout`

If a visitor tries to access:

`http://www.example.com/checkout`

The plugin will automatically redirect them to the secure version:

`https://www.example.com/checkout`

This ensures that visitors always access the HTTPS version of your pages or site.

You can choose to automatically redirect your entire domain to HTTPS, or selectively apply HTTPS redirection to specific pages.

=== Video Tutorials ===

https://www.youtube.com/watch?v=oyJgRFCM6u8

https://www.youtube.com/watch?v=LtyBraB64v8

=== Force Load Static Files Using HTTPS ===

If you started using SSL from day 1 of your site then all your static files are already embedded using HTTPS URL. You have no issue there.

However, if you have an existing website where you have a lot of static files that are embedded in your posts and pages using NON-HTTPS URL then you will need to change those. Otherwise, the browser will show an SSL warning to your visitors.

This plugin has an option that will allow you to force load those static files using HTTPS URL dynamically. 

This will help you make the webpage fully compatible with SSL.

=== SSL Certificate Expiry Notification ===

This plugin includes a feature that allows you to receive email notifications when your SSL certificate is about to expire. It helps ensure your website remains secure and accessible over HTTPS.

You can configure the recipient email address and specify how many days in advance the notification should be sent. By default, the notification is sent 7 days before expiry, but you can adjust this to suit your preference.

This feature is especially useful for site owners who may not frequently check their SSL status, or for those managing multiple websites. By receiving timely alerts, you can renew your SSL certificate in advance and prevent potential downtime or security warnings.

=== Features ===
* Automatically redirect all HTTP traffic to HTTPS
* Option to force HTTPS on the entire site
* Option to selectively apply HTTPS redirection to specific pages
* Helps search engines index the secure versions of your pages
* Improves site security and user trust
* Force load static files (images, js, css etc) using a HTTPS URL
* SSL certificate expiry notification - Option to send SSL expiry notifications to a specific email address
* Easily see which SSL certificates on your site are approaching their expiry date.

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

The.htaccess is located in the site root. With your FTP program or via cPanel go to the site root, open the .htaccess file and delete the necessary strings manually.
Please make use of the following information: https://codex.wordpress.org/FTP_Clients

= How to use the other language files with the HTTPS Redirection? = 

Here is an example for German language files.

1. In order to use another language for WordPress it is necessary to set the WP version to the required language and in configuration wp file - `wp-config.php` in the line `define('WPLANG', '');` write `define('WPLANG', 'de_DE');`. If everything is done properly the admin panel will be in German.

2. Make sure that there are files `de_DE.po` and `de_DE.mo` in the plugin (the folder languages in the root of the plugin).

3. If there are no such files it will be necessary to copy other files from this folder (for example, for Russian or Italian language) and rename them (you should write `de_DE` instead of `ru_RU` in the both files).

4. The files are edited with the help of the program Poedit - https://poedit.net/download - please load this program, install it, open the file with the help of this program (the required language file) and for each line in English you should write translation in German.

5. If everything has been done properly all the lines will be in German in the admin panel and on frontend.

== Screenshots ==

1. Plugin settings page.

== Changelog ==

= v2.0.0 =
- The plugin has gone through significant updates and improvements in this version.
- If you have any issues after you upgrade to this version, please roll back to the previous version and contact us for support.
- Here is the download link for the previous version: https://downloads.wordpress.org/plugin/https-redirection.1.9.2.zip
- The plugin now has it's own admin menu labeled "Easy HTTPS & SSL".
- Added a new option to send SSL expiry notifications to a specific email address.
- Added a new option to specify how many days in advance the notification should be sent.
- Added debug logging feature.
- Updated the translation POT file.

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