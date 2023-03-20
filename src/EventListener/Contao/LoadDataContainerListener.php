<?php

namespace HeimrichHannot\NoUiSliderBundle\EventListener\Contao;

use Contao\CoreBundle\DataContainer\PaletteManipulator;
use HeimrichHannot\FilterBundle\Filter\Type\ChoiceType;
use HeimrichHannot\FilterBundle\Filter\Type\MultipleRangeType;
use HeimrichHannot\FilterBundle\HeimrichHannotContaoFilterBundle;

class LoadDataContainerListener
{
    public function __invoke(string $table): void
    {
        if ('tl_filter_config_element' !== $table || !class_exists(HeimrichHannotContaoFilterBundle::class)) {
            return;
        }

        PaletteManipulator::create()
            ->addField('addNoUiSliderSupport', 'inputGroup', PaletteManipulator::POSITION_BEFORE)
            ->applyToPalette(ChoiceType::TYPE, 'tl_filter_config_element');

        PaletteManipulator::create()
            ->addField('addNoUiSliderSupport', 'hideLabel', PaletteManipulator::POSITION_AFTER)
            ->applyToPalette(MultipleRangeType::TYPE, 'tl_filter_config_element');

        $GLOBALS['TL_DCA']['tl_filter_config_element']['fields']['addNoUiSliderSupport'] = [
            'exclude'   => true,
            'inputType' => 'checkbox',
            'eval'      => ['tl_class' => 'w50'],
            'sql'       => "char(1) NOT NULL default ''",
        ];
    }

}