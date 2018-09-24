# Optimization Plugin Modules

The [Above The Fold Optimization](https://wordpress.org/plugins/above-the-fold-optimization/) plugin can be made compatible with any optimization, minification or full page cache plugin by creating a module extension. The plugin contains several modules by default for some of the most used plugins.


## Creating a custom module

To add support for an unsupported plugin, you can copy the source of an existing plugin module and place it as a custom module in `/wp-content/themes/YOUR_THEME_NAME/abovethefold/plugins/plugin-name.inc.php` and accompany it with a text file named `plugin-name.active.txt` that contains the WordPress plugin reference name (usually `plugin-name/plugin-name.php`) which is used for fast checking the active state of the plugin.

Please submit new plugin modules or requests for default support for a plugin to info@pagespeed.pro.

## Maintainers

* [@optimalisatie](https://github.com/optimalisatie)

## License

(C) [www.pagespeed.pro](https://pagespeed.pro) 2014–2016, released under the MIT license
