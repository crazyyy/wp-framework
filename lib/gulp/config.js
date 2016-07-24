"use strict";

var pkg = require('../../package.json'),
pngquant = require('imagemin-pngquant'),
  bundler = require('./helpers/bundler');

/* Paths */
var _src = './assets/',
  _dist = './dist/',
  _public = './html/';

var _js = 'js/',
  _css = 'css/',
  _img = 'img/',
  _fonts = 'fonts/',
  _html = 'html/';

/* Bundles */
var bundles = [{
  name: 'app',
  global: 'app',
  compress: true,
  saveToDist: true
}];

/* Tasks params */
module.exports = {

  scripts: {
    bundles: bundler(bundles, _js, _src, _dist, _public),
    banner: '/** ' + pkg.name + ' v' + pkg.version + ' **/\n',
    extensions: ['.jsx'],
    lint: {
      options: pkg.lintOptions,
      dir: _src + _js
    }
  },

  css: {
    bundles: bundler(bundles, _css, _src, _dist, _public),
    src: _src + _css,
    params: {
      compress: false,
      onError: console.error.bind(console, 'Sass error:')
    },
    // params: {
    //   outputStyle: 'compressed',
    //   precision: 10,
    //   onError: console.error.bind(console, 'Sass error:')
    // },
    autoprefixer: {
      browsers: ['ie >= 8', 'ie_mob >= 10', 'ff >= 20', 'chrome >= 24', 'safari >= 5', 'opera >= 12', 'ios >= 7', 'android >= 2.3', '> 1%', 'last 4 versions', 'bb >= 10'],
      cascade: false
    },
    compress: {}
  },

  images: {
    src: _src + _img,
    dest: _public + _img,
    imagemin: {
      progressive: true,
      interlaced: true,
      svgoPlugins: [{
        removeViewBox: false
      }],
      use: [pngquant()]
    }
  },

  sprite: {
    src: _src + 'sprite/',
    destImg: _src + _img,
    destCss: _src + _css + 'sprite/',
    params: {
      imgName: 'super_sprite.png',
      cssName: 'super_sprite.json',
      algorithm: 'binary-tree',
      padding: 4
    }
  },

  html: {
    src: _src + _html,
    dest: _public,
    params: {
      pretty: true || devBuild,
      locals: {
        pkgVersion: pkg.version,
        pkgHomepage: pkg.homepage
      }
    }
  },

  copy: {
    base: _src,
    from: [
      _src + 'fonts/**/*',
      _src + 'json/**/*',
      _src + 'files/**/*',
      _src + 'favicon.ico'
    ],
    to: _public
  },

  clean: {
    _public_js: _public + _js,
    _public_img: _public + _img,
    _public_css: _public + _css,
    _public_fonts: _public + _fonts,
  }

};
