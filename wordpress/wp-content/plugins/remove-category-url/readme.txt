=== Remove Category URL ===
Contributors: valeriosza
Tags: categories, category base, category, permalinks, URL structure, links, seo, cms, wpml, URL
Requires at least: 3.1
Tested up to: 4.8.3
Stable tag: 1.1.2
License: GPLv2
Donate link: 

This plugin removes '/category' from your category permalinks. (e.g. `/category/my-category/` to `/my-category/`)

== Description ==

This plugin will completely remove the '/category/' from your permalinks ( e.g. `mydomain.com/category/my-category/` to `mydomain.com/my-category/` ).

No configuration is required

= Features =

1. Better and logical permalinks like `mydomain.com/my-category/` and `mydomain.com/my-category/my-post/`.
2. Simple plugin - No configuration is required.
3. No need to modify wordpress files.
4. Doesn't require other plugins to work.
5. Compatible with sitemap plugins.
6. Compatible with WPML.
7. Works with multiple sub-categories.
8. Works with WordPress Multisite.
9. Redirects old category permalinks to the new ones (301 redirect, good for SEO).

= Heads up: =

Read the [FAQ](https://wordpress.org/plugins/remove-category-url/faq/) before use.

Want to help? Use the [support](https://wordpress.org/support/plugin/remove-category-url)

== Installation ==

1. Upload `remove-category-url.zip` to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. That's it! You sould now be able to access your categories via http://mydomain.com/my-category/

== Frequently Asked Questions ==

= Why should I use this plugin? =

Use this plugin if you want to get rid of WordPress' "Category base" completely. The normal behaviour of WordPress is to add '/category' to your category permalinks if you leave "/category" blank in the Permalink settings. So your category links look like `mydomain.com/category/my-category/`. With this plugin your category links will look like `mydomain.com/my-category/` (or `mydomain.com/my-category/sub-category/` in case of sub categories).

= Will it break any other plugins? =

As far as I can tell, no. I have been using this on several blogs for a while and it doesn't break anything.

= Won't this conflict with pages? =

Simply don't have a page and category with the same slug. Even if they do have the same slug it won't break anything, just the category will get priority (Say if a category and page are both 'xyz' then `mydomain.com/xyz/` will give you the category). This can have an useful side-effect. Suppose you have a category 'news', you can add a page 'news' which will show up in the page navigation but will show the 'news' category.

= The plugin has been uninstalled, but the slug /category/ did not reappear why? =

A particular installation does not allow the rewrite feature in disabling the plugin. Try after disabling the plugin, save permanent links again.

== Screenshots ==

1. No Category URL

== Changelog ==

= 1.1.2 =
* Update

= 1.1.1 =
* Compatible with translate.wordpress.org

= 1.1 =
* Fix Erros

= 1.0.2 =
* Update Compatible with WPML.

= 0.1.1 =
* Add uninstall.

= 0.1.0 =
* Initial release.

== Upgrade Notice ==

= 1.1.1 =
* Compatible with translate.wordpress.org

= 1.0.2 =
* Update Compatible with WPML.

= 0.1.1 =
* Add uninstall.

= 0.1.0 =
* Initial release.
