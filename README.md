# Contao NoUiSlider Bundle

This bundle offers support for the JavaScript library [noUiSlider](https://github.com/leongersen/noUiSlider/) for the Contao CMS.

## Setup

1. Install via composer: `composer require heimrichhannot/contao-no-ui-slider-bundle`.
2. Update Database.

## Developers

When you change the set value of the slider it matches the current value to the corresponding input field. To set the slider to its min value means that all input fields are unchecked.
In that case no change or click event is triggered. Therefore the custom event `filterAsyncSubmit` ist dispatched in this situation.
Use this event to initiate the async submit.

### Assets

Bundle assets are provided as [yarn package](https://yarn.pm/@hundh/contao-no-ui-slider-bundle). Sources and JavaScript documentation can be found in [`src/Resources/npm-package`](https://github.com/heimrichhannot/contao-no-ui-slider-bundle/tree/master/src/Resources/npm-package).