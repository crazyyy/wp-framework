=== SVG Support ===
Contributors: Benbodhi
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=Z9R7JERS82EQQ
Tags: svg, vector, safe svg, sanitization, mime type
Requires at least: 5.8
Tested up to: 6.7.3
Requires PHP: 7.4
Stable tag: 2.5.14
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Securely upload SVG files to your media library, with built-in sanitization and advanced features for styling and animation.

== Description ==

**The complete SVG solution for WordPress - secure, flexible, and easy to use.**

SVG Support enables secure SVG uploads with powerful features for both basic users and developers:

✨ **Key Features**:
- Secure SVG uploads with automatic sanitization
- Inline rendering for direct CSS/JS manipulation
- File size optimization through minification
- Role-based access control
- Advanced developer options
- Multisite compatible
- Full Block Editor (Gutenberg) compatibility

🔒 **Security First**:
- Built-in sanitization removes potentially harmful code
- Role-based upload restrictions
- Comprehensive MIME type validation

🎨 **Designer Friendly**:
- Direct styling of SVG elements
- Animation support
- Custom class targeting
- Automatic dimension handling

💻 **Developer Ready**:
- Advanced mode for additional features
- REST API support
- Gutenberg compatible
- Extensive hooks and filters


== Usage ==

**Basic Usage**:
- First, install and activate SVG Support via your WordPress dashboard
- Upload SVG files to your media library like any other image
- Works seamlessly with Image blocks, Cover blocks and featured images

**Advanced Usage**:
- Enable "Advanced Mode" for minification and inline rendering
- Customize with hooks and filters for tailored functionality

**Block Editor Usage**:
- Use Advanced Mode to enable inline rendering:
  - Add the `"style-svg"` class to Image blocks
  - Add the `"style-svg"` class to Cover blocks to render SVG backgrounds inline
- Use "Skip Nested SVGs" setting to control inline rendering of SVGs within Cover blocks

**Classic Editor Usage**:
- Use Advanced Mode to add the `"style-svg"` class to `<img>` tags for inline rendering
- Enable "Auto Insert Class" option for automatic class insertion in Classic Editor

**Common Issues & Solutions**:
- SVG not displaying? Ensure dimensions are set in CSS.
- Need help? Use the support tab and I will do my best to assist you.


== Spin up a test site ==

