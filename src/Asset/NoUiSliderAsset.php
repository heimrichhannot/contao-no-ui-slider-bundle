<?php
/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2020 Heimrich & Hannot GmbH
 *
 * @author  Thomas Körner <t.koerner@heimrich-hannot.de>
 * @license http://www.gnu.org/licences/lgpl-3.0.html LGPL
 */


namespace HeimrichHannot\NoUiSliderBundle\Asset;


use HeimrichHannot\EncoreContracts\PageAssetsTrait;

class NoUiSliderAsset
{
    use PageAssetsTrait;

    public function addAssets()
    {
        $this->addPageEntrypoint('contao-no-ui-slider-bundle', [
            'TL_JAVASCRIPT' => [
                'contao-no-ui-slider-bundle' => 'bundles/contaonouislider/js/contao-no-ui-slider-bundle.js|static',
            ],
            'TL_CSS' => [
                'contao-no-ui-slider-bundle' => 'bundles/contaonouislider/js/contao-no-ui-slider-bundle.css',
            ],
        ]);
    }

}