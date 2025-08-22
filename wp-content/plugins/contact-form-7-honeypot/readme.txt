=== CF7 Apps – [Honeypot and hCAPTCHA for Contact Form 7] ===
Tags: contact form, anti-spam, spam protection, captcha, honeypot
Requires at least: 4.8
Tested up to: 6.8
Stable tag: 3.0.0
Requires PHP: 5.6
Contributors: wpexpertsio
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Add hCaptcha and Honeypot to Contact Form 7 with CF7 Apps. Improve form security, lightweight, and no unnecessary code.

== Description ==

**Add extra Spam Protection functionalities to your Contact Form 7 forms with CF7 Apps.**

Contact Form 7 is one of the most popular form plugins for WordPress, but **it lacks many advanced features** that modern websites need. CF7 Apps adds extra Spam Protection functionalities to your Contact Form 7 forms, introducing honeypot and hCaptcha options.

👉 Get Support: [Click Here](https://wordpress.org/support/plugin/contact-form-7-honeypot/)
👉 Check out the [Documentation](https://cf7apps.com/docs/?utm_source=wp_org&utm_medium=readme&utm_campaign=documentation)

==What CF7 Apps Can Do for You ?==

Right out of the box, CF7 Apps includes:

✅ **Honeypot App**
✅ **hCaptcha App**
💡 **[Suggest a Feature](https://cf7apps.com/submit-idea/?utm_source=wp_org&utm_medium=readme&utm_campaign=suggest_a_feature)**

And that’s just the beginning.

🌟 **Add a Honeypot Field to Prevent Spam**

Our **Honeypot Contact Form 7 extension** creates a hidden field inside your Contact Form 7 forms. Real users never see it, but bots do—and that's how the bots fall for the trap. It blocks automated spam before it even hits your inbox.

🌟 **Add hCaptcha to Contact Form 7**

Protect your forms from spam bots using **hCaptcha,** a privacy-friendly alternative to Google reCAPTCHA. This extension integrates directly with CF7 and works instantly after setup. No coding is required, and no extra plugins are needed. Just set up your site keys and you're done.

**NOTE:**
The best thing is that both features work independently. You can run them alone or together based on your site’s needs.

==Real Use Cases for CF7 Apps==

With the CF7 Apps, you can do the following:
  ✔️ Trap bots using a honeypot field without affecting users
  ✔️ Add hCaptcha to Contact Form 7 for privacy-first anti-spam

==Why Should You Install CF7 Apps?==

* Works exclusively with Contact Form 7
* Modular design — activate only the features you need
* Lightweight — no unnecessary code or bloat
* Built for form security, user control, and advanced customization
* Continuously updated with new apps and requested features

We built CF7 Apps for users who want more power without abandoning the simplicity of Contact Form 7.

==Contribute or Report Issues==
Do you have a feature request or bug to report? Contact us via the [official Support Channel.](https://wordpress.org/support/plugin/contact-form-7-honeypot) 


== Installation ==

**How to Get Started**

1. Install the CF7 Apps plugin
2. Go to the CF7 Apps dashboard
3. Activate the addons you want (like hCaptcha or Honeypot)
4. Configure and use the new feature immediately in your Contact Form 7 form.

No code. No clutter. These are just all the essential add-ons that extend the capabilities of Contact Form 7.

**Contribute or Report Issues**

Do you have a feature request or bug to report? Visit the plugin’s support section on WordPress.org or contact us via the [official Support Channel.](https://wordpress.org/support/plugin/contact-form-7-honeypot/)

= Altering the Honeypot Output HTML [ADVANCED] =
While the basic settings should keep most people happy, we've added several filters for you to further customize the honeypot field. The three filters available are:

* `wpcf7_honeypot_accessibility_message` - Adjusts the default text for the (hidden) accessibility message (**can now be done on the settings page**).
* `wpcf7_honeypot_container_css` - Adjusts the CSS that is applied to the honeypot container to keep it hidden from view.
* `wpcf7_honeypot_html_output` - Adjusts the entire HTML output of the honeypot element.

For examples of the above, please see this [recipe Gist](https://gist.github.com/nocean/953b1362b63bd3ecf68c).


== Frequently Asked Questions == 

=How do I add hCaptcha to Contact Form 7?=
Activate the hCaptcha App inside CF7 Apps, enter your site keys, error messages, and save settings. That’s it. Now, you’ll see the hCaptcha tag in your Contact Form 7 form settings. 

=What is Contact Form 7?=
Contact Form 7 is a long-standing WordPress plugin that lets you build and manage contact forms on your site. It supports multiple forms, customization, and various integrations—all without writing any code.

=Will CF7 Apps slow down my site?=
No. Each addon works independently. You only activate the features you want. That keeps your website fast and your backend clean.

=How do I report a security issue?=
If you discover a security vulnerability, please report it to us via the [official Support Channel.](https://wordpress.org/support/plugin/contact-form-7-honeypot) Our team will review, verify, and fix all security-related reports responsibly.

= Can I use more than one Honeypot field in my forms? =
You sure can, and many users have indicated this helps stop even more spam, as it increases your chances that a bot will get caught in the trap. Just make sure each Honeypot field has a unique name.

= Can I modify the HTML that this plugin outputs? =

Yep! See the **Installation** section for more details and [this Gist](https://gist.github.com/nocean/953b1362b63bd3ecf68c) for examples.

= Where do I report security bugs found in this plugin? =
Please report security bugs found in the source code of the CF7 Apps – [Honeypot and hCAPTCHA for Contact Form 7] plugin through the [Patchstack Vulnerability Disclosure Program](https://patchstack.com/database/vdp/e58fd0b7-60aa-4ba8-aeeb-61889936d10c). The Patchstack team will assist you with verification, CVE assignment, and notify the developers of this plugin.

= Disclaimer =

CF7 Apps is a third-party plugin and is not officially associated with or endorsed by Contact Form 7.

== Screenshots ==

1. CF7 Apps Dashboard.
2. Honeypot Settings.
3. hCaptcha Settings.
4. Contact form 7 hCaptcha Tag.
5. CF7 Apps Tags.

== Changelog ==
= 3.0.0 - July 16, 2025 =
* NEW - Introducing CF7 Apps, All new Dashboard.
* NEW - Introducing hCaptcha.

= 2.1.7 October, 13, 2024 =
* Fixed compatibility issues with CF7 6.0
* Tested compatibility with latest WordPress (Version 6.7)

= 2.1.6 October, 05, 2024 =
* Fixed compatibility issues with CF7 6.0

= 2.1.5 September, 25, 2024 =
* Removed warning from CF7 when honeypot is added.

= 2.1.4 August, 22, 2024 =
* Added new dependency feature.
* Localized date settings in settings page
* Added new datatable which shows a honeypot used in from or not.

= 2.1.3 July 01, 2024 =
* Tweak: Updated old URLs

= 2.1.2 =
Changed contributor to WPExperts

= 2.1.1 =
Fixes small bug when enabling in bulk with other plugins.

= 2.1 =
Added new feature: additional submission time check to improve bot-stopping power! Also, fixed small HTML issue and tidied up shortcode interface.

= 2.0.5 =
Improved backwards compatibility. Solves issues when plugin installed on older versions of CF7.

= 2.0.4 =
Better error checking for missing config problems.

= 2.0.3 =
General code cleanup, better adherence to WP coding standards and fixes for i18n functions.

= 2.0.2 =
Replaced text domain constant with plain string for better i18n compatability.

= 2.0.1 =
Hotfix for issue with options not being set on upgrade.

= 2.0 =
A significant update with a bunch of new things. Please see the [release notes](http://www.nocean.ca/blog/honeypot-for-contact-form-7-v2-0/).

= 1.14.1 =
Minor update to change name to comply with CF7 copyright notice.

= 1.14 =
Added do-not-store for when forms are stored in the DB (i.e. Flamingo). Improved wrapper ID masking and customization.

= 1.13 =
Additional functionality to improve spam-stopping power.

= 1.12 =
Introduces ability to force W3C compliance. See [here](https://wordpress.org/support/topic/w3c-validation-in-1-11-explanation-and-work-arounds/) for details.

= 1.11 =
Addresses accessibility concerns regarding a missing label and disables autocomplete to prevent browser autocomplete functions from filling in the field.

= 1.10 =
Updates for Function/Class changes related to CF7 4.6. Removed plugin local language support, instead use translate.wordpress.org.

= 1.9 =
Added i18n support, French language pack. Thx chris-kns

= 1.8 =
Added wpcf7_honeypot_accessibility_message and wpcf7_honeypot_container_css filters, i18n support.

= 1.7 =
Provides backwards compatibility for pre-CF7 4.2, introduces ability to remove accessibility message.

= 1.6.4 =
Quick fix release to fix PHP error introduced in 1.6.3.

= 1.6.3 =
Updates to accommodate changes to the CF7 editor user interface.

= 1.6.2 =
Small change to accommodate validation changes made in CF7 4.1.

= 1.6.1 =
Small change to accommodate changes made in CF7 3.9.

= 1.6 =
Quite a lot of code clean-up. This shouldn't result in any changes to the regular output, but it's worth checking your forms after updating. Also, you'll note that you now have the ability to add a custom CLASS and ID attributes when generating the Honeypot shortcode (in the CF7 form editor).

= 1.5 =
Added filter hook for greater extensibility. See installation section for more details.

= 1.4 =
Update to make compatible with WordPress 3.8 and CF7 3.6. Solves problem of unrendered honeypot shortcode appearing on contact forms.

= 1.3 =
Update to improve outputted HTML for better standards compliance when the same form appears multiple times on the same page.

= 1.2 =
Small update to add better i18n and WPML compatibility.

= 1.1 =
Small update for W3C compliance. Thanks [Jeff](http://wordpress.org/support/topic/plugin-contact-form-7-honeypot-not-w3c-compliant)</a>.

= 1.0.0 =
* Initial release.

== Upgrade Notice ==

= 2.1 =
New submission time check for better spam stopping (must be enabled). Recommended Update.

= 2.0.5 =
Fixes some backwards compatibility issues. Recommended update.

= 2.0.4 =
This fixes some php notices about missing settings. Recommended update.

= 2.0 =
Recommended update. Much improved spam-tracking support. Requires CF7 5.0+ and WordPress 4.8+.

= 1.8 =
Recommended update for all users using CF7 3.6 and above.

= 1.7 =
Recommended update for all users using CF7 3.6 and above.

= 1.6.3 =
Must update if running CF7 4.2 or above. If using less than CF7 4.2, use the v1.6.2 of this plugin.

= 1.6.2 =
Must update if running CF7 4.1 or above. Update also compatible with CF7 3.6 and above. If using less than CF7 3.6, use the v1.3 of this plugin.

= 1.6.1 =
Must update if running CF7 3.9 or above. Update also compatible with CF7 3.6 and above. If using less than CF7 3.6, use the v1.3 of this plugin.

= 1.6 =
New custom "class" and "id" attributes. Upgrade recommended if you are using CF7 3.6+, otherwise use v1.3 of this plugin.

= 1.5 =
Includes "showing shortcode" fix from version 1.4 and also includes new filter hook. Upgrade recommended.

= 1.4 =
Solves problem of unrendered honeypot shortcode appearing on contact forms. Upgrade immediately.