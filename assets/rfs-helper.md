```scss

// scss/main.scss

@import "../node_modules/rfs/scss";

.title {
  @include font-size(4rem);

  // The font-size mixin is a shorthand which calls
  @include rfs(4rem, font-size);

  // Other shorthand mixins that are available are:
  @include padding(4rem);
  @include padding-top(4rem);
  @include padding-right(4rem);
  @include padding-bottom(4rem);
  @include padding-left(4rem);
  @include margin(4rem);
  @include margin-top(4rem);
  @include margin-right(4rem);
  @include margin-bottom(4rem);
  @include margin-left(4rem);

  // For properties which do not have a shorthand, the property can be passed:
  @include rfs(4rem, border-radius);

  // Whenever a value contains a comma, it should be escaped with `#{}`:
  @include rfs(0 0 4rem red #{","} 0 0 5rem blue, box-shadow);

  // Custom properties (css variables):
  @include rfs(4rem, --border-radius);
}

```
