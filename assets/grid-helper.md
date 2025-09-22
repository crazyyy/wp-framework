# Grid Helper 

[Grid system](https://getbootstrap.com/docs/5.2/layout/grid/)
[Options](https://getbootstrap.com/docs/5.3/customize/options/)

|                          | xs <576px | sm ≥576px | md ≥768px | lg ≥992px | xl ≥1200px | xxl ≥1400px |
|--------------------------|-----------|-----------|-----------|-----------|------------|-------------|
| **Container max-width**  | None      | 540px     | 720px     | 960px     | 1140px     | 1320px      |
| **Class prefix**         | .col-     | .col-sm-  | .col-md-  | .col-lg-  | .col-xl-   | .col-xxl-   |

|                    | Extra small (<576px) | Small (≥576px) | Medium (≥768px) | Large (≥992px) | Extra Large (≥1200px) | XXL (≥1400px) |
|--------------------|----------------------|----------------|-----------------|----------------|------------------------|---------------|
| **Class prefix**   | `.col-`              | `.col-sm-`     | `.col-md-`      | `.col-lg-`     | `.col-xl-`             | `.col-xxl-`   |
| **Grid behaviour** | Horizontal at all times | Collapsed to start, horizontal above breakpoints | Collapsed to start, horizontal above breakpoints | Collapsed to start, horizontal above breakpoints | Collapsed to start, horizontal above breakpoints | Collapsed to start, horizontal above breakpoints |
| **Container width**| None (auto)          | 540px          | 720px           | 960px          | 1140px                 | 1320px        |
| **Suitable for**   | Portrait phones      | Landscape phones | Tablets        | Laptops        | Laptops and Desktops   | Laptops and Desktops |
| **# of columns**   | 12                   | 12             | 12              | 12             | 12                     | 12            |
| **Gutter width**   | 1.5rem (.75rem each side) | 1.5rem (.75rem each side) | 1.5rem (.75rem each side) | 1.5rem (.75rem each side) | 1.5rem (.75rem each side) | 1.5rem (.75rem each side) |


```html 
<div class="container">
  <div class="row">
    <div class="col-sm">
      One of three columns
    </div>
    <div class="col-sm">
      One of three columns
    </div>
    <div class="col-sm">
      One of three columns
    </div>
  </div>
</div>
```


```scss
@media (min-width: $lg) and (max-width: $lg-lst) {
}
```

[Sass](https://getbootstrap.com/docs/5.3/customize/sass/)

```scss
// Custom.scss
// Option B: Include parts of Bootstrap

// 1. Include functions first (so you can manipulate colors, SVGs, calc, etc)
@import "../node_modules/bootstrap/scss/functions";

// 2. Include any default variable overrides here

// 3. Include remainder of required Bootstrap stylesheets (including any separate color mode stylesheets)
@import "../node_modules/bootstrap/scss/variables";
@import "../node_modules/bootstrap/scss/variables-dark";

// 4. Include any default map overrides here

// 5. Include remainder of required parts
@import "../node_modules/bootstrap/scss/maps";
@import "../node_modules/bootstrap/scss/mixins";
@import "../node_modules/bootstrap/scss/root";

// 6. Include any other optional stylesheet partials as desired; list below is not inclusive of all available stylesheets
@import "../node_modules/bootstrap/scss/utilities";
@import "../node_modules/bootstrap/scss/reboot";
@import "../node_modules/bootstrap/scss/type";
@import "../node_modules/bootstrap/scss/images";
@import "../node_modules/bootstrap/scss/containers";
@import "../node_modules/bootstrap/scss/grid";
@import "../node_modules/bootstrap/scss/helpers";
// ...

// 7. Optionally include utilities API last to generate classes based on the Sass map in `_utilities.scss`
@import "../node_modules/bootstrap/scss/utilities/api";

// 8. Add additional custom code here
```
