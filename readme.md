# WP Easy Start Framework
```
npm i
npm run start
```


.dblock - @extend .dblock - для всяких :before/:after элементов
.align-center-parent - идеальное выравнивание по центру (горизонтально и вертикально), задавать родительскому. элемент что центровать - .align-center
.justify-child - родительский элемент, блоки внутри будут по всей ширине


## TODO
### Projects for investigae

https://www.npmjs.com/package/starter-project-cli
https://www.npmjs.com/package/starter-project


// TODO: add https://github.com/olegskl/gulp-stylelint
// TODO: add https://github.com/morishitter/stylefmt
// TODO: add https://github.com/johno/immutable-css
// TODO: add h Autoprefixer https://github.com/postcss/autoprefixer
// Stylelint https://github.com/stylelint/stylelint
// Postcss-flexbugs-fixes https://github.com/luisrudge/postcss-flexbugs-fixes


### Gradients
  * @include linear-gradient(yellow, blue);
  * @include linear-gradient(to top, red 0%, green 50%, orange 100%);
  * @include linear-gradient(45deg, orange 0%, pink 50%, green 50.01%, green 50.01%, violet 100%);

### px 2 rm
https://github.com/thoughtbot/bourbon/blob/master/app/assets/stylesheets/functions/_px-to-em.scss
// Convert pixels to ems
// eg. for a relational value of 12px write em(12) when the parent is 16px
// if the parent is another value say 24px write em(12, 24)


### Triangle generator
 * https://github.com/thoughtbot/bourbon/blob/master/app/assets/stylesheets/addons/_triangle.scss
 * @include triangle(12px, gray, down);
 * @include triangle(12px 6px, gray lavender, up-left);
 * The $size argument can take one or two values—width height.
 * The $color argument can take one or two values—foreground-color background-color.
 * $direction: up, down, left, right, up-right, up-left, down-right, down-left


### Fonts
 * @font-face mixin
 * Bulletproof font-face via Font Squirrel
 * @include fontface('family', 'assets/fonts/', 'myfontname');
