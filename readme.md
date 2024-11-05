# WP Bruce Easy Start 🚀

![License](https://img.shields.io/github/license/boilerplates-collection/wordpress-theme-gulp?color=blue&colorA=4c4f56&label=License&style=flat-square)

A WordPress boilerplate designed to facilitate WordPress theme development by using Gulp.

## ⚠️ Warning

- Do not update `gulp-imagemin` from `7.1.0`

## 🛠 Base Configuration

Change Domain configuration in the following files:

```sh
./wp-config-ddev.php
./config/default.json
./.ddev/config.yaml
```

## 🚀 Using DDEV

Start DDEV:

```sh
ddev start
```

Import database:

```sh
ddev import-db --gzip=false --file=./db/db.sql
```

Export database:

```sh
ddev export-db --gzip=false --file=./db/db.sql
```

Search and replace URLs in the database:

```sh
ddev wp search-replace 'wpeb.ddev.site' 'example.site' --report-changed-only=true --precise --all-tables
```

### 🔧 Useful DDEV Commands

Open HeidiSQL:

```sh
ddev heidisql
```

## 🚀 How to Start

Install CSSComb globally:

```sh
npm install csscomb -g # https://github.com/csscomb/csscomb.js
```

Install Gulp and dependencies:

```sh
npm i -g gulp gulp-cli
npm i
npm run start
```

## ✅ PHP CodeSniffer

Install PHP CodeSniffer globally:

```sh
composer global require "squizlabs/php_codesniffer=*"
```

For more details on setting up PHP CodeSniffer in PhpStorm, visit:

- [JetBrains PHP CodeSniffer Integration](https://www.jetbrains.com/help/phpstorm/using-php-cs-fixer.html#enabling-tool-inspection)

## 📝 Stylelint

Initialize Stylelint:

```shell
npm init stylelint
```

For more information, visit:

- [Stylelint Getting Started](https://github.com/stylelint/stylelint/blob/HEAD/docs/user-guide/get-started.md)

## 🛠 WP CLI

### Install WP CLI

Install necessary dependencies and WP CLI:

```sh
sudo apt install curl --yes
sudo apt install php-cli --yes
curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar
php -r "readfile('https://raw.githubusercontent.com/wp-cli/wp-cli/master/utils/wp-cli-checksums.sha256');"
chmod +x wp-cli.phar
sudo mv wp-cli.phar /usr/local/bin/wp
wp --info
```

### Using WP CLI

Refresh the salts defined in the wp-config.php file:

```sh
wp config shuffle-salts
```

For more commands and usage, refer to the [WP CLI documentation](https://developer.wordpress.org/cli/commands/).

### 🔧 Useful WP CLI Commands

Replace URLs in the database:

```sh
wp search-replace 'wp-framework.local' 'wpeb.ddev.site' --report-changed-only=true --precise --all-tables
```

Another search-replace example:

```sh
wp search-replace 'wpeb.local' 'example.local' --allow-root
```

## 🤝 Helping Services

- [WP Settings API](http://wpsettingsapi.jeroensormani.com/)

### Howto

- `.dblock` - `@extend .dblock` - for various `:before`/`:after` elements
- `.align-center-parent` - perfect centering (horizontal and vertical), set to the parent element that needs to be centered - `.align-center`
- `.justify-child` - parent element, blocks inside will be the full width.

#### 🎨 Gradients

- `@include linear-gradient(yellow, blue);`
- `* @include linear-gradient(to top, red 0%, green 50%, orange 100%);`
- `@include linear-gradient(45deg, orange 0%, pink 50%, green 50.01%, green 50.01%, violet 100%);`

#### 📏 px to em

Convert pixels to ems, e.g., for a relational value of 12px write `em(12)` when the parent is 16px. If the parent is another value, say 24px, write `em(12, 24)`.

#### 🔺 Triangle Generator

Use the triangle generator:

- [Triangle Generator](https://github.com/thoughtbot/bourbon/blob/master/app/assets/stylesheets/addons/_triangle.scss)
- `@include triangle(12px, gray, down);`
- `@include triangle(12px 6px, gray lavender, up-left);`

The `$size` argument can take one or two values—width `height`. The `$color` argument can take one or two values—foreground-color `background-color`.

- `$direction: up, down, left, right, up-right, up-left, down-right, down-left`

#### ✒️ Fonts

Use [Transfonter](https://transfonter.org/) for font conversion.

Bulletproof `font-face` via Font Squirrel:

```scss
@include fontface('family', 'assets/fonts/', 'myfontname');
```

This should provide a more detailed and user-friendly documentation with additional examples and comments.

## Example wp-config.php

```php
/** @noinspection PhpUnused */
/** @noinspection PhpDefineCanBeReplacedWithConstInspection */
//ToDo: Example https://gist.github.com/bhubbard/8428583
define('WP_MEMORY_LIMIT', '1024M');
define('WP_MAX_MEMORY_LIMIT', '1024M');

// do not read from cache is sql contains these
const CACHE_READ_WHITELIST  = '_transient|posts WHERE ID IN|limit_login_';
// do not reset cache if sql contains these
const CACHE_WRITE_WHITELIST = '_transient|limit_login_';

//Begin Really Simple SSL session cookie settings
@ini_set('session.cookie_httponly', true);
@ini_set('session.cookie_secure', true);
@ini_set('session.use_only_cookies', true);
//END Really Simple SSL

// https://developer.wordpress.org/apis/wp-config-php/#wp-siteurl
// WP_SITEURL - the address where your WordPress core files reside.
// Dynamically set WP_SITEURL. Example: api.example.com
//define( 'WP_SITEURL', 'https://api.' . $_SERVER['HTTP_HOST'] . '' );
// WP_HOME - address which visitors sets in browser to reach your site
// Dynamically set WP_HOME. Example: example.com
//define( 'WP_HOME', 'https://' . $_SERVER['HTTP_HOST'] );

define('DB_NAME', 'tour_tourn');
define('DB_USER', 'tour_tourn');
define('DB_PASSWORD', '4D!F#qpJav2-f@gN');
define('DB_HOST', 'localhost');

$table_prefix = 'hadpj_';

// Converting Database Character Sets
// https://codex.wordpress.org/Converting_Database_Character_Sets
// If DB_CHARSET and DB_COLLATE do not exist in your wp-config.php file
// DO NOT add either definition to your wp-config.php file unless you
// read and understand Converting Database Character Sets.
/** Database Charset to use in creating database tables. */
//define('DB_CHARSET', 'utf8'); // Default
define('DB_CHARSET', 'utf8mb4');
/** The Database Collate type. Don't change this if in doubt. */
//define('DB_COLLATE', ''); // Default
define('DB_COLLATE', 'utf8mb4_general_ci');

// https://developer.wordpress.org/apis/wp-config-php/#custom-user-and-usermeta-tables
//define( 'CUSTOM_USER_TABLE', $table_prefix . 'my_users' );
//define( 'CUSTOM_USER_META_TABLE', $table_prefix . 'my_usermeta' );

// Disable all core updates. Choose 'minor' to enable minor updates only. Set to true to enable all updates.
//define('WP_AUTO_UPDATE_CORE', false);
// Disable updates for core, plugins, and themes.
//define('AUTOMATIC_UPDATER_DISABLED', true);
// Set the autosave interval to 160 seconds.
define('AUTOSAVE_INTERVAL', 160);
// Limit the number of post revisions to 3. | true, false, 10
define('WP_POST_REVISIONS', 3);
// Force SSL for admin area and logins.
define('FORCE_SSL_ADMIN', true);
define('FORCE_SSL_LOGIN', true);
// Set the number of days to keep items in the trash to 60.
define('EMPTY_TRASH_DAYS', 60);
// There is automatic database repair support, which you can enable
// by adding the following define to your wp-config.php file.
// https://developer.wordpress.org/apis/wp-config-php/#automatic-database-optimizing
// Enable the automatic database repair feature.
//define('WP_ALLOW_REPAIR', true);
// Cleanup image edits by overwriting the original image.
define('IMAGE_EDIT_OVERWRITE', true);
// Disable WordPress multisite feature.
define('WP_ALLOW_MULTISITE', false);
// Disable file editing from the WordPress admin area.
define('DISALLOW_FILE_EDIT', true);
// Path to the Git executable for the Revisr plugin.
define('REVISR_GIT_PATH', '');
// Set the file system method to direct.
define('FS_METHOD', 'direct');
// Disable automatic paragraph formatting for Contact Form 7.
define('WPCF7_AUTOP', false);
// Disable the default WordPress cron system.
//define('DISABLE_WP_CRON', true);
// Use an alternate cron system.
//define('ALTERNATE_WP_CRON', true);
//define('WP_TEMP_DIR', 'WP_TEMP_DIR');

// https://www.php.net/manual/en/reserved.variables.environment.php
// https://developer.wordpress.org/apis/wp-config-php/#wp-environment-type
define('WP_ENVIRONMENT_TYPE', 'local'); // local, development, staging, production
// https://make.wordpress.org/core/2023/07/14/configuring-development-mode-in-6-3/
define('WP_DEVELOPMENT_MODE', 'theme');

define('WP_DEBUG', true);

define('WP_DEBUG_LOG', true);
@error_reporting(E_ALL);
@ini_set('log_errors', true);
@ini_set('log_errors_max_len', '0');

if (WP_DEBUG) {
  @ini_set('display_errors', 'On');

  // https://developer.wordpress.org/apis/wp-config-php/#wp-disable-fatal-error-handler
  define('WP_DISABLE_FATAL_ERROR_HANDLER', true);
  define('WP_DEBUG_DISPLAY', true);

  // https://developer.wordpress.org/apis/wp-config-php/#script-debug
  define('SCRIPT_DEBUG', false);
  define('CONCATENATE_SCRIPTS', false);
  // https://developer.wordpress.org/apis/wp-config-php/#save-queries-for-analysis
  define('SAVEQUERIES', true);

  /** Query Monitor **/
  //define('QM_DISABLED', true); // Disable Query Monitor entirely. Default value: false
  //define('QM_DISABLE_ERROR_HANDLER', true); // Disable the handling of PHP errors. Default value: false
  define('QM_ENABLE_CAPS_PANEL', true); // Enable the Capability Checks panel. Default value: false
  define('QM_HIDE_SELF', true); // Hide Query Monitor itself from various panels. Default value: false
  define('QM_HIDE_CORE_ACTIONS', true);  // Hide WordPress core on the Hooks & Actions panel. Default value: false
  define('QM_SHOW_ALL_HOOKS', true);  // In the Hooks & Actions panel, show every hook that has an action or filter attached (instead of every action hook that fired during the request). Default value: false
} else {
  ini_set('display_errors', 'Off');

  // https://developer.wordpress.org/apis/wp-config-php/#wp-disable-fatal-error-handler
  define('WP_DISABLE_FATAL_ERROR_HANDLER', false);
  define('WP_DEBUG_DISPLAY', false);

  /** Query Monitor **/
  //define('QM_DISABLED', true); // Disable Query Monitor entirely. Default value: false
}

/** SMTP Config Example */
//define('SMTP_USERNAME', 'mail@gmail.com'); // Username of host like Gmail
//define('SMTP_PASSWORD', 'password'); // Password for login into the App
//define('SMTP_SERVER', 'smtp.gmail.com'); // SMTP server address
//define('SMTP_FROM', 'mail@gmail.com'); // Your Business Email Address
//define('SMTP_NAME', 'Site From'); // Business From Name
//define('SMTP_PORT', '587'); // Server Port Number
//define('SMTP_SECURE', 'tls'); // Encryption - ssl or tls
//define('SMTP_AUTH', true); // Use SMTP authentication (true|false)
//define('SMTP_DEBUG', 1); // For debugging purposes only
```

### other things

sudo chown -R $USER:$USER ./.git

sudo chown -R www:www ./

wp search-replace "vinwolves.ddev.site" "vinwolves.org" --all-tables

wp db import ./DB/db.sql
