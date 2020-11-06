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


use HeimrichHannot\UtilsBundle\Container\ContainerUtil;

class NoUiSliderAsset
{
    /**
     * @var ContainerUtil
     */
    protected $containerUtil;
    /**
     * @var \HeimrichHannot\EncoreBundle\Asset\FrontendAsset
     */
    protected $encoreFrontendAsset;

    /**
     * FrontendAsset constructor.
     */
    public function __construct(ContainerUtil $containerUtil)
    {
        $this->containerUtil = $containerUtil;
    }

    public function setEncoreFrontendAsset(\HeimrichHannot\EncoreBundle\Asset\FrontendAsset $encoreFrontendAsset): void
    {
        $this->encoreFrontendAsset = $encoreFrontendAsset;
    }

    public function addAssets()
    {
        if ($this->containerUtil->isFrontend()) {
            $GLOBALS['TL_JAVASCRIPT']['contao-no-ui-slider-bundle'] = 'bundles/contaonouislider/js/contao-no-ui-slider-bundle.js|static';
            $GLOBALS['TL_CSS']['contao-no-ui-slider-bundle'] = 'bundles/contaonouislider/js/contao-no-ui-slider-bundle.css';

            if ($this->encoreFrontendAsset) {
                $this->encoreFrontendAsset->addActiveEntrypoint('contao-no-ui-slider-bundle');
            }
        }
    }

}