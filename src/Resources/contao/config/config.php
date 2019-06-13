<?php

/**
 * JavaScript
 */
if (System::getContainer()->get('huh.utils.container')->isFrontend()) {
    $GLOBALS['TL_JAVASCRIPT']['contao-no-ui-slider-bundle'] = 'bundles/contaonouislider/js/contao-no-ui-slider-bundle.js|static';
}

/**
 * CSS
 */
if (System::getContainer()->get('huh.utils.container')->isFrontend()) {
    $GLOBALS['TL_CSS']['contao-no-ui-slider-bundle'] = 'bundles/contaonouislider/js/contao-no-ui-slider-bundle.css';
}