=== Disable Comments for Any Post Types (Remove comments)  ===
Tags: disable comments, disable XML-RPC, remove comments, delete comments, no self pings, wp disable, disable pingback comments, comments manager, webcraftic update manager, clearfy, replace external links, remove comment form, comment form, remove comment form fields, bulk comments management, spam comments cleaner, delete comments by status, no page comment, wp disable comments
Contributors: webcraftic
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=VDX7JNTQPNPFW
Requires at least: 4.2
Tested up to: 4.9
Requires PHP: 5.2
Stable tag: trunk
License: GPLv2

Allows administrators to disable comments on their website. Comments can be disabled according to Post, Page, Media type.

== Description ==

<strong>Disable comments</strong> plugin is a useful tool for blog or site administrators that allows fully disabling or hiding comments for any post types, pages or attachments.

It removes the all comments related features and options:

* <strong>disable comments</strong> on frontend at all;
* <strong>remove comments</strong> option from WordPress dashboard menu;
* <strong>hide comments</strong> option from the admin bar;
* <strong>Turn off comments widgets.</strong>

In addition, this plugin can <strong>disable XML-RPC</strong> related functions in WordPress including disable pingbacks and disable trackbacks, and helps to prevent the attacks on the xmlrpc.php file. Lastly, it attempts to generate a “403 Denied” error for requests to the /xmlrpc.php URL, but does not affect that file or your server in any way.

If you want <strong>completely remove comments</strong>, you can do this individually for selected post types. You can easily bulk delete all WordPress comments in some clicks. No any other “Delete All Comments” plugins or phpMyAdmin needed.

You can disable comments but if you decide to leave them, you need to close comments external links from the search engines. By default when users places comments, the WordPress adds rel=”nofollow” attribute to the comment author URL and for all links in the comments text. However, already for a long time, search engines ignores this and follows links. It makes dozens of superfluous external links from comments that are do not bring anything good for your SEO. <strong>Disable Comments</strong> plugin makes all external links in WordPress comments invisible for search engines with Javascript and improves your blog or website SEO.

In addition, if you do not want to disable comments you may need to remove website field from the WordPress comment form. Note: you can remove comment author URL but this feature can be not work with some themes.

Generally, the <strong>Disable Comments</strong> plugin uses the intelligent algorithm to <strong>hide comments</strong> and <strong>remove comments</strong>. You just need to turn some toggles on.

If you come across any bugs or have suggestions with <strong>Disable Comments</strong>, please use the plugin support forum. I cannot fix them if I do not know about! Please check the FAQ for common issues.


== Frequently Asked Questions ==

= Nothing happens after I disable comments on all posts – comment forms are still appears inside my posts. =

That is because your theme is not checking the comment status of posts in the correct way.

You may like to point your theme’s author to this explanation of what they are doing wrong, and how to fix it.

= How can I remove the text “comments are closed” at the bottom of articles when comments are disabled? =

The plugin tries to hide it (and any other comment-related elements) as well as possible.

If you still see this message, it means that your theme is overrides this behavior and you will have to edit its files manually for fix it. Two common approaches are to either delete or comment out the relevant lines in wp-content/your-theme/comments.php, or to add a declaration to wp-content/your-theme/style.css that hides the message from your visitors. In either case, make know what you are doing!

= I only want to disable comments on certain posts, not globally. What do I need to do? =

Do not install this plugin!

Go to the edit page for the post you want to disable comments. Scroll down to the “Discussion” box, where you will find the comment options for that post. If you do not see a “Discussion” box, then click on “Screen Options” at the top of your screen, and make sure the “Discussion” checkbox is checked.

You can also bulk-edit the comment status of multiple posts from the posts screen.

= I want to delete comments from my database. What do I need to do? =

When you will change the plugin settings, you will be prompt to delete comments from the database.

== Details ==

The Disable Comments plugin allows you <strong>completely disable the commenting feature in WordPress</strong>. When this option is on you will get the following changes:

