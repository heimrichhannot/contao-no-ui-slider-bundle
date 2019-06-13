<?php


namespace HeimrichHannot\NoUiSliderBundle\EventListener;


use Contao\System;
use HeimrichHannot\FilterBundle\Event\AdjustFilterOptionsEvent;

class AfterChoiceGetOptionsEventListener
{
    const RANGE_STEP_MIN = 'min';
    const RANGE_STEP_MAX = 'max';

    /**
     * @param AdjustFilterOptionsEvent $event
     */
    public function onAdjustFilterOptions(AdjustFilterOptionsEvent $event): void
    {
        $element = $event->getElement();

        if (!$element->addNoUiSliderSupport) {
            return;
        }

        $options = $event->getOptions();

        if (empty($choices = $options['choices'])) {
            return;
        }

        $valueMapping = [static::RANGE_STEP_MIN => 0];
        $nameMapping  = [];

        $i = 1;

        foreach ($choices as $key => $choice) {
            // skip zero -> already done above
            if (!$key)
            {
                continue;
            }

            $valueMapping[$this->getStepIndex($choices, $i)] = (int)$choice;
            $nameMapping[$choice]                              = $key;

            $i++;
        }

        $options['multiple']                   = false;
        $options['expanded']                   = true;
        $options['attr']['data-no-ui-slider']         = 1;
        $options['attr']['data-steps']         = \json_encode($valueMapping);
        $options['attr']['data-titles']        = \json_encode($nameMapping);
        $options['attr']['data-label']         = $this->getLabel($element, $event->getBuilder(), $nameMapping);
        $options['attr']['data-default-label'] = System::getContainer()->get('translator')->trans('huh.filter.checked.unselected');

        $event->setOptions($options);
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

        return ((floor(100 / count($choices))) * $i) . '%';
    }
}