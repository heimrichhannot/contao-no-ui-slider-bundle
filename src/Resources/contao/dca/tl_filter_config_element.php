<?php

if (\Contao\System::getContainer()->get('huh.utils.container')->isBundleActive('HeimrichHannot\FilterBundle\HeimrichHannotContaoFilterBundle')) {
    $dca = &$GLOBALS['TL_DCA']['tl_filter_config_element'];

    /**
     * Palettes
     */
    $dca['palettes'][\HeimrichHannot\FilterBundle\Filter\Type\ChoiceType::TYPE]        = str_replace(',inputGroup', ',addNoUiSliderSupport,inputGroup', $dca['palettes'][\HeimrichHannot\FilterBundle\Filter\Type\ChoiceType::TYPE]);
    $dca['palettes'][\HeimrichHannot\FilterBundle\Filter\Type\MultipleRangeType::TYPE] = str_replace('hideLabel', 'hideLabel,addNoUiSliderSupport', $dca['palettes'][\HeimrichHannot\FilterBundle\Filter\Type\MultipleRangeType::TYPE]);

    /**
     * Fields
     */
    $dca['fields']['addNoUiSliderSupport'] = [
        'label'     => &$GLOBALS['TL_LANG']['tl_filter_config_element']['addNoUiSliderSupport'],
        'exclude'   => true,
        'inputType' => 'checkbox',
        'eval'      => ['tl_class' => 'w50'],
        'sql'       => "char(1) NOT NULL default ''",
    ];
}