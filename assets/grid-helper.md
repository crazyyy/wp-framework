# Grid Helper 

(Grid system)[(https://getbootstrap.com/docs/5.2/layout/grid/)]

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
