<?php


namespace HeimrichHannot\NoUiSliderBundle\EventListener;


use Contao\System;
use HeimrichHannot\FilterBundle\Event\AdjustFilterOptionsEvent;
use HeimrichHannot\FilterBundle\Filter\Type\ChoiceType;
use HeimrichHannot\FilterBundle\Filter\Type\MultipleRangeType;

class AfterChoiceGetOptionsEventListener
{
    const RANGE_STEP_MIN = 'min';
    const RANGE_STEP_MAX = 'max';

    /**
     * @param AdjustFilterOptionsEvent $event
     */
    public function onAdjustFilterOptions(AdjustFilterOptionsEvent $event): void
    {
        $element      = $event->getElement();
        $filterConfig = $event->getConfig();

        if (!$element->addNoUiSliderSupport) {
            return;
        }

        $options = $event->getOptions();

        switch ($element->type) {
            case MultipleRangeType::TYPE:
                $startElement = $filterConfig->getElementByValue($element->startElement);
                $stopElement = $filterConfig->getElementByValue($element->stopElement);

                // get options from first linked field
                $choices = System::getContainer()->get('huh.utils.dca')->getConfigByArrayOrCallbackOrFunction(
                    $GLOBALS['TL_DCA'][$filterConfig->getFilter()['dataContainer']]['fields'][$startElement->field],
                    'options'
                );

                $valueMapping = [static::RANGE_STEP_MIN => 0];
                $nameMapping  = [];

                $i = 1;

                // skip zero -> already done above
                if (isset($choices[0]))
                {
                    unset($choices[0]);
                }

                foreach ($choices as $key => $value) {
                    $valueMapping[$this->getStepIndex($choices, $i)] = (int)$value;
                    $nameMapping[$value]                             = $key;

                    $i++;
                }

                $options['attr']['data-no-ui-slider'] = true;
                $options['attr']['data-no-ui-slider-start-field'] = '#' . $filterConfig->getFilter()['name'] . '_' . $element->getFormName($filterConfig) . '_' . $startElement->getFormName($filterConfig);
                $options['attr']['data-no-ui-slider-stop-field'] = '#' . $filterConfig->getFilter()['name'] . '_' . $element->getFormName($filterConfig) . '_' . $stopElement->getFormName($filterConfig);

                $config = [
                    'isMultipleRange' => true,
                    'defaultStart' => [0, max($choices)],
                    'range'         => $valueMapping,
                    'titles'        => $nameMapping,
                    'label'         => $this->getLabel($element, $event->getBuilder(), $nameMapping),
                    'defaultLabel' => System::getContainer()->get('translator')->trans('huh.filter.checked.unselected'),
                ];

                $options['attr']['data-no-ui-slider-config'] = \json_encode($config);

                $event->setOptions($options);

                break;
            case ChoiceType::TYPE:
                $choices = $options['choices'];

                if (empty($choices)) {
                    return;
                }

                $valueMapping = [static::RANGE_STEP_MIN => 0];
                $nameMapping  = [];

                $i = 1;

                foreach ($choices as $key => $choice) {
                    // skip zero -> already done above
                    if (!$key) {
                        continue;
                    }

                    $valueMapping[$this->getStepIndex($choices, $i)] = (int)$choice;
                    $nameMapping[$choice]                            = $key;

                    $i++;
                }

                $options['multiple']                   = false;
                $options['expanded']                   = true;
                $options['attr']['data-no-ui-slider']  = true;

                $config = [
                    'defaultStart' => 0,
                    'range'         => $valueMapping,
                    'titles'        => $nameMapping,
                    'label'         => $this->getLabel($element, $event->getBuilder(), $nameMapping),
                    'defaultLabel' => System::getContainer()->get('translator')->trans('huh.filter.checked.unselected'),
                ];

                $options['attr']['data-no-ui-slider-config'] = \json_encode($config);

                $event->setOptions($options);
                break;
        }
    }

    /**
     * @param $element
     * @param $builder
     * @param $nameMapping
     * @return string
     */
    protected function getLabel($element, $builder, $nameMapping): string
    {
        if (!($value = $builder->getData()[$element->field])) {
            return System::getContainer()->get('translator')->trans('huh.filter.checked.unselected');
        }

        return $nameMapping[$value];
    }

    /**
     * @param array $choices
     * @param int $i
     * @return float|int|string
     */
    protected function getStepIndex(array $choices, int $i)
    {
        if ($i == count($choices)) {
            return static::RANGE_STEP_MAX;
        }

        return ((100 / count($choices)) * $i) . '%';
    }
}