# WordPress: Performance & Development tips

## Contents

- [WordPress: Performance & Development tips](#wordpress-performance--development-tips)
    - [Contents](#contents)
    - [Introduction](#introduction)
    - [System](#system)
        - [Operating system](#operating-system)
        - [HTTP Daemon](#http-daemon)
            - [Caching](#caching)
            - [HTTP/2 & HTTP/3](#http2--http3)
                - [NGINX](#nginx)
                - [Apache HTTPd](#apache-httpd)
            - [HTTP/2 Server Push](#http2-server-push)
                - [NGINX](#nginx-1)
                - [Apache HTTPd](#apache-httpd-1)
            - [Security](#security)
        - [PHP Interpreter](#php-interpreter)
            - [Opcodes](#opcodes)
        - [Database](#database)
        - [Redis](#redis)
    - [Wordpress](#wordpress)
        - [Core](#core)
        - [Extensions/Themes (Add-Ons)](#extensionsthemes-add-ons)
            - [Cache Enabler / LSCache / WP Rocket (paid plugin)…](#cache-enabler--lscache--wp-rocket-paid-plugin)
            - [WPS Cleaner / Optimize Database after Deleting Revisions / …](#wps-cleaner--optimize-database-after-deleting-revisions--)
            - [WooCommerce](#woocommerce)
            - [Your own extensions](#your-own-extensions)
        - [Theme](#theme)
            - [Set up a VCS](#set-up-a-vcs)
                - [Manage the theme as a submodule (Git)](#manage-the-theme-as-a-submodule-git)
            - [Optimize the code](#optimize-the-code)
                - [Xdebug](#xdebug)
            - [Various smaller optimizations](#various-smaller-optimizations)
                - [Cache language files](#cache-language-files)
                - [Cache menu accesses](#cache-menu-accesses)
                - [Cache various other things](#cache-various-other-things)
            - [Minify your CSS](#minify-your-css)
                - [SCSS to CSS to minified CSS](#scss-to-css-to-minified-css)
                    - [PhpStorm (JetBrains IDEs)](#phpstorm-jetbrains-ides)
                    - [Windows](#windows)
                    - [Unix (TODO)](#unix-todo)
                    - [Should you version control all this?](#should-you-version-control-all-this)
            - [Recompress your images](#recompress-your-images)
                - [CSS background-image](#css-background-image)
                - [On the server](#on-the-server)
                - [Locally](#locally)
            - [Optimize HTML/JS/CSS](#optimize-htmljscss)
                - [Cumulative Layout Shift](#cumulative-layout-shift)
                - [Lazy Load](#lazy-load)
                - [Preconnect](#preconnect)
            - [Check HTML/CSS](#check-htmlcss)
            - [FontAwesome trimming](#fontawesome-trimming)
            - [Bootstrap trimming](#bootstrap-trimming)
            - [Serve locally as much data as possible](#serve-locally-as-much-data-as-possible)
            - [Font splitting](#font-splitting)
        - [Check your logs for 404 queries](#check-your-logs-for-404-queries)
        - [Set your favicon.ico](#set-your-faviconico)
    - [Get away from WordPress](#get-away-from-wordpress)
    - [Other (non perf-related) useful things](#other-non-perf-related-useful-things)
        - [SSL](#ssl)
        - [Mailer Return-Path](#mailer-return-path)
        - [URL Change](#url-change)
        - [WP CLI](#wp-cli)
        - [Bedrock](#bedrock)
        - [Internationalization+Localization](#internationalizationlocalization)
            - [Preparing the PHP code (i18n)](#preparing-the-php-code-i18n)
            - [Translating (l10n)](#translating-l10n)
            - [Warning](#warning)
        - [Database backups](#database-backups)
        - [Preparing for PHP upgrades](#preparing-for-php-upgrades)
        - [Serving your local environment](#serving-your-local-environment)
        - [Fight spam](#fight-spam)
        - [Sidebars](#sidebars)
        - [Live Templates](#live-templates)
        - [Stay up to date!](#stay-up-to-date)
    - [Credits/Thanks/Notes](#creditsthanksnotes)
    - [Something else?](#something-else)




## Introduction

Each of the following points require some degree of experience, which is why if you're a beginner you shouldn't expect to
go through all this list in a few hours or even days, as it could take more for an experienced sysadmin developer.

The three main aspects are:

 * Server: do not make the server do the same thing too many times for no reason
 * Network: transfer only useful data and in an efficient way
 * Client: the easier websites can be rendered, the quicker they'll be displayed

This document becoming quite long, I added a TOC at the top: GitHub can't read it (yet), so view it through an editor that can, like [Typora](https://typora.io/) or [Calibre](https://calibre-ebook.com).

## System

### Operating system

Maybe the most difficult thing to change… DO NOT USE A WINDOWS SERVER.

First, because you'll be limited in your choices, and second because of the performance.

Once you get a local webserver on a powerful Windows machine several times slower than on a small Linux VPS, you understand this quite well.

On top of that, Microsoft is stopping official support of PHP [starting v8.0](https://news-web.php.net/php.internals/110907) (but builds are still available).

For Linux systems, just stay up-to-date.

On Debian and Ubuntu, [Ondřej Surý's repository](https://deb.sury.org/) will always have the latest PHP, Nginx and Apache2 versions for Debian/Ubuntu releases that aren't completely outdated. If you use his repository, don't forget to [give him a few bucks](https://www.patreon.com/oerdnj).

On RHCE/CentOS (and Fedora too but you wouldn't put that on a server), [Remi's RPM repository](https://rpms.remirepo.net/) is the way to go for recent releases (and here too you can donate to keep it alive, see the links in the website).

Containers and cloud environments are out of the scope of a big part of this gist, but Docker has [official images](https://hub.docker.com/_/php) for [all PHP versions still receiving support](https://github.com/docker-library/repo-info/tree/master/repos/php/remote) (right now, 7.4 to 8.1).

If you don't know anything about Linux you're in for a wild ride: good luck.

### HTTP Daemon

The second most difficult thing to change: Apache HTTPd is often the one installed by default, but it's not the fastest.

Try Nginx and/or OpenLiteSpeed, they have some benefits (one of which being caching: see below).

HTTP Daemons benchmark:

 * https://blog.litespeedtech.com/2018/03/05/compare-openlitespeed-to-nginx-and-apache/ (yes this is a biased one)

I should also mention the open source [H2O](https://h2o.examp1e.net/) server by the Japanese company DeNA, which also has [interesting benchmarks](https://h2o.examp1e.net/) and covers HTTP/1 to HTTP/3.

#### Caching

This part is especially important if you use builders (Divi, Elementor, …) as they tend to destroy performance.

Caching at the HTTPD level allows for the fastest kind of cache (outside of CDNs).

Nginx and OpenLiteSpeed both offer some kind of HTTPD-based cache for queries using PHP, with possible invalidation from inside WordPress (on new post/comment, on post edit, …) through plugins (respectively [Nginx Helper](https://wordpress.org/plugins/nginx-helper/) and [LiteSpeed Cache](https://wordpress.org/plugins/litespeed-cache/)).

With Nginx you'll need either Redis or the [ngx_cache_purge](https://github.com/FRiCKLE/ngx_cache_purge) module: with the second one you'd better pick a nginx from a repository that also offers the module, if you don't want to have to recompile it manually at each Nginx update.
To have some basic settings for WordPress (for instance, to exclude the cache for logged-in users), see this [LinuxBabe](https://www.linuxbabe.com/nginx/setup-nginx-fastcgi-cache) article or this one [at WP-Rocket](https://wp-rocket.me/blog/cache-dynamic-content-wordpress/).

As cache is invalidated through plugins, it can be set to a pretty high value (you can start with 48h).

Just don't forget to purge it manually if you change some elements (like the theme) outside of WordPress.

Be aware of a thing called "[nonces](https://developer.wordpress.org/plugins/security/nonces/)" (temporary verification values): if some plugins use them outside of logged-in areas (look for instances of the `wp_create_nonce` function), then you should limit the cache to [10h or less](https://legacy.joshpress.net/wordpress-nonces-and-wordpress-caching/).

If your website outputs different HTML for the same page depending on one or more non-URI HTTP query headers (Accept-Language, DNT, User-Agent (like AMP pages), …) you should include those variants in your fastcgi_cache_key setting, like here for mobile pages:

```nginx
set $device "pc";
if ($http_user_agent ~* "Android .+ Mobile|\(iPhone|\(iPod|IEMobile|Android; Mobile; .+Firefox|Windows Phone") {
	set $device "smart";
}
fastcgi_cache_key    "$device:$request_method:$scheme://$host$request_uri";
```

(this example is from the KUSANAGI-bundled Nginx default host configuration)

If you use [Polylang](https://wordpress.org/plugins/polylang/), [only cache](https://wordpress.org/support/topic/nginx-fastcgi_cache-and-polylang-homepage-redirect/) HTTP 200 responses to avoid caching language redirects:

```nginx
fastcgi_cache_valid 200 10h;
```

As it's a form of cache, let's mention CDNs here: they could also work as a (D)DoS mitigation tool.
Choosing the best one depends on the features you want, the price you're willing to pay and the performance you wish for your particular location: on [cdnperf.com](https://www.cdnperf.com/) you can compare them on a specific continent.

In case you use one, look into the required rules for the service you're using:

- [Example rules for Cloudflare with Wordpress](https://onlinemediamasters.com/cloudflare-page-rules-for-wordpress/) (keep in mind that the free plan only has 3 rules)
  - In the case of Cloudflare they can be avoided by using the [Cloudflare WordPress Plugin](https://wordpress.org/plugins/cloudflare/) which also handles targeted cache invalidation on WP actions ($5/month if you're using the Cloudflare free plan, included in the service otherwise)
  - The most important rule would be to bypass cache for content accessed with Wordpress/WooCommerce session cookies, as explained [in the Cloudflare docs](https://support.cloudflare.com/hc/en-us/articles/236166048-Caching-Static-HTML-with-WordPress-WooCommerce)… but "Bypass Cache on Cookie" is only available to Business ($200/Month) and Enterprise ($$$) customers.

#### HTTP/2 & HTTP/3

If you can and if it's not already done, enable HTTP/2 on your webserver (note that it requires HTTPS to be active).

It will give a way better speed especially if many files are served at once.

I suggest you to look at the [7 Tips for Faster HTTP/2 Performance](https://www.nginx.com/blog/7-tips-for-faster-http2-performance/) blog page over at NGINX to better understand how to adapt your code to it.

You can also prepare for HTTP/3 if you have OpenLiteSpeed, for even higher theoretical gains (out-of-the-box support in browsers is at [0%](https://caniuse.com/http3) at the moment, but it can be enabled manually in Firefox/Chrome/Safari).

##### NGINX

```nginx
server {
        listen       443 ssl http2;
```

##### Apache HTTPd

Install/enable the mod_http2 module depending on your OS/distribution tools (`a2enmod http2` on Debian) and then configure the VHost like this:

```apacheconf
<VirtualHost *:443>
        Protocols h2 http/1.1
```

#### HTTP/2 Server Push

NGINX's [implementation](https://www.nginx.com/blog/nginx-1-13-9-http2-server-push/) starting version 1.13.9, as well as the [http2 module for Apache HTTPd](https://httpd.apache.org/docs/2.4/howto/http2.html#push) 2.4, both support [HTTP/2 Server Push](https://en.wikipedia.org/wiki/HTTP/2_Server_Push), that you can take advantage in various ways to [serve the website quicker](https://blog.cloudflare.com/using-http-2-server-push-with-php/#effectofserverpush).
This is an optimization best suited for the end of a theme development lifecycle, when the chain of element dependencies is fully known.

On the application side, you have to add HTTP Link headers like this:

```php
header("Link: <{$image_path}>; rel=preload; as=image", false);
```

The "as" resource type list can be found [at MDN](https://developer.mozilla.org/en-US/docs/Web/HTML/Element/link#attr-as).

Another (long) article I'd recommend:

* [A Comprehensive Guide To HTTP/2 Server Push - Smashing Magazine](https://www.smashingmagazine.com/2017/04/guide-http2-server-push/)

##### NGINX

```nginx
location = /path {
    http2_push_preload on;
```

##### Apache HTTPd

No need to configure anything, the [H2Push Directive](https://httpd.apache.org/docs/2.4/mod/mod_http2.html#h2push) is enabled by default.

#### Security

This is not strictly related to performance and benefits all cases (not just WordPress).

You can add a layer of security in the HTTP daemon by using a WAF module:
 * Apache HTTPd: [ModSecurity](https://modsecurity.org/)
 * nginx: [NAXSI](https://github.com/nbs-system/naxsi) + wordpress.rules file from [naxsi-rules](https://github.com/nbs-system/naxsi-rules)

Some hosting providers have them in their hosting packages, sometimes under another name (to make clients think they did everything themselves).

### PHP Interpreter

If it's not already done, use PHP 7.4 or higher.

At the date of writing, any version prior to this one is not being [supported](https://www.php.net/supported-versions.php) anymore anyway.

Just by migrating from PHP 5.6 to 7.4 you can expect to serve 3 times more queries at the same time:

 * https://kinsta.com/blog/php-benchmarks/#wordpress-5-3-benchmarks

There are repositories to backport recent PHP versions to older distributions like Debian 9 or CentOS 7, and by taking advantage of PHP-FPM you can even get multiple versions of PHP running in parallel, to progressively test and migrate your hosted websites.

[PHP 8.0](https://www.php.net/releases/8.0/en.php), supported in WordPress 5.6+, [integrates a JIT compiler](https://kinsta.com/blog/php-8/#jit), which should allow for even greater gains with time (the gains are "only" ~5% for WordPress as of v8.0 compared to v7.4).

When upgrading the codebase for a new version of PHP, the website [php.watch](https://php.watch/) lists all changes you need to know.

#### Opcodes

PHP7 enables opcode caching by default, but you can speed it up by storing the opcodes on the disk (to avoid losing them at service restart).

My own settings, for reference only (always [read the docs](https://www.php.net/manual/en/opcache.configuration.php)) :

```ini
zend_extension=opcache.so
opcache.enable=1
opcache.enable_cli=0
opcache.memory_consumption=192
opcache.interned_strings_buffer=16
opcache.max_accelerated_files=16000
opcache.revalidate_freq=10
opcache.fast_shutdown=1
opcache.file_cache=/path/to/persistent/.opcache
```

### Database

WordPress only supports MySQL/MariaDB for the time being.

Use the MySQL Tuner script to help you adjust your server variables, after checking the effect they would produce:

 * https://github.com/major/MySQLTuner-perl/

You can put a mysqloptimize task in your crontab (every week or so) to make sure tables won't get too fragmented
(of course this advice has way less value if you have your data on a SSD, but fragmented DB files will take a bit more space in system memory cache).

I cannot show you any example here, as good values will depend on your server and WordPress situations and may change over time.

One general advice would be to disable DNS resolution by removing hostnames from the mysql.user table, and unless you depend on external scripts creating users with a "localhost" host when deploying a new website, [adding skip-name-resolve](https://nixcp.com/skip-name-resolve/) to the configuration file.
In this case, make sure that:

1. The DB_HOST configuration variable in your wp-config.php file is set to 127.0.0.1 and not localhost
2. The Host column in your mysql.user table for the WordPress DB user contains 127.0.0.1 and not localhost

(of course if your database is on another server, change accordingly)

Also, don't leave performance_schema always on: it has an [impact on performance](https://engineering.linecorp.com/en/blog/mysql-research-performance-schema-instruments/), besides using memory that would be better used for cache on servers with less RAM.

When troubleshooting for performance issues, enable the [slow query log](https://dev.mysql.com/doc/refman/8.0/en/slow-query-log.html) with the option to detect queries not using indexes:

```ini
slow_query_log = 1
slow_query_log_file = "/path/to/slow.log"
long_query_time = 1.0
log_queries_not_using_indexes = 1
```

With the resulting data you can use "[EXPLAIN](https://dev.mysql.com/doc/refman/8.0/en/explain.html) (bad query)" to try to find where the issue is (the theme, an extension, …).

You can also do that from inside MySQL Workbench, with varying degrees of success and interface crashes.

If you're really serious, enable the [general_log](https://dev.mysql.com/doc/refman/8.0/en/query-log.html) to log ALL queries done while you're accessing a problematic page, and process the result (with Perl/awk/Excel/…) to try to find what's up, especially to make a list of repeating queries.

### Redis

If you have enough free memory on your dedicated server or can use a paid option with your hosting company, WordPress can use a [Redis](https://redis.io/) caching service through plugins like [Redis Object Cache](https://wordpress.org/plugins/redis-cache/).

This would be especially useful for pages which bypass the HTTP daemon caching like those using sessions (logged-in user, WooCommerce, …).

Before this section gets expanded, I'll link to one tutorial:

* https://wp-rocket.me/blog/redis-full-page-cache-vs-nginx-fastcgi/

In this case, if server memory is short it could be a viable option to reduce the DB memory cache in favor of the Redis one.

If using Redis Object Cache, follow [these parameters](https://github.com/rhubarbgroup/redis-cache/wiki/Connection-Parameters) to access a different Redis database per accelerated website (thus, avoiding cache collisions), by putting in wp-config.php this setting:

```php
define( 'WP_REDIS_DATABASE', 0 ); // Change the number for each different website
```

## Wordpress

### Core

Don't touch WordPress's core files. If you want to change something there, push it upstream.

### Extensions/Themes (Add-Ons)

The less add-ons the better, unless said add-ons are there to limit the work done by WordPress.

One way to control which plugins are loaded where is to use the [Plugin Load Filter](https://wordpress.org/support/plugin/plugin-load-filter/reviews/) extension, but advanced matching through URL filtering (like for WooCommerce) is only possible with the [paid addon](https://celtislab.net/en/wp-plugin-load-filter-addon/) ($44) and side effects of plugin filtering can be hard to predict, so thorough testing should be done.

Builders like Elementor or Divi can destroy a website's loading time, but this guide should give enough tips to mitigate this.
Using the integrated Gutenberg editor instead would still be best performance-wise: see [this other guide](https://gist.github.com/Ruzgfpegk/1fd16dcdaeb4efbf16ca3b81d3c1a243) by yours truly if you're planning on starting a new Gutenberg block without any prior knowledge.

"Cleanup" extensions can be enabled only when needed (why not through WP-CLI for cron'ed maintenance, if those extensions also extend WP-CLI).

Security-wise, even files from disabled add-ons can be "executed" from the Internet, so if they contain security issues you may be at risk.

WordPress 5.5+ allows automatic updates of extensions and themes, so (unless special cases, like add-ons function overrides from inside your theme) you should take advantage of this feature.

The WordFence plugin can scan your outdated add-ons against the [WPScan Vulnerability Database](https://wpvulndb.com/), to help you decide if keeping an older version for a while longer poses a threat or not.
WordFence also integrates a WAF to block login bruteforce attempts which can take some CPU cycles, as cache is usually off with POST/GET requests or on important pages like wp-login.php or xmlrpc.php which are the ones used for bruteforce attacks.

#### Cache Enabler / LSCache / WP Rocket (paid plugin)…

Some extensions are there to cache generated pages, to avoid to have to "recompute" the whole WordPress infrastructure at each query.

Use them.

#### WPS Cleaner / Optimize Database after Deleting Revisions / …

The WordPress database has a bad habit of accumulating data that's probably useless to you.

Do some housekeeping from time to time (deleting old revisions for instance).

You can also limit old revisions from the beginning with a setting in the wp-config.php file (here with 5 revisions):
```php
define( 'WP_POST_REVISIONS', 5 );
```

Or completely disable revisions if you know what you're doing:
```php
define( 'WP_POST_REVISIONS', false );
```

#### Query Monitor

A useful plugin to find performance issues is [Query Monitor](https://querymonitor.com/).
I'd advise it to use it before doing profiling (see Xdebug section below), as it could help you identify issues quickly.

#### WooCommerce

We talked about extensions that can speed up Wordpress, but there are also those… that slow it down.

WooCommerce is one of those, as it loads its files in every page even when it's not needed.

A "quick fix" can be found in this article by Neil Gowran on his website WP Beaches:

* [Remove WooCommerce CSS Styles and Scripts From Pages That Don’t Need It](https://wpbeaches.com/override-woocommerce-css-styles-conditionally/)

```php
add_action( 'template_redirect', 'remove_woocommerce_styles_scripts', 999 );

function remove_woocommerce_styles_scripts() {
	if ( \function_exists( 'is_woocommerce' ) && ! is_woocommerce() && ! is_cart() && ! is_checkout() ) {
		remove_action( 'wp_enqueue_scripts',      [ WC_Frontend_Scripts::class, 'load_scripts' ] );
		remove_action( 'wp_print_scripts',        [ WC_Frontend_Scripts::class, 'localize_printed_scripts' ], 5 );
		remove_action( 'wp_print_footer_scripts', [ WC_Frontend_Scripts::class, 'localize_printed_scripts' ], 5 );
	}
}
```

Add this to your theme's functions.php and don't forget to add `use WC_Frontend_Scripts;` and to call the function using your namespace if you're using a custom namespace.

Sadly this doesn't remove styles and scripts added by WooCommerce plugins, but you already avoid (at time of writing) 15 HTTP queries and ~230Kb of data.

Once you've done this, I don't think there's a safe way to avoid all the additional SQL queries… this is where Redis could make a difference.

#### Your own extensions

If you follow the [Plugin Handbook](https://developer.wordpress.org/plugins/), especially the "Plugin Security" part, I guess things should go well.

If your plugin uses custom tables (see the [relevant Codex article](https://codex.wordpress.org/Creating_Tables_with_Plugins) to create them), be very careful to use indexes where it's needed (usually columns that will end up in a `WHERE columnName='something'`).

If you need raw SQL queries (like when using custom tables) with the [global $wpdb](https://developer.wordpress.org/reference/classes/wpdb/), prepared statements will be used everywhere except when using the `query()` method (in which case, [prepare the statement](https://developer.wordpress.org/reference/classes/wpdb/#protect-queries-against-sql-injection-attacks) with the `prepare()` method).

If a plugin script is only made to be executed from the command-line, add a check such as this one at/near the beginning:

```php
if ( PHP_SAPI !== 'cli' ) {
   exit ( 'This script is made to be executed from the command line only!' );
}
```

If such a script only needs to access basic WordPress functions, you can load the bare minimum like this:

```php
define( 'SHORTINIT', true ); // We only want to load base WordPress (see wp-settings.php)
require( '../../../wp-load.php' ); // To be able to use $wpdb, ABSPATH, ...
```

…then add other `require()` from wp-settings.php as needed.

### Theme

#### Set up a VCS

I can't make too many assumptions about who you are, what you know and your role in all this mess.
It's possible that you never used any Version Control System to keep track of changes up to now, and if that's the case you should learn how they work and how to use them.
Maybe you got access to the theme repository, in which case it would be a good idea to continue where your predecessors left off and keep using it.

IDEs usually have their own VCS support, and there are native tools (TortoiseGit, …) that can do the job well too.

In the (probable) case you're using Git, here are some interesting resources:

* [The Git Parable](https://tom.preston-werner.com/2009/05/19/the-git-parable.html) (metaphorical explanation on the inner Git workings, for beginners)
* [A Visual Git Reference](https://marklodato.github.io/visual-git-guide/index-en.html) (once you've understood the concepts, see how they translate to Git)
* [Pro Git](https://git-scm.com/book/en/v2) (maybe the closest thing to an official book)
* [JRebel Git Cheat Sheet](https://www.jrebel.com/blog/git-cheat-sheet) (to print and keep somewhere on your desk, PDF file at the bottom of the page)
* [Conventional Commits](https://www.conventionalcommits.org/en/v1.0.0/) (a tentative convention for commit messages) ([short summary](https://gist.github.com/joshbuchea/6f47e86d2510bce28f8e7f42ae84c716))

If you're using SVN, you can also convert the repository to Git with `git svn` or TortoiseGit's `Git Clone… / From SVN Repository`.

##### Manage the theme as a submodule (Git)

When using Git, you can specify that a folder is a "shortcut" to another repository, which allows to modularize development.
With WordPress it can be one way to keep a deployment pipeline as clean as possible even if it comes with a few pitfalls (that you can read about [in this article](https://medium.com/@porteneuve/mastering-git-submodules-34c65e940407)).

The short version of this [GitHub.com article](https://docs.github.com/en/github/using-git/splitting-a-subfolder-out-into-a-new-repository):

```bash
# Clone your existing project into a new folder
$ git clone https://path/to/bigrepo.git
$ cd bigrepo
# Filter everything outside the theme and make it the new root
$ git filter-branch --prune-empty --subdirectory-filter DocumentRoot/wp-content/themes/yourtheme -- --all
# Switch the origin to the new empty theme repository and push
$ git remote set-url origin https://path/to/themerepo.git
$ git push -u origin
```

If you renamed your theme folder at some point, changes before the renames won't be carried over in the new history.
Maybe for this kind of cases you'd better use the [git-filter-repo](https://github.com/newren/git-filter-repo/) script (with the "--path-rename" option I guess?).

Now if you want to integrate this new repository inside the intact "big repo" you can delete the theme folder, commit, add the submodule (this will create a new .gitmodules file at the root of the project), and commit once again:

```bash
# Git delete the theme folder the way you want, then in the original repo folder:
$ git commit -m "Removed folder for theme yourtheme"
$ git submodule add https://path/to/themerepo.git DocumentRoot/wp-content/themes/yourtheme
$ git commit -m "Added submodule for theme yourtheme"
$ git push
```

Now all git operations related to the theme will have to be entered from its folder or a lower subfolder (committing at the project root level would only take the "big repo" code into account and not the theme one).
IDEs usually take care of this, but don't forget that if you work on CLI or TortoiseGit.
The master project will link the submodule folder to one of the submodule commits (the "[super project](https://en.wikibooks.org/wiki/Git/Submodules_and_Superprojects) pointer"), so this is one other thing to be wary about: after committing the submodule, also commit the superproject to make sure it points to the latest committed version of the submodule.

If you don't want the pointer to have "[dirty](https://stackoverflow.com/questions/41596529/what-is-a-dirty-submodule/41598706)" at the end of its name when there are untracked files (for instance), add this to the .gitmodules file at the root of the project, under the relevant [submodule] section:

```ini
	ignore = dirty
```

And, or course, make sure that the git files (.git folder, .gitignore file, …) are in the ignored list of files during deployment.

#### Optimize the code

You probably inherited a theme made by someone else.

This someone else was probably paid way better than you, for a horrible result.

Use the feedback provided by your IDE (Eclipse, PhpStorm, …) and/or pipeline tools (PHPCS, PHPMD, …).

Some may find it bad practice, but I prefer to set such tools locally as global packages for Composer:
(after installing Composer) [(Windows)](https://getcomposer.org/doc/00-intro.md#installation-windows)

Here's my own usual list of packages typically used with WordPress projects, for reference:
```bat
composer global require squizlabs/php_codesniffer
composer global require automattic/phpcs-neutron-standard
composer global require automattic/phpcs-neutron-ruleset
composer global require dealerdirect/phpcodesniffer-composer-installer
composer global require phpmd/phpmd
composer global require phpstan/phpstan
composer global require szepeviktor/phpstan-wordpress
composer global require php-stubs/woocommerce-stubs
```

Packages with then be stored in your local user folder (for Windows: %APPDATA%\Composer\vendor).

And don't forget to update both Composer and the packages from time to time:
```bat
composer global self-update
composer global update --optimize-autoloader
```

Here's a sample [PHPStan](https://phpstan.org/user-guide/getting-started) configuration file for WordPress you'd need to place at the root of your project (its default name being phpstan.neon), once the dependencies above are installed (%rootDir% below being the root folder of PHPStan, like "/path/to/vendor/phpstan/phpstan"):
```neon
includes:
  - phar://phpstan.phar/conf/bleedingEdge.neon
  - %rootDir%/../../szepeviktor/phpstan-wordpress/extension.neon

parameters:
  level: max
  inferPrivatePropertyTypeFromConstructor: true
  parallel:
    maximumNumberOfProcesses: 4
  
  scanDirectories:
    - DocumentRoot/wp-content/themes/parent_theme_if_there_is_one
    - DocumentRoot/wp-content/plugins/plugin_used_by_the_theme
  
  paths:
    - DocumentRoot/wp-content/themes/theme_to_check
  
  ignoreErrors:
    - '#^Function apply_filters(_ref_array)? invoked with [34567] parameters, 2 required\.$#'
  
  bootstrapFiles:
    # php-stubs/wordpress-stubs/wordpress-stubs.php is already loaded by szepeviktor/phpstan-wordpress
    # Uncomment the following as needed:
    #- %rootDir%/../../php-stubs/woocommerce-stubs/woocommerce-stubs.php
    #- %rootDir%/../../php-stubs/woocommerce-stubs/woocommerce-packages-stubs.php

  excludes_analyse:
    #- DocumentRoot/wp-content/themes/theme_to_check/folder_to_ignore
```

You'd then launch the analyze from the console at the root of your folder by typing:
```bat
> phpstan analyse
```

For JetBrains IDE users, the plugin [Php Inspections (EA Extended)](https://plugins.jetbrains.com/plugin/7622-php-inspections-ea-extended-) or its paid variant [Php Inspections (EA Ultimate)](https://plugins.jetbrains.com/plugin/16935-php-inspections-ea-ultimate-/) can help a lot, on top of other inspectors, to clean up the code, for instance locating cases of 

```php
for(
	$i = 0;
	$i <= slow_function_called_every_time_for_the_same_result(); 
	$i++) { stuff(); }
```

and helping you turn them into this:

```php
$target = slow_function_only_called_once();
for( $i = 0; $i <= $target; $i++) { stuff(); }
```

The static analyzers PHPStan and [Psalm](https://psalm.dev/) are supported natively in PhpStorm 2020.3 and up (Psalm also has [WordPress support](https://packagist.org/packages/humanmade/psalm-plugin-wordpress)).

If the website got slower with time, there are chances that there's a weird O(n^2) loop somewhere.

Beware of multilingual plugins like qTranslate X (which is abandoned by the way), especially when used in conjunction with search tools.

Get a decent knowledge of the [various WordPress functions](https://developer.wordpress.org/reference/), are they can be used in completely backwards ways by people who don't read the docs beyond the first result.

Limit function calls: if functions like get_stylesheet_directory_uri() are called at each resource path in a page, put their values in variables and use those instead.
You could declare them in functions.php and set them as global:

```php
global $templateDirectoryUri, $stylesheetDirectoryUri;
$templateDirectoryUri   = get_template_directory_uri();   // Parent theme path if applicable, "normal" if not
$stylesheetDirectoryUri = get_stylesheet_directory_uri(); // Child theme path if applicable, "normal" if not
```

And then in other theme files:

```php+HTML
<?php
global $templateDirectoryUri, $stylesheetDirectoryUri;
?>
<!-- [...] -->
<meta name="thumbnail" content="<?= $stylesheetDirectoryUri ?>/images/thumbnail-top.jpg" />
```

[PHP: The Right Way](https://phptherightway.com/) is a good resource on how to produce "modern" PHP, and if you delve in more serious coding (especially when writing plugins) it may be a good idea to brush up on your Design Patterns knowledge with [DesignPatternsPHP](https://designpatternsphp.readthedocs.io/en/latest/README.html).

You can also check the compliance of your theme against current WordPress standards by using the [Theme Check](https://wordpress.org/plugins/theme-check/) plugin.

##### Xdebug

If you need to troubleshoot performance issues or application bugs, install [Xdebug](https://xdebug.org/) on a server (preferably a test or development one) and set it up.

As always, [read the docs](https://xdebug.org/docs/all_settings). You may need to learn how to use it from inside your IDE.

My own usual settings for Xdebug v2 are:

```ini
zend_extension = xdebug.so
xdebug.remote_enable = On
xdebug.remote_port = 9000
xdebug.profiler_enable = off
xdebug.profiler_enable_trigger = On
xdebug.profiler_enable_trigger_value = YOUR_OWN_PROFILE_TRIGGER
xdebug.profiler_output_name = cachegrind.out.%t.%p
xdebug.profiler_output_dir = "/tmp"
xdebug.trace_enable_trigger = On
xdebug.trace_enable_trigger_value = YOUR_OWN_TRACE_TRIGGER
xdebug.trace_output_name = trace.%H.%p
xdebug.trace_output_dir = "/tmp"
xdebug.show_local_vars = 0
```

Which translates in Xdebug v3 as (see the [upgrade guide](https://xdebug.org/docs/upgrade_guide)):

```ini
zend_extension = xdebug
xdebug.mode = profile,trace
xdebug.start_with_request = trigger
xdebug.trigger_value = "YOUR_OWN_TRIGGER"
xdebug.output_dir = "/tmp"
xdebug.client_port = 9003
xdebug.profiler_output_name = cachegrind.out.%t.%p
xdebug.trace_output_name = trace.%H.%p
xdebug.show_local_vars = 0
```

Combine it with XDebug Helper [for Firefox](https://addons.mozilla.org/en-GB/firefox/addon/xdebug-helper-for-firefox/) or [for Chrome](https://chrome.google.com/webstore/detail/xdebug-helper/eadndfjplgieldjbigjakmdgkmoaaaoc), generate a trace and/or a profile, and analyze them.

A profile will lead you to the parts of the code taking the most time to execute (or being executed the most), and the trace will list everything that's being done for one query.

It may take time, but you can find some weird shit through this process.

The PhpStorm IDE is a good tool to analyze a profiling session, but it's not the only one.

Note that PhpStorm can [be integrated](https://www.jetbrains.com/help/phpstorm/configuring-xdebug.html) with XDebug for real-time debugging if you're tired of using var_dump().

To examine traces made by XDebug, the cross-platform [xdebug-trace-viewer](https://github.com/kuun/xdebug-trace-viewer) tool can be used (you just have to use xdebug.trace_format=1).

##### Note about Docker

If you run PHP under a Docker container, be aware that your profiling sessions could be [quite distorted](https://pythonspeed.com/articles/docker-performance-overhead/) due to an [outdated seccomp library](https://github.com/moby/moby/issues/41389) containing a bug impacting performance with Python: it shouldn't be too far-fetched to imagine that other interpreters would be impacted too.
As the first link points out, you could run your container with the ``--privileged`` parameter to bypass seccomp.
Watch the second link to follow when Docker integrates the bugfix.

#### Various smaller optimizations

##### Cache language files

Put [this file](https://gist.github.com/soderlind/610a9b24dbf95a678c3e) in your mu-plugins folder.

By default, WordPress parses MO (language) files each time. Which is stupid.

This small plugin caches the result in the database as transients, way faster to fetch and decode.

This is especially useful if you have a lot of localized text (WooCommerce, builders, …), as you're essentially trading php::unpack and php::explode (to read MO files) for php::unserialize (to decode transients).
In an example case, I went from ~168K function calls (to decode MOs) (MO->import_from_loader taking ~3,3s) to 360 function calls taking 146ms (to unserialize the DB contents).
On the memory side, for this example MO->import_from_loader took ~100 MB and php::unserialize ~73MB.

But this approach takes more space in the database, so this is another trade-off to keep in mind.

##### Cache menu accesses

If you use menus they're also recomputed each time, which can lead up to a lot of DB calls.

Follow [this guide](https://generatewp.com/how-to-use-transients-to-speed-up-wordpress-menus/) to store them into transients in database for a given time.

I personally prefer the quick way, but do what's best for your case.

##### Cache various other things

Outside of menus, you may have other things you don't want to recompute each time.

Transients are once again the answer. This [code example from the WP documentation](https://developer.wordpress.org/apis/handbook/transients/#complete-example) covers most use cases:

```php
// Get any existing copy of our transient data
if ( false === ( $special_query_results = get_transient( 'special_query_results' ) ) ) {
    // It wasn't there, so regenerate the data and save the transient
    $special_query_results = new WP_Query( 'cat=5&amp;order=random&amp;tag=tech&amp;post_meta_key=thumbnail' );
    set_transient( 'special_query_results', $special_query_results, 12 * HOUR_IN_SECONDS );
}
// Use the data like you would have normally…
```

To go a step further, instead of saving WordPress objects you can also save the pre-rendered HTML for a whole section if you know what you're doing (for instance, no translated text stored in there unless you put the user language in the transient name).

In this last case you'd use output buffering functions (`ob_start();`, echoing the output, then `$ob_saved = ob_get_clean();` ) as in the "Cache menu accesses" example above.

#### Minify your CSS

If you have a legacy CSS file, it can be easier to maintain once transformed into a SCSS file:

 * https://www.css2scss.com/ (online converter)
 * https://github.com/ortic/css2scss

The resulting SCSS file will then need to be passed to the SASS executable to produce a CSS file:

 * https://sass-lang.com/ (or `npm install -g sass`)

The SCSS -> CSS -> Minified CSS process can be automated with File Watchers in PhpStorm or assisted through scripts (see below).

SCSS can also be used to add modularity, splitting the SCSS files (like one to define variables, another for global rules, one for each type of content, …).

But whether you use SCSS or not, the first step would be to add a CSS Minifier in your workflow.

The best Swiss Army Knife to do that is [PostCSS](https://github.com/postcss/postcss), as it has [a shitton of addons](https://www.postcss.parts/).

You'll need the npm command which is included in NodeJS, so [download/install it](https://nodejs.org) first.

Quick install commands (globally, after npm is installed) of everything I personally use:

````bash
> npm install -g postcss-cli
> npm install -g postcss-combine-media-query
> npm install -g cssnano
> npm install -g purgecss
````

 * [postcss-cli](https://github.com/postcss/postcss-cli): to use postcss via CLI
 * [postcss-combine-media-query](https://github.com/SassNinja/postcss-combine-media-query): to recombine at the end of the file all @media rules inside the CSS (having them inline is easier to manage in SCSS but the output is ugly)
 * [cssnano](https://cssnano.co/): to shrink the CSS as much as possible, using default rules
 * [purgecss](https://purgecss.com/CLI.html): command to remove from a CSS file the rules that weren't detected in manually saved html files (install [fullhuman/postcss-purgecss](https://github.com/FullHuman/postcss-purgecss) if you want to integrate it to postcss, but I prefer doing that manually)

As a quick side note, don't forget to periodically update your packages with:

````bash
> npm update -g 
````

##### SCSS to CSS to minified CSS

###### PhpStorm (JetBrains IDEs)

A file watcher preset already exists for the SCSS to CSS process.

But you still need to make one for postcss. 

As the packages are installed globally (profile-wide), the program path becomes (if using Windows, else adjust) (for Windows this folder should be added by NodeJS in the %PATH%, so only the command should be enough): 

`C:\Users\(current user)\AppData\Roaming\npm\postcss`

Arguments (the "combine media query" plugin being useful only in a few cases):

`--map --no-map --use postcss-combine-media-query --use cssnano --output $FileNameWithoutExtension$.min.css $FileName$`

Output path to refresh: `$FileNameWithoutExtension$.min.css`

Working directory: `$FileDir$`

(note that if you use modular SCSS files, if you save a "child" file the main one will [only be recompiled starting 2020.2.2 versions](https://youtrack.jetbrains.com/issue/WEB-42904) so on older versions you'd have to add garbage like empty comments in the main SCSS to trigger the file watcher)

###### Windows

If you don't use JetBrains IDEs, you can also prepare a command-line script.

Windows version (.bat) :

```bat
@ECHO OFF

REM Usage: SCSS_to_CSS_to_MINCSS.bat file.scss
REM (a drag-and-drop of the SCSS file over this script also works)

REM First install NodeJS ( https://nodejs.org/ )
REM Then install the SCSS/CSS tools in a terminal (as Admin):
REM > npm install -g sass postcss-cli postcss-combine-media-query cssnano


REM Batch parameters reference can be found in "CALL /?" or "FOR /?".

REM Go to path of the CSS file (first argument)
CD /D "%~d1%~p1"

REM Sass: set input to file.scss and output to file.css
CALL sass "%1":"%~n1.css"

REM PostCSS: Using the Combine Media Query and CSSnano extensions, generate a minified CSS with its map file (externally, not inside the CSS)
CALL postcss --map --no-map --use postcss-combine-media-query --use cssnano --output "%~n1.min.css" "%~n1.css"
```

Of course, as above, change it according to your needs.

###### Unix (TODO)

Unix version (.sh) :

```bash
#!/bin/env sh
# TODO
```

###### Should you version control all this?

You could, but it would be a waste of space.

A better way would be to ignore processed files while giving a way to quickly generate them outside File Watchers.

Let's say you have your scss files in the /css folder, you'd then ignore processed files like this in your .gitignore at the theme root:

```
/css/*.css*
```

…and would have those script entries in your composer.json (again, following the above examples):

```json
  "scripts": {
    "buildallcss": "sass --update css",
    "minallcss": "postcss css/*.css --map --no-map --use postcss-combine-media-query --use cssnano --dir css --ext min.css"
  }
```

A new developer would then have to do "composer buildallcss && composer minallcss" in the theme root to get them all back, or run it through the IDE's actions ("Run/Debug Configurations" in PhpStorm).
In case File Watchers are part of the shared configuration in the VCS, only the first command would be needed as it would trigger the watchers for the second one.

An added bonus of the composer scripts is that they could be used in the deployment pipeline too.

#### Recompress your images

It's one of the simplest things to do.

For best results do that yourself, if possible from lossless source images (see below).

If a FullHD image is displayed with a size of 320x240, downsize it (while keeping the "twice the pixels" rule if Retina displays are targeted). [Imsanity](https://wordpress.org/plugins/imsanity/) does the job well (as a light version of [EWWW Image Optimizer](https://wordpress.org/plugins/ewww-image-optimizer/)).
Use PNG for most logos, JPG ~85% for most of the rest.

I don't think you need me to know that, but still.

I'd advise you to integrate Google's WebP in your workflow but at the moment its support is not universal, Apple only supporting it since Safari 14: its support is "only" [94.58% worldwide](https://caniuse.com/webp) as of November 2022.

So you should replace the original `<img>` tag with this fallback in the form of a `<picture>` tag like this:

```html
<picture>
    <source srcset="img/logo.avif" type="image/avif">
    <source srcset="img/logo.webp" type="image/webp">
    <source srcset="img/logo.png" type="image/png"> <!-- or type="image/jpeg" if JPG -->
    <img src="img/logo.png" alt="Logo">
</picture>
```

This way, browsers will look into each `<source>` and retrieve the first supported one, and if the user browser is too old to understand the `<picture>` tag then it will understand the fallback `<img>` tag (yeah, it's a fallback of a fallback).
The last <source> tag is more and more omitted.

You can also add a [JS WebP decoder](https://webpjs.appspot.com/) instead… or [a polyfill](https://github.com/chase-moskal/webp-hero).

And if you want to be even more ahead of the curve, convert your images to [AVIF](https://jakearchibald.com/2020/avif-has-landed/) (see below for the tools).
Support for AVIF is [very correct right now](https://caniuse.com/avif) (76.12% worldwide as of November 2022) (support is in Chrome and Firefox, as usual Apple and Microsoft are lagging behind). There's also a [polyfill for AVIF](https://github.com/Kagami/avif.js).
The source type for AVIF is "image/avif".

One drawback of those two formats is that they lack the "progressive" rendering of JPG (but progressive images use the CPU more…).
It could come to AVIF one day (check this [issue](https://github.com/AOMediaCodec/av1-avif/issues/102)), but in the meantime if this is an important feature for you then you should prepare the viewport with a CSS background (color or [gradient](https://developer.mozilla.org/en-US/docs/Web/CSS/gradient), image, …) to visually ease the transition:

```scss
#logo_img_container {
	background-color: $overall_color_of_the_photo; // Seen first
	background-image: url('../img/photo_low_quality.jpg'); // Seen second (before the normal <img> loads)
	background-repeat: no-repeat;
	background-size: cover;
}
```

You should also check that your webserver recognizes the AVIF extension, because if not then some browsers (…Firefox) wouldn't try to display the AVIF file but instead download it.

For NGINX, either add an entry to mime.types (risky if overridden by an update), [add the type to your nginx.conf](https://stackoverflow.com/questions/16789494/extending-default-nginx-mime-types-file/) (also risky) or add this to the VHost settings:

```nginx
server {
	[...]
	location ~* \.avif$ {
		add_header Content-Type image/avif;
	}
```

For Apache HTTPd, in your VHost settings or a .htaccess file:

```apacheconf
AddType image/avif avif
```

[WebP v2](https://www.phoronix.com/scan.php?page=news_item&px=Google-Experimental-WebP2) was announced [then canned](https://chromium.googlesource.com/codecs/libwebp2/+/1251ca748c17278961c0d0059b744595b35a4943%5E%21/), so it's not an option anymore.

As for the very promising [JPEG XL](http://sneyers.info/jxl/), support is only starting, with Serif adding support in their Affinity line of editing software starting with their versions 2, while optional support in Chrome got removed in version 110 [for incomprehensible reasons](https://bugs.chromium.org/p/chromium/issues/detail?id=1178058) that look like sabotage from "team WebP".

[Squoosh](https://squoosh.app/) can generate JPEG XL images.

###### CSS background-image

This case is a bit of a pain. Outside of the fact that lazy loading doesn't work (unless you add [more JS](https://web.dev/lazy-loading-images/#images-css)), you can only have one background-image property in a CSS selector.

If you're only interested in WebP, go to the [Modernizr](https://modernizr.com/) website, select the WebP functionalities you want to check (webp and webp-lossless would be enough I guess), click BUILD on the upper right side and save the JS file in your theme.

If you want to check for AVIF, the functionality is in the project but not on the website so you'll have to do it yourself locally:

1. Clone the [Modernizr repository](https://github.com/Modernizr/Modernizr).

2. Go to the root directory and fetch the project dependencies:

   ```bash
   $ npm install
   ```

3. Create a config file with the wished checks (let's call it "modernizr-media-config.json"):

   ```json
   {
     "minify": true,
     "options": [
       "setClasses"
     ],
     "feature-detects": [
       "img/webp-lossless",
       "img/webp",
       "img/avif"
     ]
   }
   ```

4. Execute the generator:

   ```
   $ bin\modernizr -c modernizr-media-config.json
   ```

5. Retrieve the modernizr.js file that has been created.

   

Once it's done, import it along with other JS files in your functions.php with a relevant name:

```php
wp_enqueue_script( 'modernizer-img', get_stylesheet_directory_uri() . '/js/modernizr-img.min.js' );
```

Some classes should then be added (client-side) to the <html> element (like "avif webp webp-lossless").

With this you can then override the CSS background-image property like this:

```CSS
/* Standard element with all properties and fallback image */
.element {
  color: #FFF;
  background-image: url("../img/logo.jpg");
  background-repeat: no-repeat;
  background-position: center center;
  background-size: cover;
}

/* Optimized selectors that can be set before or after the standard one */
/* They are more precise so their contents have more weight */
/* Their order will depend on the order of classes added to the html tag: later ones have more weight. */

.webp .element {
  background-image: url("../img/logo.webp");
}

.avif .element {
  background-image: url("../img/logo.avif");
}
```

When you add the background-image directly into your HTML (<div ... style="background-image: url(...)">), you can neither use lazy loading nor alternative formats.

Also, note that the images can only start to download once the corresponding CSS file is read so you might want to preload it first in your <head> (while keeping in mind that it's [disabled by default in Firefox](https://caniuse.com/link-rel-preload)):

```php+HTML
<link rel="preload" href="<?= esc_url( $templateDirectoryUri ) ?>/css/cssContainingBGImages.min.css" as="style">
```

##### On the server

Existing plugins for WordPress could do the job, with varying degrees of quality.

A good extension to do that is [WebP Express](https://wordpress.org/plugins/webp-express/), which can use a local cwebp encoder and supports Apache/OpenLiteSpeed/nginx (rewrite rules, as well as on-the-fly HTML rewriting to add the picture tag when appropriate).

If you have gigantic source images (you shouldn't), adjust max_execution_time in your PHP config or request_terminate_timeout in your PHP-FPM config (temporarily if doing a batch conversion).

##### Locally

Do not trust standard export features of Photoshop and the likes (they are, to stay polite, usually very bad), and always reprocess them afterwards.

A few applications exist.

To convert to WebP, you could use the multi-platform [XnViewMP](https://www.xnview.com/en/xnviewmp/)'s File/Export… and tweak while you look at the output image quality and size: a good quality setting for one image may not be the best for another, and a lossless file could be lighter than a lossy file in some cases (usually files that would have been PNGs otherwise, like icons).

To convert to AVIF, you can use the in-browser [Squoosh](https://squoosh.app/) tool (encoding is done locally in JS+WebAssembly) or the [go-avif](https://github.com/Kagami/go-avif) encoder, and add a source tag as shown above.

For JPG and PNG files it's a bit different.

For Linux and MacOS, [Trimage](https://trimage.org/) is a good way to quickly remove useless metadata and recompress (losslessly) using jpegoptim, optipng and pngcrush ([commands in the source code](https://github.com/Kilian/Trimage/blob/master/trimage/trimage.py#L367)).

For all OSes, the compiled version of imagemin, [imagemin-app](https://github.com/imagemin/imagemin-app), may be the best choice to very quickly reduce the sizes of JPGs, PNGs and even GIFs (but it does so in a destructive manner, reducing PNG's color depth to 8-bit for instance).
I haven't seen very good results for JPGs but maybe my files were "good enough" from the beginning.

The best results I had with PNG files were by running manually [Pngcrush](https://pmt.sourceforge.io/pngcrush/) in CLI (Windows binaries [here](https://sourceforge.net/projects/pmt/files/pngcrush-executables/1.8.11/)) (use/adapt the bat/sh files in [this repo](https://github.com/Kjuly/pngcrush) for an easier time) but [OxiPNG](https://github.com/shssoichiro/oxipng) (Rust rewrite of OptiPNG) is also included in Squoosh (mentioned earlier). Unless you reduce the palette, this should be a lossless operation.

As for SVGs, you can usually strip them of useless information with tools like [SVGOMG](https://jakearchibald.github.io/svgomg/) (that you can also run locally, see instructions on the [project's README](https://github.com/jakearchibald/svgomg/blob/master/README.md)).
Sometimes you may have a SVG containing only binary image in base64… which look like this:

```xml
<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="63" height="400" viewBox="0 0 63 400">
  <image id="example.svg" width="63" height="400" xlink:href="data:img/png;base64,iVBORw0KGgoAAAANSU[...]II="/>
</svg>
```

In this case, it's a way better idea to extract the data: copy the string starting with "data:img" up to the end (here, "=") and paste it into a Chromium or Firefox-based browser's URL bar: the file that will be saved will be the "real" (and smaller) binary image.
If said image is a PNG (like the example), you can optimize it further with Pngcrush or OxiPNG.

For GIFs, there's [Gifsicle](http://www.lcdf.org/gifsicle/)'s optimization mode (-O1 to -O3) in batch mode (see the [man page](http://www.lcdf.org/gifsicle/man.html)):

```bash
gifsicle --batch -O3 path/to/*.gif
```



#### Optimize HTML/JS/CSS

Part of it can be done through WP Rocket or similar.

Use Google's lighthouse through [web.dev](https://web.dev/measure/) to get various useful metrics.

The developer tools in the browser can show if something really slows down the rendering process.

If your CSS is still using the "old flexbox" (display: box) (which is always possible if it's an old theme), try to port it to the "new flexbox" instead (display: flex), which is [twice faster](https://developers.google.com/web/updates/2013/10/Flexbox-layout-isn-t-slow).

With the help of SCSS (see above) you can easily "modularize" your CSS and, from your theme, only include the parts that are relevant to the active page.
A possible optimization would be to serve a monolithic CSS on HTTP/1.1 and modular CSS on HTTP/2 (but beware of the server caching!).

In case of @media queries the "base CSS" should be the mobile one, overloaded with @media for bigger versions, this way smaller devices would need to do less computation than the bigger ones, helping them to get a quicker rendering.

As for JS, many parts of jQuery were merged in one way or another into mainline JavaScript, so avoiding it is always a good idea.

If needed, JS files can be minified with Uglify-Js, supported natively in JetBrains IDEs:

```bash
npm install -g uglify-js
```

You can take advantage of [CSS Specificity](https://css-tricks.com/specifics-on-css-specificity/) ordering to reorganize your selectors in a way that shortens them and/or reduces the amount of "!important".

To sum it up, specificity is ordered like this in a CSS file (extra column with "1" on the left if it's in a HTML style attribute):

```
[number of matching ids], [number of matching classes], [number of matching tags]
```

Among selectors that match the target item, priority will be given to the one that has a higher number starting from the left.
In case of two matching "level 1" numbers the winner will be decided based on the highest "level 2" number, all the way to the end.
In case of "!important" on a property, it's like adding another extra column on the left with "1" in it.

##### Cumulative Layout Shift

Cumulative Layout Shift is what happens when images, ads, embeds and iframes change the page layout after being loaded.
The [relevant web.dev page](https://web.dev/optimize-cls/) explains how to avoid this, but to sum it up: check that the img tag includes the width and height properties to help the browser get the correct ratio and placement before the image is downloaded (this may require CSS adjustments).
Once this is done, you can then add…

##### Lazy Load

Lazy Load is [enabled by default since Wordpress 5.5](https://make.wordpress.org/core/2020/07/14/lazy-loading-images-in-5-5/) and higher for post and page contents, and is on for iframes [starting version 5.7](https://wordpress.org/support/wordpress-version/version-5-7/#lazy-load-your-iframes) (when iframe dimensions are specified).

For content created by the theme, unless you use a plugin like WP Rocket that rewrites the output HTML on the fly, you should add it yourself like this:

```HTML
<picture>
   <source...>
   <img src="/images/logo.jpg" width="640" height="480" alt="logo" loading="lazy">
</picture>
```

The [Living Standard](https://html.spec.whatwg.org/multipage/embedded-content.html#attr-img-loading) also offers the "eager" value to prioritize some images over others.

##### Preconnect

If you use external resources, preconnecting the browser to those hosts can speed up the page loading.

You can do so by adding a link tag of rel type "preconnect" in head:

```html
<html>
	<head>
		<link rel="preconnect" href="https://pbs.twimg.com">
```



#### Check HTML/CSS

HTML: https://validator.w3.org/

CSS: https://jigsaw.w3.org/css-validator/

Accessibility: https://wave.webaim.org/ (Firefox includes checks and visual filters too)

#### FontAwesome trimming

If you only use a small set of icons from FontAwesome, it could be best (the speed up the initial display) to create a reduced set.

Even using their kit means downloading the JS, then the CSS files, then the font files.

You could call directly the individual SVG files, embed them if they're only used once, or make a new trimmed font this way:

1. Get SVG files from https://github.com/FortAwesome/Font-Awesome/tree/master/svgs

2. Get icon codes from https://fontawesome.com/cheatsheet/free (the Solid/Regular/Brands tabs)

3. Import SVG files into https://icomoon.io/ ("IcoMoon App" on the top bar, then "Generate SVG & More"), select them ("Selection"), set their icon codes and export the font ("Generate Font").

4. To get a woff2 file (better compressed than woff), import the woff from the zip file in [https://www.font-converter.net](https://www.font-converter.net/) .

5. Add the new font to the CSS (the src will prioritize woff2, then woff, …):

   1. ```css
      @font-face {
        font-family: 'LocalVariant-FA5';
        src:         url('./fonts/LocalVariant-FA5.eot'); /* IE9 Compat Modes */
        src:         url('./fonts/LocalVariant-FA5.woff2') format('woff2'), /* Modern Browsers - >96% Worldwide - https://caniuse.com/woff2 */
                     url('./fonts/LocalVariant-FA5.woff') format('woff'), /* Modern Browsers - >98% Worldwide - https://caniuse.com/woff */
                     url('./fonts/LocalVariant-FA5.ttf') format('truetype'), /* Safari, Android, iOS - >98% Worldwide - https://caniuse.com/ttf */
                     url('./fonts/LocalVariant-FA5.svg') format('svg'), /* Legacy iOS */
                     url('./fonts/LocalVariant-FA5.otf') format('opentype'), /* Open Type Font */
                     url('./fonts/LocalVariant-FA5.eot?#iefix') format('embedded-opentype'); /* IE6-IE8 */
        font-weight: normal;
        font-style:  normal;
      }
      ```

6. Set the font-family of the previous elements to the new font name, keeping their 'content' character code the same.

And if this font is used on every page, to help speed things a bit more the most used font file could be added as a preload in your <head> (again, support for this feature is not yet enabled in Firefox by default):

```php+HTML
<link rel="preload" href="<?= esc_url( $templateDirectoryUri ) ?>/fonts/LocalVariant-FA5.woff2" as="font">
```

Right now the online version of [Fontello](https://fontello.com/) doesn't support FontAwesome v5 yet, but allows saving as woff and woff2 at once, so check it out from time to time to combine steps 3 and 4.

If you want to automate this process you could use fontello-cli (```npm -g install fontello-cli```) in your pipeline, but then you'd need a way to make users download new versions of the font.

#### Bootstrap trimming

The same way a minimal version of FontAwesome can be served, if you use Bootstrap in a theme or an extension then a light version can be served.

The two main ways are:

* Use bootstrap-grid.min.css instead of bootstrap.min.css if you only use the grid system and associated flex utilities (~100 Kb saved).
* Maintain your own version of Bootstrap by compiling it with only the components you use (you need NodeJS).

The second way is described below (skip the steps that don't apply to you):

1. Checkout the [project's Git repository](https://github.com/twbs/bootstrap)
2. Switch to the tag of the version you want to trim and create your own local branch off of it (make one per project if needed)
3. Comment out the SCSS imports you don't need in /scss/bootstrap.scss
4. Comment out the JS modules you don't need in /js/src/index.js
5. Compile the CSS with the `npm run css` command from the root folder
6. Compile the JS with the `npm run js` command from the root folder
7. When a new version of Bootstrap is released, create a new local branch off of its tag, switch (with merge) to it, then recompile

As Bootstrap components can have a lot of dependencies, you may have to uncomment more components than you thought before compiling successfully.

Steps 6 and 7 can be integrated in the IDE (in PhpStorm: `Run/Edit Configurations…` , `+` on the top left, select `npm`, and the step you want in `Scripts`).
Other steps are available, including some that recompile automatically on changes: look at the package.json file to see the full list and the commands they run.

#### Serve locally as much data as possible

A standard advice previously was to use external CDNs (such as Google Fonts) as much as possible to cache once any libraries/fonts/… that would be used by multiple websites.

However [since Chrome 86](https://www.zdnet.com/article/chromes-new-cache-partitioning-system-impacts-google-fonts-performance/) (October 2020), this is not the case anymore for the most used web browser: its cache is now partitioned per-website.
Which means that querying a CDN would only add latency to the overall loading time.
As the linked article states, Safari also partitioned its cache the same way since 2013, other Chromium-based browsers should follow suit, and it could also come soon to Firefox.

A case for which CDNs stay relevant is to always make the user download the latest version of JS libraries, as they could contain bugs you wouldn't want to be seen exploited on your website between their discovery and your update of the local elements.

#### Font splitting

This follows directly the previous point.

For some fonts, Google Fonts splits them so users only download the Unicode range they need for the characters on the page.
In this case, serving the font locally as a big file could increase the download size and size, especially for languages like Japanese.

For instance, the [Noto Sans JP](https://fonts.google.com/specimen/Noto+Sans+JP) font is [split in 120 sub-fonts](https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400&display=swap) when served from Google Fonts (see the [Google Font team's reasoning](https://developers.googleblog.com/2018/09/google-fonts-launches-japanese-support.html)).

To achieve the same result locally, depending in the font, you could use a tool like [VdustR's font-splitter](https://github.com/VdustR/font-splitter) to split in chunks or [doasync's font-ranger](https://github.com/doasync/font-ranger) to split by subset.

For people dealing with Japanese fonts, this article describes another alternative with the Win/Mac program [subsetfontmk](https://opentype.jp/subsetfontmk.htm) and [U-618's subsets](https://u-618.org/webfont-subset/):
[Webフォントをサーバにアップロードして使うには？注意点や実装方法まとめ (GRANFAIRS)](https://www.granfairs.com/blog/staff/webfont-by-selfhosting)
You could also start with a list of kanji by [usage frequency](https://kanjicards.org/kanji-list-by-freq.html), to generate subsets based on it (doing the split with a script or spreadsheet functions/macros, like having progressively smaller subsets the further you go from the most used characters).

### Check your logs for 404 queries

HTTP requests going 404 (for missing resources) will retrieve the 404 page defined in Wordpress, which means that if you load a page containing 5 resources that don't exist, the "Not Found" page will be generated (or at least retrieved) 5 times: in situations when cache is not enabled (logged-in users, Woocommerce pages, …) or set up (quick and dirty hosting), this could seriously affect performance.

To act preemptively you can configure your webserver to not redirect queries to Wordpress when they match filenames that would exist in some directories (like wp-content).

### Set your favicon.ico

In the same vein, accessing /favicon.ico when using a [Wordpress-configured Favicon](https://wordpress.org/support/article/creating-a-favicon/) (Site Icon) also implies loading the whole CMS just to get one small file, when the browser queries /favicon.ico instead of using the <link rel="icon"> defined in the HTML <head>.
This could be an issue (or not) depending on your webserver configuration.

## Get away from WordPress

The best way to avoid all the performance issues of dynamic websites… can be to make them static.

One of the best frameworks for this is [Hugo](https://gohugo.io/), which can [import WordPress contents](https://gohugo.io/tools/migrations/#wordpress) through plug-ins and tools.

## Other (non perf-related) useful things

### SSL

Every website should be served through HTTPS in this day and age.

Test your server configuration from time to time using [Qualys's SSL Server Test](https://www.ssllabs.com/ssltest/), and keep your configuration up-to-date in your various daemons using the [Mozilla SSL Configuration Generator](https://ssl-config.mozilla.org/).

If you use Certbot to get [Let's Encrypt](https://letsencrypt.org/) free certificates, or your hosting company's interface, then good settings should be set and updated automatically.

Be wary of manual redirects from http://domain to http://www.domain and vice-versa in .htaccess or other config files, as they could keep the Let's Encrypt server from verifying both default URL forms: a redirection exception for the .well-known subfolder should then be made. Anyway you should let WordPress do that redirect.

[On staging environments](https://letsencrypt.org/docs/staging-environment/), the --dry-run option of certbot allows the generation of certificates signed by a "fake" intermediate certificate issued by a root certificate not present in browser/client trust stores: you can have a specific browser or browser profile set up with this root certificate, or bypass the security message each time (in Chrome, this can be done by typing `thisisunsafe` while on the error page).

### Mailer Return-Path

By default, WordPress fucks up the Return-Path with PHPMailer, which doesn't help with spam filters.

The [wp_mail return-path](https://fr.wordpress.org/plugins/wp-mail-returnpath/) plugin sets the PHPMailer Sender (return-path) the same as the From address if it’s not correctly set.

### URL Change

For some reason, you may have to change the website URL (prod to dev or http to https can be a valid reason).

The final website URL shouldn't be present anywhere in the theme (PHP/CSS) or in posts/pages/menus, where relative links should be used (is also helps to test the website correctly).
The following is for the places where you can't always do that, or when WP uses the final URL behind your back.

Here is my recommended process (if you changed servers, once all data has been transferred):

1. You can skip this step if you don't need to go to the website before altering its database.

   Add the following to your wp-config.php, before the last `require_once(ABSPATH . 'wp-settings.php')` :

   ```php
   define( 'WP_HOME', 'http://new.home.com' ); // Base URL for links
   define( 'WP_SITEURL', 'http://new.home.com/site' ); // Base for the ressources relative to DocumentRoot
   define( 'FORCE_SSL_ADMIN', false ); // Only if doing the process locally
   ```

   Usually WP_HOME and WP_SITEURL are the same, but if you move WordPress to a subfolder (let's call it "site") and copy its index.php to the parent (new root) while changing:

   ```php
   require __DIR__ . '/wp-blog-header.php';
   ```

   into

   ```php
   require __DIR__ . '/site/wp-blog-header.php'; 
   ```

   then "/site" needs to be added to WP_SITEURL.

   This could be useful if you only have access to DocumentRoot (through SFTP for instance) and no upper level, to keep things tidy in some cases.

   Setting those values inside wp-config.php would keep you from changing them in the WordPress admin panel: even if it's non-standard you may prefer it that way.

   

2. Use the [Search Replace DB](https://github.com/interconnectit/Search-Replace-DB) tool to correctly change all instances of the previous URL (or WP CLI, see below).

   Indeed you could do most changes with good old SQL queries like this:

   ```sql
   SET @oldUrl = 'https://old.url/site'; -- Without ending slash
   SET @newUrl = 'https://new.url'; -- Also without ending slash
   
   UPDATE wp_options SET option_value = REPLACE(option_value, @oldUrl, @newUrl) WHERE option_value LIKE CONCAT('%', @oldUrl, '%'); -- BEWARE, SEE NOTE AFTER THIS BLOCK
   UPDATE wp_usermeta SET meta_value = REPLACE(meta_value, CONCAT(@oldUrl, '/'), CONCAT(@newUrl, '/')) WHERE meta_value LIKE CONCAT('%', @oldUrl, '/%');
   UPDATE wp_posts SET post_content = REPLACE(post_content, CONCAT(@oldUrl, '/'), CONCAT(@newUrl, '/')) WHERE post_content LIKE CONCAT('%', @oldUrl, '/%');
   ```
   However some option_value fields, in wp_options, are stored using [serialized](https://www.php.net/manual/en/function.serialize.php) data where string lengths are stored like this:

   ```php
   s:5:"value"; // data_type:data_length:data
   ```

   If your new URL has a different length then you can't correctly update the serialized data using SQL alone (or maybe you can, but I wouldn't want to be the one maintaining those queries).

   The previously mentioned tool knows how to deal with that by unserializing, updating, then reserializing the data.
   Check twice that you [don't change GUIDs](https://wordpress.org/support/article/changing-the-site-url/#important-guid-note)!

   You can also see the "WP CLI" section below, which offers a command to do the same thing (the same note as below also applies here: do a second run with escaped slashes in the URL if using Gutenberg blocks).

   

3. If you skipped point 1 or if you want to remove the wp-config.php values later:

   Using a SQL CLI or GUI, go to the wp_options to change the fields (where option_name is siteurl and home, usually option_id 1 and 2) to the wished values (see explanations in 1. for the difference between the two).

   

4. If you followed point 1. and want to be able to edit the siteurl and home settings from the WP Admin:

   Remove the values from the wp-config.php file.

   

5. If you changed it in wp-config.php in point 1, once you've setup SSL set FORCE_SSL_ADMIN back to TRUE.

   

6. Check the theme files (PHP/CSS/JS): many developers love to put absolute URLs everywhere in them.

   Check .htaccess files too, just in case.

   

7. You may want to add redirections for SEO purposes

   1. Apache HTTPd:

      Using mod_alias:

      In the config file of the old VHost:

      ```apache
      Redirect temp      /oldpath https://newdomain.tld/newpath # 302
      Redirect permanent /oldpath https://newdomain.tld/newpath # 301
      ```

      (use mod_rewrite for other cases)

   2. NGINX:

      In the config file of the old domain, if the domain is changed (oldpath and newpath can be similar, different, or empty):

      ```nginx
      rewrite ^/oldpath(/?.*)$ $scheme://newdomain.tld/newpath$1 redirect;  # 302
      rewrite ^/oldpath(/?.*)$ $scheme://newdomain.tld/newpath$1 permanent; # 301
      ```
      
      In the same config file, if the domain is unchanged but the path is different:

      ```nginx
      rewrite ^/oldpath(/?.*)$ /newpath$1 redirect;  # 302
      rewrite ^/oldpath(/?.*)$ /newpath$1 permanent; # 301
      ```

      Do your own recipes, these are only examples.

   

8. Check various redirection cases with curl to see redirection type and URL:

   ```bash
   curl -I https://olddomain.tld/oldpath
   curl -I https://olddomain.tld/oldpath/
   curl -I https://olddomain.tld/oldpath/wp-admin
   curl -I https://olddomain.tld/oldpath/123
   curl -I https://olddomain.tld/oldpath/?p=123
   ```

   Example output:

   ```bash
   $ curl -I https://olddomain.tld/oldpath/
   ```

   ```http
   HTTP/1.1 301 Moved Permanently
   Server: nginx
   Date: Fri, 21 Aug 2020 03:58:07 GMT
   Content-Type: text/html
   Content-Length: 162
   Connection: keep-alive
   Location: https://newdomain.tld/newpath/
   ```

### WP CLI

Administrative tasks can be done in a faster and safer way by using WP-CLI.

* [Handbook](https://make.wordpress.org/cli/handbook/) ([Install](https://make.wordpress.org/cli/handbook/guides/installing/))
* [Command Reference](https://developer.wordpress.org/cli/commands/)
* [Command List](https://github.com/maheshwaghmare/wp-cli-commands-cheat-sheet) (without details)

Examples:

 - Install WP CLI

   ```bash
   $ composer global require wp-cli/wp-cli-bundle
   ```

 - [Upgrade](https://developer.wordpress.org/cli/commands/core/update/) WP to the latest version (DB upgrade included)

   ```bash
   $ wp core update
   ```

 - [Upgrade](https://developer.wordpress.org/cli/commands/plugin/update/) plugins to the latest version

   ```bash
   $ wp plugin update --all
   ```

 - [Upgrade](https://developer.wordpress.org/cli/commands/core/update/) theme to the latest version

   ```bash
   $ wp theme update --all
   ```

 - [Create](https://developer.wordpress.org/cli/commands/user/create/) an administrative user (may be useful)

   ```bash
   $ wp user create TemporaryAdmin your@email.tld --role=administrator --user_pass=YourPassword
   ```

- [Delete](https://developer.wordpress.org/cli/commands/user/delete/) a user (we suppose no content was created by it)

  ```bash
  $ wp user delete TemporaryAdmin
  ```

- [Search & Replace](https://developer.wordpress.org/cli/commands/search-replace/) a string (for instance, to change the website URL) (serialized data supported)

  ```bash
  # Test run
  $ wp search-replace 'http://old.site.tld' 'https://new.site.tld' --skip-columns=guid --dry-run
  # Final run
  $ wp search-replace 'http://old.site.tld' 'https://new.site.tld' --skip-columns=guid
  ```

  (Warning: if using URLs in Gutenberg blocks, see [this issue](https://github.com/wp-cli/wp-cli/issues/5293): you'll need to do another run with escaped slashes, http:// becoming http:\/\/)

- Remove the [maintenance mode](https://developer.wordpress.org/cli/commands/maintenance-mode/) (plugin updates can crash and leave this mode on: you can also remove the .maintenance file manually)

  ```bash
  $ wp maintenance-mode deactivate
  ```



### Bedrock

You may find it easier in the long run to use [Bedrock](https://roots.io/bedrock/) if your development process involves a deployment pipeline, multiple environments, or even containers.
Be warned that some plugins may not be compatible with Bedrock's particular folder layout.

More information/links:

- https://www.kurzor.net/blog/roots-io-and-bedrock

- https://css-tricks.com/intro-bedrock-wordpress/

  

### Internationalization+Localization

Back to the developer side: you may have, for whatever reason, to translate a theme (yours or not).

The process relies on prepared PHP code, that is analyzed to produce a .pot file : you'll use it as a base to create a .po file through something like [Poedit](https://poedit.net/), and compile it to a binary .mo file.

#### Preparing the PHP code (i18n)

Follow the [WordPress guide](https://codex.wordpress.org/I18n_for_WordPress_Developers).

In short, you'll have to change:

```php+HTML
<?php $str = 'Hello World!0'; ?>
<p>Hello World!1</p>
<p>Hello World!2</p>
```

Into this:

```php+HTML
<?php $str = __( 'Hello World!0', 'text-domain' ); ?>
<p><?= esc_html__( 'Hello World!1', 'text-domain' ); ?></p>
<p><?php esc_html_e( 'Hello World!2', 'text-domain' ); ?></p>
```

"text-domain" being the theme/plugin folder name.

Then create the .pot file, for instance [with WP-CLI](https://developer.wordpress.org/cli/commands/i18n/make-pot/):

```bash
$ wp i18n make-pot wp-content/plugins/pluginName/ wp-content/plugins/pluginName/languages/pluginName.pot
```



#### Translating (l10n)

Get your editor, translate from the .pot to a localized .po, compile and put the .mo file in the appropriate directory:

- Theme: wp-content/themes/themeName/languages/languageCode.mo
- Plugin: wp-content/plugins/pluginName/languages/pluginName-languageCode.mo
- Any: wp-content/languages/{plugins,themes}/pluginOrThemeName-languageCode.mo

languageCode being either "[countryCode](http://www.gnu.org/software/gettext/manual/html_chapter/gettext_16.html#Country-Codes)" or "countryCode_[languageCode](http://www.gnu.org/software/gettext/manual/html_chapter/gettext_16.html#Language-Codes)", but the translation tool usually takes care of that.

#### Warning

If you use multilingual website in conjunction with a cache system (CDN or HTTPD) and the language is not part of the URL, add the language in the cache key: this would also mean adding the served language in a HTTP header for the caching system to be able to read it.

### Database backups

If you're doing database backups (which you should do), chances are that you're using mysqldump in a cron script for that.

As modern WordPress installs only use InnoDB tables, you can skip the default table locking meant mostly for MyISAM (which makes all tables unreachable during the export) and instead export everything in a single transaction:

```bash
mysqldump --single-transaction --skip-lock-tables some_database > some_database.sql
```

([source](https://serversforhackers.com/c/mysqldump-with-modern-mysql))

### Preparing for PHP upgrades

You can test if your existing plugins and themes will be compatible with a PHP version you haven't installed yet by running one of these tools:

* [PHP Compatibility Checker](https://wordpress.org/plugins/php-compatibility-checker/) WP plugin (tests for PHP 7.0 to 7.3)
* The [PHPCompatibilityWP](https://github.com/PHPCompatibility/PHPCompatibilityWP) Ruleset for PHP_CodeSniffer

For migrations to PHP 8.0, see the [relevant article by the Yoast SEO team](https://developer.yoast.com/blog/the-2020-wordpress-and-php-8-compatibility-report/).

### Serving your local environment

You may want to show your local environment to somebody else, or a test service, without having a publicly accessible dev server.

With a bit of tinkering on your WordPress, you can use the ngrok service to [tunnel your local WP server publicly](https://matthewshields.co.uk/sharing-local-wordpress-sites-remotely-using-ngrok).

If you pay for an account, you can have the tunnel running on custom URLs.

Short version of Matthew Shields' blog post:

1. [Create an account](https://dashboard.ngrok.com/signup) on ngrok

2. Follow the instructions on the "Setup & Installation" page of your dashboard

3. Add this to your wp-config.php, before the last require_once directive (code taken from the blog post):

   ```php
   if(strpos($_SERVER['HTTP_X_ORIGINAL_HOST'], 'ngrok') !== FALSE) {
   	if(
   		isset($_SERVER['HTTP_X_ORIGINAL_HOST']) && 
   		$_SERVER['HTTP_X_ORIGINAL_HOST'] === "https"
   	) {
   		$server_proto = 'https://';
   	} else {
   		$server_proto = 'http://';
   	}
   	define('WP_SITEURL', $server_proto . $_SERVER['HTTP_HOST']);
   	define('WP_HOME', $server_proto . $_SERVER['HTTP_HOST']);
   	define('LOCALTUNNEL_ACTIVE', true);
   }
   ```

4. Add the following wrapper to a "must use" plugin (ex. "wp-content/mu-plugins/ngrok.php") (also from the post) :

   ```php
   <?php
   function change_urls($page_html) {
     if(defined('LOCALTUNNEL_ACTIVE') && LOCALTUNNEL_ACTIVE === true) {
   
       $wp_home_url = esc_url(home_url('/'));
       $rel_home_url = wp_make_link_relative($wp_home_url);
   
       $esc_home_url = str_replace('/', '\/', $wp_home_url);
       $rel_esc_home_url = str_replace('/', '\/', $rel_home_url);
   
       $rel_page_html = str_replace($wp_home_url, $rel_home_url, $page_html);
       $esc_page_html = str_replace($esc_home_url, $rel_esc_home_url, $rel_page_html);
   
       return $esc_page_html;
     }
   }
   
   function buffer_start_relative_url() { 
     if(defined('LOCALTUNNEL_ACTIVE') && LOCALTUNNEL_ACTIVE === true) {
       ob_start('change_urls'); 
     }
   }
   function buffer_end_relative_url() { 
     if(defined('LOCALTUNNEL_ACTIVE') && LOCALTUNNEL_ACTIVE === true) {
       @ob_end_flush(); 
     }
   }
   
   add_action('registered_taxonomy', 'buffer_start_relative_url');
   add_action('shutdown', 'buffer_end_relative_url');
   ```

5. Launch the server with a header towards your website:

   ```bash
   ngrok http -host-header=local.virtualhost.test 80
   ```

   You can add an option to specify the location of the tunnel (it would be "us" by default):
   ([see the list](https://ngrok.com/docs#global): currently us/eu/ap/au/sa/jp/in):

   ```
   ngrok http -host-header=local.virtualhost.test -region=jp 80
   ```

6. Distribute the public URL displayed in the ngrok console.

### Fight spam

Your use case may not warrant the use of [Akismet](https://akismet.com/) (which requires a license for commercial use).

It could be way simpler to use a blacklist/a blocklist/"disallowed comment keys" (seriously you guys…), such as the [wordpress-comment-blacklist](https://github.com/splorp/wordpress-comment-blacklist) by splorp, and to automate its update through one of the suggested plugins on the page.

### Sidebars

tl;dr for dynamic places in themes, declare the sidebar in functions.php:

```php+HTML
<?php
// Sidebar to simplify content updates
function theme_sidebar_init() {   
   register_sidebar( [
      'name'          => 'Custom Sidebar',
      'id'            => 'custom-sidebar',
      'before_widget' => '',
      'after_widget'  => '',
      'before_title'  => '<h5>',
      'after_title'   => '</h5>',
   ] );
}
add_action( 'widgets_init', 'theme_sidebar_init' );
?>
```

WARNING: The id of the sidebar should be all lowercase! If not, changes in the "Widgets" interface won't get saved.

Then add this in the relevant theme file:

```php+HTML
<?php
if ( is_active_sidebar( 'custom-sidebar' ) ) {
   dynamic_sidebar( 'custom-sidebar' );
} else {
   ?>
	<p class="text">Sidebar "custom-sidebar" not initialized!</p>
<?php
}
?>
```

Then fill the sidebar in Dashboard/Appearance/Widgets.

If you want to hijack things a bit, for instance to insert this sidebar into a theme hook (to avoid overriding a file from a parent theme for instance), just do it like this in functions.php instead:

```php+HTML
<?php
function theme_sidebar_render() {
 if ( is_active_sidebar( 'custom-sidebar' ) ) {
  dynamic_sidebar( 'custom-sidebar' );
 } else {
  ?>
  <p class="text">Sidebar "custom-sidebar" not initialized!</p>
<?php
 }
}
add_action( 'hook_to_insert_into', 'theme_sidebar_render' );
```

That you leave or not a warning message depends on you.

If you rely on legacy sidebars, you can disable the Gutenberg version by putting this in your functions.php ([source](https://wptavern.com/gutenberg-8-9-brings-block-based-widgets-out-of-the-experimental-stage)):

```php
remove_theme_support( 'widgets-block-editor' );
```

### Live Templates

When using IDEs that allow for advanced autocompletion, it can be useful to use existing ones or do your own.

See Rarst's [WordPress Live Templates for PhpStorm](https://gist.github.com/Rarst/183c38c499515b6d8609) for some examples, but you can add templates for every construction not used often enough to justify memorizing it, but still used enough to give a reason to fetch it quickly (like the "add_action()" +  "wp_enqueue_scripts" combo).

### Stay up to date!

Following WordPress-related websites to keep up-to-date with the latest developments can be quite useful. Here's a small list:

- [Official WordPress.org Blog](https://wordpress.org/news/) (developer-oriented)
- [WordPress Tavern](https://wptavern.com/)
- [WordPress for Beginners Blog](https://www.wpbeginner.com/blog/) (general content) ([their YouTube channel](https://www.youtube.com/c/wpbeginner/videos))
- [Wordfence Blog](https://www.wordfence.com/blog/) (security-oriented) ([their YouTube Channel](https://www.youtube.com/c/Wordfence1/videos))
- A [list of other sites](https://wpbuffs.com/wordpress-news/) if the above ones are not enough for you

## Credits/Thanks/Notes

Markdown formatting using [Typora](https://typora.io/).

TOC using a [patched](https://github.com/Ruzgfpegk/nGitHubTOC) version of [nGitHubTOC](https://github.com/imthenachoman/nGitHubTOC).

## Something else?

I'm not actively developing or hosting Wordpress websites anymore since mid-2021, so this document may not be up-to-date for everything.

You can comment below for changes you'd like to see.