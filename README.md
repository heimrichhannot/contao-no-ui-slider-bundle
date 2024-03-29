# Contao NoUiSlider Bundle

This bundle offers support for the JavaScript library [noUiSlider](https://github.com/leongersen/noUiSlider/) for the Contao CMS.

## Features
* Filter Bundle support
* Encore Contracts support

## Setup

1. Install via composer: `composer require heimrichhannot/contao-no-ui-slider-bundle`.
1. Update Database.

## Configuration

### Activate NoUiSlider for a "choice filter"

1. Create a choice field as usual in [heimrichhannot/contao-filter-bundle](https://github.com/heimrichhannot/contao-filter-bundle).
1. Activate the option "Add noUiSlider support". 

### Activate NoUiSlider for a "multiple range filter"
1. Create 2 __text__ filter elements which represent the two borders of the filter interval. It's important that the filter element type is __text__.
1. Create a multiple range filter element and link the text filters created in the step before.
1. Activate the option "Add noUiSlider support". 

## Developers

When you change the set value of the slider it matches the current value to the corresponding input field. To set the slider to its min value means that all input fields are unchecked.
In that case no change or click event is triggered. Therefore, the custom event `filterAsyncSubmit` is dispatched in this situation.
Use this event to initiate the async submit.