# WP Bruce Easy Start Framework

## Warning

- Do not update `gulp-imagemin` from `7.1.0`

## How to start

```shell
npm i
npm run start
```

## Howto

- `.dblock` - `@extend .dblock` - for various `:before`/`:after` elements
- `.align-center-parent` - perfect centering (horizontal and vertical), set to the parent element that needs to be centered - `.align-center`
- `.justify-child` - parent element, blocks inside will be the full width.

### Gradients

- `@include linear-gradient(yellow, blue);`
- `* @include linear-gradient(to top, red 0%, green 50%, orange 100%);`
- `@include linear-gradient(45deg, orange 0%, pink 50%, green 50.01%, green 50.01%, violet 100%);`

### px 2 rm

https://github.com/thoughtbot/bourbon/blob/master/app/assets/stylesheets/functions/_px-to-em.scss

#### Convert pixels to ems

eg. for a relational value of 12px write em(12) when the parent is 16px
if the parent is another value say 24px write em(12, 24)

### Triangle generator

- https://github.com/thoughtbot/bourbon/blob/master/app/assets/stylesheets/addons/_triangle.scss
- `@include triangle(12px, gray, down);`
- `@include triangle(12px 6px, gray lavender, up-left);`
- The `$size` argument can take one or two values—width `height`.
- The `$color` argument can take one or two values—foreground-color `background-color`.
- `$direction: up, down, left, right, up-right, up-left, down-right, down-left`

### Fonts

- `@font-face` mixin
- Bulletproof `font-face` via Font Squirrel
- `@include fontface('family', 'assets/fonts/', 'myfontname');`
