# WP Bruce Easy Start 🚀

![License](https://img.shields.io/github/license/boilerplates-collection/wordpress-theme-gulp?color=blue&colorA=4c4f56&label=License&style=flat-square)

A WordPress boilerplate designed to facilitate WordPress theme development by using Gulp.

## ⚠️ Warning

- Do not update `gulp-imagemin` from `7.1.0`

## 🛠 Base Configuration

Change Domain configuration in the following files:
```
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