<strong>* Easy Enable or disable Comments;</strong>
<strong>* Disable comments globally;</strong>
<strong>* Disable comments on certain Pages;</strong>
<strong>* Disable comments on posts Only;</strong>
<strong>* Disable comments on pages Only;</strong>
<strong>* Disable comments for any post types;</strong>
<strong>* Disable comments links in the Admin Menu and Admin Bar;</strong>
<strong>* Disable comments related sections (“Recent Comments”, “Discussion” etc.) and hide from the WordPress Dashboard;</strong>
<strong>* Disable comments related widgets (so your theme cannot to use them);</strong>
<strong>* Disable comments “Discussion” settings page;</strong>
<strong>* Disable comments in RSS/Atom feeds (and requests for comments RSS will be redirect to the parent post);</strong>
<strong>* Disable X-Pingback HTTP header and remove from all pages;</strong>
<strong>* Disable outgoing pingbacks;</strong>
<strong>* Making comments external links “nofollow” and invisible for search engines;</strong>
<strong>* Remove website/URL field from the comment form;</strong>
<strong>* Remove comments, Delete comments in one click.</strong>

We recently added brand new features into the <strong>Disable Comments plugin</strong>. These are <strong>Disable X-Pingback</strong> function, <strong>Replace external links</strong> and <strong>Remove website/url comment field</strong>.

Some functions was taken from the following popular plugins: <strong>Clearfy – disable unused features</strong>, <strong>Bulk Comments Management</strong>, <strong>Spam Comments Cleaner</strong>, <strong>Delete Comments By Status</strong>, <strong>No Page Comment</strong>, <strong>WP Disable Comments</strong>, <strong>Hide “Comments are closed”</strong>, <strong>Hide Show Comment</strong>.

== Advanced Configuration ==

Site administrators and plugin/theme developers can modify some of the plugin’s behavior through the code:

Define DISABLE_COMMENTS_REMOVE_COMMENTS_TEMPLATE and set it to false to prevent the plugin from replacing theme’s comment template with an empty one.

These definitions can be make either in your main wp-config.php or in your theme’s functions.php file.

#### RECOMMENDED SEPARATE MODULES ####
We invite you to check out a few other related free plugins that our team has also produced that you may find especially useful:

* [Clearfy – WordPress optimization plugin and disable ultimate tweaker](https://wordpress.org/plugins/clearfy/)
* [Disable updates, Disable automatic updates, Updates manager](https://wordpress.org/plugins/webcraftic-updates-manager/)
* [Cyrlitera – transliteration of links and file names](https://wordpress.org/plugins/cyrlitera/)
* [Cyr-to-lat reloaded – transliteration of links and file names](https://wordpress.org/plugins/cyr-and-lat/ "Cyr-to-lat reloaded")
* [Disable admin notices individually](https://wordpress.org/plugins/disable-admin-notices/ "Disable admin notices individually")
* [WordPress Assets manager, dequeue scripts, dequeue styles](https://wordpress.org/plugins/gonzales/  "WordPress Assets manager, dequeue scripts, dequeue styles")
* [Hide login page](https://wordpress.org/plugins/hide-login-page/ "Hide login page")

== Translations ==

* English - default, always included
* Russian

If you want to help with the translation, please contact me through this site or through the contacts inside the plugin.

== Installation ==

1. Upload the plugin folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. The plugin settings can be accessed via the 'Settings' menu in the administration area (either your site administration for single-site installs).

== Screenshots ==
1. Control panel (General)
2. Control panel (Remove comments)

== Changelog ==
= 1.0.9 =
* Fixed: Update core

= 1.0.8 =
* Fixed: Update core
* Fixed: Small bugs
* Fixed: Translations

= 1.0.7 =
* Fixed: Update core
* ADDED: Plugin options caching to reduce database queries for 90%. Clearfy became lighter and faster.
* ADDED: Compress and cache the plugin core files, to reduce the load on the admin panel

= 1.0.5 =
* Added a new feature: Added page for cleaning comments
* Fixed: Bugs with Woocommerce

= 1.0.4 =
* Update plugin core
* Fixed bug reduced plugin weight.
* Fixed JS error with external links option.
* Add french translation

= 1.0.3 =
* Update plugin core

= 1.0.2 =
* Fixed a bug where you selected the recommended mode, on some pages you see a white screen. Now you will not encounter this error.

= 1.0.1 =
* Plugin release
