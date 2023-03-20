<?php

namespace HeimrichHannot\NoUiSliderBundle\Asset;

use HeimrichHannot\EncoreContracts\EncoreEntry;
use HeimrichHannot\EncoreContracts\EncoreExtensionInterface;
use HeimrichHannot\NoUiSliderBundle\HeimrichHannotNoUiSliderBundle;

class EncoreExtension implements EncoreExtensionInterface
{

    /**
     * @inheritDoc
     */
    public function getBundle(): string
    {
        return HeimrichHannotNoUiSliderBundle::class;
    }

    /**
     * @inheritDoc
     */
    public function getEntries(): array
    {
        return [
            EncoreEntry::create('contao-no-ui-slider-bundle', 'assets/js/contao-no-ui-slider-bundle.js')
                ->addJsEntryToRemoveFromGlobals('contao-no-ui-slider-bundle')
                ->addCssEntryToRemoveFromGlobals('contao-no-ui-slider-bundle')
        ];
    }
}