With a single click, you can spin up a completely free test site to test SVG Support using TasteWP! No sign up, no cards, nothing! How cool is that? Give it a go:
[Click Here to spin up a test site in seconds](https://tastewp.com/new?pre-installed-plugin-slug=svg-support&redirect=options-general.php%3Fpage%3Dsvg-support&ni=true)


== Security ==

SVG Support prioritizes security with automatic sanitization and role-based restrictions. Only trusted users should have upload permissions. Configure settings to balance functionality and security.


== Feedback ==

I'm open to your [suggestions and feedback](mailto:wp@benbodhi.com) - Thanks for using SVG Support!

Follow [@SVGSupport](https://twitter.com/svgsupport) on Twitter
Follow [@benbodhi](https://twitter.com/benbodhi) on Twitter
Follow [@benbodhi](https://warpcast.com/benbodhi) on Warpcast

*Note:* I hope you like this plugin! Please take a moment to [rate it](https://wordpress.org/support/view/plugin-reviews/svg-support?filter=5#postform).


== Development & Contributing ==

The development version of SVG Support is maintained on GitHub. Feel free to contribute:

* Submit bug reports or feature suggestions: [GitHub Issues](https://github.com/benbodhi/svg-support/issues)
* Contribute code via [Pull Requests](https://github.com/benbodhi/svg-support/pulls)
* Development repository: [GitHub](https://github.com/benbodhi/svg-support)


== Translations ==

Contribute translations [here](https://translate.wordpress.org/projects/wp-plugins/svg-support). New to translating? Check the [Translator Handbook](https://make.wordpress.org/polyglots/handbook/tools/glotpress-translate-wordpress-org/).


== Frequently Asked Questions ==

= SVG not rendering inline since 2.3 update =
Ensure "Advanced Mode" is enabled in Settings > SVG Support.

= How do I disable the Javascript on the front end if I am not using inline SVG? =
Disable "Advanced Mode" in the settings.

= I'm trying to use SVG in the customizer but it's not working. =
To allow SVG to work in the customizer, you will need to modify/add some code in your child theme's function file. [Here is a great tutorial](https://thebrandid.com/using-svg-logos-wordpress-customizer/) on how to do that. The important part is:
`
'flex-width'	=> true
'flex-height'	=> true
`

= How do I add animation to my SVG? =
You will need to edit your SVG file in a code editor so you can add CSS classes to each element you need to target within the SVG. Make sure that your IMG tag is being swapped out for your inline SVG and then you can use CSS or JS to apply animations to elements within your SVG file.

= Why is SVG Support not working in multisite? =
If you installed multisite prior to WordPress 3.5, then you will need to remove your ms-files. Here is a couple of resources to help you: [Dumping ms-files](http://halfelf.org/2012/dumping-ms-files/) [Removing ms-files after 3.5](https://www.yunomie.com/2298/removing-ms-files-php-after-upgrading-an-existing-multisite-installation-to-3-5/).

= Why is my SVG not working in Visual Composer? =
If you are using SVG Support with Visual Composer or any other page builders, you will need to make sure that you can add your own class to the image. The easiest way to do this is by using a simple text or code block in the builder to put your image code in to. Additionally, there is now a setting to force all SVG files to be rendered inline.

= How do I get this to work with the Media Library Assistant plugin? =
You need to add the mime type for svg and svgz to: "MLA Settings > Media Library Assistant > Uploads (tab)" and then it works.


== Screenshots ==

1. Basic Settings
2. Advanced Settings
3. Featured Image checkbox to render SVG inline
4. SVG used in WP native Image Widget
5. Inline SVG in the front end markup
6. Help tab - Overview
7. Help tab - The Settings
8. Help tab - Standard Usage
9. Help tab - Render SVG Inline (advanced usage)
91. Help tab - Featured Images
92. Help tab - Animation


== Changelog ==

= 2.5.14 =
* **Security Enhancements**:
    - Remove default roles from the sanitizer bypass settings

* **Fixes**:
    - More comprehensive upload checks, allowing generator tags and comment patterns

* **Performance Improvements**:
    - Cleanup duplicate inline_featured_image meta entries more efficiently
    - Remove inline_featured_image meta entries that aren't explicitly set to 1 (enabled)
    - Don't store inline_featured_image meta for posts that previously had it enabled but don't anymore

* **General Updates**:
    - Restructured settings layout
    - Better cleanup on uninstall when delete plugin data is selected

= 2.5.13 =
* **Code Improvements**:
    - Better PHP 8.3 compatibility - added null checks to prevent deprecated warnings in PHP 8.3

= 2.5.12 =
* **General Updates**:
    - Added blueprint.json for the live preview feature on wordpress.org

* **Fixes**:
    - Fixed mime type check that was restricting SVG uploads without the XML tag in PHP 7.4

= 2.5.11 =
* **Security Enhancement**
    - Added more effective handling of sanitization for REST API uploads

= 2.5.10 =
* **Fixes**:
    - Fixed issue with upload checks preventing plugin uploads

= 2.5.9 =
* **New Features**:
    - Added new Advanced Mode setting "Skip Nested SVGs" to control inlining of SVGs within containers (for example: nested SVGs in Gutenberg Cover blocks)
    - Added proper multisite support for SVG uploads across subsites
    - Added network administrator support for SVG uploads on all subsites

* **Security Enhancements**:
    - Updated DOMPurify library to version 2.5.8
    - Updated enshrined/svg-sanitize to version 0.21.0
    - Added nonce verification for non-REST uploads to prevent CSRF attacks
    - Improved MIME type validation for SVG files
    - Enhanced file content validation to ensure only valid SVG files are processed
    - Moved security checks earlier in the upload process for better efficiency
    - Updated and improved sanitization options for both frontend and admin

* **Code Improvements**:
    - Changed synchronous XMLHttpRequest to asynchronous in vanilla JS version to improve performance and remove Chrome deprecation warnings
    - Removed console logging statements from JavaScript files for cleaner browser console
    - Reorganized upload validation flow for better performance
    - Added proper error messages for failed security checks
    - Improved handling of REST API uploads
    - Enhanced code documentation and inline comments
    - Added proper plugin asset handling and alt text for admin images
    - Enhanced multisite compatibility with proper role and capability checks
    - Added network-level upload permission validation
    - Added AJAX hooks for featured image inline toggle
    - Enqueue minified Gutenberg filters script instead of expanded version
    - Added better version update handling

* **Fixes**:
    - PHP Warning about undefined array key "css_target" in admin init.php
    - Fixed "not allowed to upload this file type" error on multisite installations
    - Fixed duplicate meta entries for inline featured images preventing post saves
    - Added automatic cleanup of duplicate meta entries during plugin update
    - Improved handling of featured image meta to prevent duplicate entries
    - Updated and refactored Gutenberg featured image checkbox to use modern React hooks instead of deprecated withState
    - Fixed missing file path in SVG attachment metadata causing issues with WPML Media Translation
    - Fixed jQuery dependency only being required when not using vanilla JS option

* **General Updates**:
    - Updated security documentation
    - Refined error messaging for better user experience

= 2.5.8 =
* **Security Enhancements**:
	- Improved sanitization of SVG uploads and attachments for enhanced security.
	- Ensured all output in the admin settings page is properly escaped.
	- Replaced direct file handling functions with WordPress APIs for better security and compatibility.
	- Improved translation support with added translators' comments and ordered placeholders.

* **Admin Interface Improvements**:
	- Updated admin-init.php with better escaping practices and enhanced security for the settings page.
	- Added error logging to SVG processing to assist with debugging without disrupting the user experience.

* **Performance and Compatibility**:
	- Updated enqueue functions to ensure scripts and styles are loaded efficiently with proper dependencies.
	- Improved metadata handling for SVGs to prevent issues in the Media Library and with ACF integration.
	- Optimized nonce verification and meta updates in the featured image functions to prevent unnecessary database writes.

* **General Code Improvements**:
	- Refactored code to reduce redundancy and improve maintainability.
	- Added detailed inline documentation for better code clarity and future development.

* **Experimental Integration with WP All Import**:
	- Introduced integration with WP All Import for experimental SVG handling during imports.
	- SVG files imported via WP All Import are sanitized, and their metadata is generated and updated correctly.
	- Added error logging to track issues during SVG import processing.
	- **Note**: This feature is experimental and commented out in the main plugin file for now. Feel free to uncomment the include lines to test it out, but please ensure you back up your data first.

= 2.5.7 =
* Compatibility with newer versions of php.

= 2.5.6 =
* Addressed some security concerns.

= 2.5.5 =
* More error fixes and general clean up.

= 2.5.4 =
* Fixed errors.

= 2.5.3 =
* Fixed fatal php error.

= 2.5.2 =
* Added some defaults for better security by default.

= 2.5.1 =
* Added missing quotes in uninstall.php.

= 2.5 =
* Cleaned up spelling mistakes and general formatting.
* Addressed security concern.
* Added more sanitization options - frontend and admin both supported.
* Added support for SVG minification.
* Added ability to choose jQuery or vanilla JS.
* Added DB cleanup on uninstall.
* Fixed dimensions fallback.

= 2.4.2 =
* Fixed srcset warning for some premium themes.
* Fixed original IMG IDs not getting preserved on replacement.
* Removed some rogue text from featured image box.

= 2.4.1 =
* Fixed issue causing WP-CLI to break.

= 2.4 =
* NEW FEATURE: Added optional SVG sanitization.
* NEW FEATURE: Added optional SVG minification.
* Added inline SVG checkbox to Gutenberg featured image.
* Better Gutenberg support in general.
* Modified class targeting to allow inline rendering of nested SVGs (any level deep) when you can't set the IMG class directly.
* Modified JS to use vanilla JS instead of jQuery.
* Fixed accessibility issues on settings page.
* Fixed dimensions metadata issue.
* Fixed division by 0 issue when SVG had no width or height set.
* Fixed featured image spacing issue in both classic and block editor.
* Bumped required PHP version.
* Removed obsolete admin notice.
* Removed srcset for SVG files.
* Removed directory name from filepath metadata.

= 2.3.21 =
* Fixed featured image SVG overlapping container.

= 2.3.20 =
* Fixed admin setting not being escaped when output.

= 2.3.19 =
* Fixed PHP Warning from localize_script in functions/enqueue.php.
* Added a check for SRC attribute in js/svgs-inline.js.

= 2.3.18 =
* Updated author URL in main plugin file.
* Updated donate links.
* Cleaned up plugin action meta links and settings page.
* Rolled back a fix in functions/attachment.php due to it removing meta from other attachments.

= 2.3.17 =
* Added setting to choose whether to load frontend CSS or not.

= 2.3.16 =
* Fix for files that have the XML declaration.
* Fix for PHP warnings from image widget.
* Some small CSS changes to the frontend when displaying SVG media attachments.

= 2.3.15 =
* Had to roll back a recent PHP warnings fix due to it breaking some theme compatibility.

= 2.3.14 =
* Fixed: Fatal error in some cases when removing old option from the database.

= 2.3.13 =
* Fixed: PHP warnings and notices from the image widget when using SVG files and wp_debug was on.
* Modified: Better front end CSS for displaying SVG attachments, both as images and inline.
* Removed: DB entry for deprecated admin notice.

= 2.3.12 =
* New: Native "Help" tab on the SVG Support settings page.
* New: Wrapped the inline JS in a function so you can call it at will using `bodhisvgsInlineSupport();`.
* Modified: Admin CSS to target SVG src only.
* Modified: SVG Support settings page - cleaned it up a little.
* Removed: Version update admin notice.

= 2.3.11 =
* New: Feature to use expanded JS file rather than the minified/compressed version (useful for bundling and minifying using external caching plugins).
* New: Force Inline SVG option. This feature allows you to force all of your SVG files to be rendered inline regardless of classes applied. Addresses issues where you can't add your own class to an image for some reason. For example, some page builder image elements. Also addresses changing your target class in the settings and needing to change all of your already embedded media, allowing you to simply force render rather than update all of the classes.
* Modified the readme file and descriptions a bit.
* Refined some code in functions/featured-image.php line 69 to address a warning.
* Updated "Requires at least" tag to 4.8 (though it should still work in older versions, there was issues with core during the 4.7 phase and it's time for you to update anyway).

= 2.3.10 =
* Fixed missing links in settings page.

= 2.3.9 =
* Modified plugin action meta link for settings page.
* Changed some language throughout the plugin.
* Added recommendation for ShortPixel Image Optimization.
* Added conditional to check post type supports thumbnail before setting meta data.

= 2.3.8 =
* Added some CSS to make sure featured images show on WooCommerce products, Sensei Courses and Lessons.
* Fix: Auto insert class setting was stripping featured image HTML in some cases.

= 2.3.7 =
* Added WP version check to wrap mime fix function needed for WP v4.7.1 - v4.7.2.
* Moved mime fix into mime type file.
* Modified admin notice code to make it neater.
* Fix: attachment-modal.php issues with some servers and external SVG files (props to @abstractourist & @malthejorgensen for providing fixes, as I could not consistently reproduce the issue).
* Compatibility: Changed a line to provide wider compatibility, specifically for WordPress Bedrock on a LEMP stack.
* Compatibility: Added another snippet to the JS to support IE11 (apparently people still use IE).
* Added more FAQ's.

= 2.3.6 =
* New: Added polyfill to make svgs-inline.js work with older browsers.
* New: Section to leave reviews on settings page.
* Removed: Redundant one time upgrade activate code.
* Fix: Errors reported on activation and on the settings page - [Related Support Thread](https://wordpress.org/support/topic/error-on-plugin-settings-page/).

= 2.3.5 =
* Revision and modification of the thumbnail display code.

= 2.3.4 =
* Fix: Fatal error for some because a function wasn't prefixed.

= 2.3.3 =
* Fix: Missing arguments PHP warnings from new attribute control file.
* Update settings page text.

= 2.3.2 =
* Modified the attribute control code that auto inserts our class to only apply to SVG files.

= 2.3.1 =
* Fix: Fatal error in some cases due to admin notice.

= 2.3 =
* New Feature - Advanced Mode: allows you to turn off the advanced features and simply upload SVG files like normal images. This addition also enables users to turn off the script added on front end by leaving Advanced Mode unchecked.
* New Feature - Featured Image Support: If your featured image is SVG, once the post is saved you will see a checkbox to render the SVG inline (advanced mode only).
* Performance - Stop inlining JS from running if image source is not SVG.
* Added new stylesheet for settings page.
* Moved SCSS files to their own folder.
* Changed donate link so I can track it and properly thank you for your generous donations.
* Added a rating link to the settings and media pages.
* Cleaned up code formatting, added more comments.
* Added a plugin version check.
* Added notice so people are aware they may need to turn on the advanced mode.

= 2.2.5 =
* FIX: Display SVG thumbnails in attachment modals.

= 2.2.4 =
* FIX: Added function to temporarily fix an issue with uploading in WP 4.7.1

= 2.2.32 =
* Changed text domain to match plugin slug for localization.

= 2.2.31 =
* Attempt to fix ability to translate

= 2.2.3 =
* Modified code in svg-support/js/svg-inline.js and svg-support/js/min/svg-inline-min.js to allow JS control of the SVG elements and detect if they have been loaded (IMG tag swapped out). Thanks to [laurosello](https://wordpress.org/support/profile/laurosollero) for this suggestion and code contribution.
* Fixed SVG thumbnails not displaying correctly in list view of the media library.
* Cleaned up the code and comments a bit.
* Added translation for Spanish. Thanks to [Apasionados del Marketing](http://apasionados.es) for the translation.

= 2.2.2 =
* Changed another anonymous function in svg-support/functions/thumbnail-display.php that was causing errors for some.

= 2.2.1 =
* Changed anonymous function in svg-support/functions/thumbnail-display.php line 15 to prevent fatal error in older PHP versions.

= 2.2 =
* Added support to make SVG thumbnails visible in all media library screens.
* Added SVGZ to the mime types.
* Automatically removes the width and height attributes when inserting SVG files.
* Added ability to choose whether the target class is automatically inserted into img tags or not, stripping the default WordPress classes.
* Added ability to choose whether script is output in footer - true or false.
* Blocked direct access to PHP files.
* Added SCSS support using CodeKit - minified CSS + JS files.
* Updated spelling for incorrect function name.
* Changed comment formatting across all files for consistency.
* Added link to $25 Free credit at GoWebben on the settings page.
* Tested in WordPress 4.3.
* Updated Readme file.

= 2.1.7 =
* Tested in WordPress 4.0 and added plugin icons for the new interface.

= 2.1.6 =
* Added missing jQuery dependency in /functions/enqueue.php (pointed out by [walbach](http://wordpress.org/support/profile/waldbach)) - was loading SVG Support JS before jQuery.

= 2.1.5 =
* Added Serbian translation, submitted by Ogi Djuraskovic.

= 2.1.4 =
* Fixed plugin settings link (on plugins page)
* Added more links - Support & Donate
* Modified the settings page a little
* Cleaned up settings page with CSS
* Satisfied my OCD tendencies a little

= 2.1.3 =
* Added plugin_action_links file for custom menus on plugin page.

= 2.1.2 =
* Cleaned up trunk, tags and readme.txt to show correct changelog and update notice.

= 2.1.1 =
* Fixed JS file conditional - worked in local testing but not live.

= 2.1 =
* Updates to language files for localization.

= 2.0 =
* Added an admin settings page with instructions plus options for restricting to admin use only and setting a custom CSS target class.
* Whole plugin completely re-written and re-structured.
* Added option to restrict SVG uploads to administrators only.
* Added field for custom CSS target class.
* Added stylesheet to admin settings page.

= 1.0 =
* Initial Release.


== Upgrade Notice ==

= 2.5.14 =
Better DB handling, better upload checks

= 2.5.13 =
Better PHP 8.3 compatibility (added null checks to prevent deprecated warnings in PHP 8.3)

= 2.5.12 =
Fixes mime type check that was restricting SVG uploads without the XML tag in PHP 7.4

= 2.5.11 =
Security update: added more effective handling of sanitization for REST API uploads

= 2.5.10 =
Fixed issue with upload checks preventing plugin uploads

= 2.5.9 =
Important security update that adds enhanced upload validation, MIME type checking, and CSRF protection. Please backup before updating. No configuration changes required - all security improvements work automatically.

= 2.5.8 =
Improved security, enhanced SVG processing, and updated admin interface. Includes better sanitization and escaping practices. Please take a backup before updating!

= 2.5.7 =
This update addresses issues with newer PHP versions.

= 2.5.6 =
This update addresses some security concerns.

= 2.5.5 =
Updating to 2.5+ Adds new features and addresses a number of earlier issues raised. Please take a backup before updating!
2.5.5 fixes more reported errors in the 2.5 series of updates.

= 2.5.4 =
Updating to 2.5+ Adds new features and addresses a number of earlier issues raised. Please take a backup before updating!
2.5.4 fixes errors in the 2.5 series of updates.

= 2.5.3 =
Updating to 2.5+ Adds new features and addresses a number of earlier issues raised. Please take a backup before updating!
2.5.3 fixes fatal error in 2.5.2.

= 2.5.2 =
Updating to 2.5+ Adds new features and addresses a number of earlier issues raised. Please take a backup before updating!
2.5.2 introduces some defaults for better security.

= 2.5.1 =
2.5 Adds new features and addresses a number of recent issues raised. Please take a backup before updating!
2.5.1 fixes the uninstall file.

= 2.5 =
Adds new features and addresses a number of recent issues raised. Please take a backup before updating!

= 2.4.2 =
2.4.2 fixes srcset issue firing PHP warnings for some themes and original image IDs missing on replacement to inline SVG.

= 2.4.1 =
2.4.1 fixes broken WP-CLI. Now featuring optional SVG sanitization and ability to target nested SVGs! This update contains a lot, please BACKUP YOUR DATABASE AND FILES BEFORE UPDATING!

= 2.4 =
Now featuring optional SVG sanitization and ability to target nested SVGs! This update contains a lot, please BACKUP YOUR DATABASE AND FILES BEFORE UPDATING!

= 2.3.21 =
Fixes featured image display on edit post screen.

= 2.3.20 =
Added more security.

= 2.3.19 =
Quick update to address PHP warnings from localize_script and to add a SRC check.

= 2.3.18 =
General clean up of plugin, testing on latest nightly build plus fixed issue with metadata being removed from non SVG attachments.

= 2.3.17 =
Added a setting to choose whether to load the frontend CSS file or not. It was previously enabled by default, so you may want to flick that on after the update. This allows you to leave it out so your site has one less file to load :)

= 2.3.16 =
This update addresses upload issues, PHP warnings and some frontend CSS changes with attachment display.

= 2.3.15 =
Had to roll back a recent PHP warnings fix due to it breaking some theme compatibility.

= 2.3.14 =
Fixes fatal error in some cases when removing old option from the database.

= 2.3.13 =
Update to address PHP warnings and notices on the image widget when wp_debug is enabled.

= 2.3.12 =
* Inline JS can now be called using `bodhisvgsInlineSupport();`. Added a native help tab and removed the admin update notice. General cleanup of code and settings page. Remember to back up your site before updating.

= 2.3.11 =
* New Features and Fixes: Added "Force Inline SVG" to render all SVG files inline with one click. Option to use an expanded JS version for separate minification with a caching plugin.

= 2.3.10 =
* Fixed missing links in settings page.

= 2.3.9 =
* Cleaned up some code and language, now stores less meta when not needed and added a plugin recommendation for Image Optimization.

= 2.3.8 =
* Adds better support for WooCommerce and Sensei. Fixes issue with featured images not showing up when auto insert class setting is on.

= 2.3.7 =
* Fixes issues with media library not loading for some, attachment-modal errors and adds some wider compatibility.

= 2.3.6 =
* Adds support for older browsers, fixes a couple of seemingly isolated errors reported, removes some redundant code.

= 2.3.5 =
* Modifications to thumbnail display code to prevent output buffer clash with another plugin.

= 2.3.4 =
* Fixes fatal error for some because a function wasn't prefixed.

= 2.3.3 =
* This update fixes some PHP warnings introduced in 2.3.2 and also has updated settings page text.

= 2.3.2 =
* Changes to the way the auto class insert works.

= 2.3.1 =
* Fixes fatal error in some cases due to admin notice in V2.3.

= 2.3 =
IMPORTANT, MAJOR CHANGES, BACKUP BEFORE UPDATING: Users that are inlining SVG will need to make sure "Advanced Mode" is active under "Settings > SVG Support". Your settings should all still be there. Make sure you run a backup before updating just in case!!!

= 2.2.5 =
* Fix to display SVG thumbnails in attachment modals. (NOTE: You can not edit SVG files like other images in WordPress)

= 2.2.4 =
* IMPORTANT: Fixes upload ability in WP 4.7.1

= 2.2.32 =
* Changed text domain to match plugin slug for localization.

= 2.2.31 =
* This release attempts to fix translation issues.

= 2.2.3 =
* Feature - Changed code to allow JS detection if SVG has loaded and ability to control SVG using JS.
* Fix - Thumbnail display in media library list view.
* Added Spanish translation and cleaned up code/comments a bit.

= 2.2.2 =
* Fix - Another change from anonymous function that was triggering errors for some.

= 2.2.1 =
* Minor change to remove anonymous function that triggered a fatal error in older PHP versions.

= 2.2 =
* Significant changes, added functionality, please BACKUP BEFORE UPDATING just in case.

= 2.1.7 =
* Tested in WordPress 4.0 and added plugin icons for the new interface.

= 2.1.6 =
* Important update! Added missing jQuery dependency in /functions/enqueue.php - was loading SVG Support JS before jQuery.

= 2.1.5 =
* Added Serbian translation, submitted by Ogi Djuraskovic.

= 2.1.4 =
* Some more re-arranging, added a few helpful links, updated language files, tended to my OCD a bit.

= 2.1.3 =
* Added a link on the plugins page to the plugin settings page for easy access after install.

= 2.1.2 =
* A little bit of house cleaning, updates to changelog and readme.txt for correct output with current version.

= 2.1.1 =
* Update to conditional in JS file.

= 2.1 =
* Updated language files for localization that were missed in version 2.0.

= 2.0 =
* SVG Support has been completely re-written and re-structured. It now includes an admin settings page with instructions, plus options for restricting to admin use only and setting a custom CSS target class.

= 1.0 =
* Initial Release.