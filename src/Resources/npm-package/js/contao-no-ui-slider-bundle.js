import noUiSlider from 'nouislider';
import 'nouislider/distribute/nouislider.css';

class NoUiSliderBundle {
    static init() {
        NoUiSliderBundle.initSlider();
    }

    static initSlider() {
        document.querySelectorAll('[data-no-ui-slider]').forEach((elem) => {
            let config = JSON.parse(elem.getAttribute('data-no-ui-slider-config'));

            if (config.isMultipleRange)
            {
                let range = config.range,
                    startField = document.getElementById(elem.getAttribute('data-no-ui-slider-start-field').substr(1)),
                    stopField = document.getElementById(elem.getAttribute('data-no-ui-slider-stop-field').substr(1));

                let start = config.defaultStart;

                if (startField.value !== '' || stopField.value !== '')
                {
                    start = [startField.value, stopField.value];
                }

                if (elem.querySelector('.noUi-base')) {
                    elem.noUiSlider.destroy();
                }

                noUiSlider.create(elem, {
                    start: start,
                    snap: true,
                    range: range
                });

                if (elem.querySelector('.noUi-base')) {
                    NoUiSliderBundle.visibleForSROnly(elem);
                }

                elem.noUiSlider.on('update', function() {
                    NoUiSliderBundle.updateLabel(elem, config);
                });

                elem.noUiSlider.on('change', function() {
                    // remove .00
                    let value = elem.noUiSlider.get().map(Math.floor);

                    startField.value = value[0];
                    stopField.value = value[1];

                    if (null !== elem.closest('.mod_filter') && null !== elem.closest('[data-submit-on-change="1"]')) {
                        document.dispatchEvent(new CustomEvent('filterAsyncSubmit', {detail: {element: elem, form: elem.closest('form')}, bubbles: true, cancelable: true}));
                    }
                });
            }
            else
            {
                let range = config.range,
                    checked = elem.querySelector('input:checked'),
                    start = checked ? checked.value : config.defaultStart;

                if (elem.querySelector('.noUi-base')) {
                    elem.noUiSlider.destroy();
                }

                noUiSlider.create(elem, {
                    start: start,
                    snap: true,
                    range: range
                });

                if (elem.querySelector('.noUi-base')) {
                    NoUiSliderBundle.visibleForSROnly(elem);
                }

                elem.noUiSlider.on('update', function() {
                    NoUiSliderBundle.updateLabel(elem, config);
                });

                elem.noUiSlider.on('change', function() {
                    // remove .00
                    let value = Math.floor(elem.noUiSlider.get());

                    if (0 === value) {
                        elem.querySelector('input:checked').checked = false;

                        if (null !== elem.closest('.mod_filter') && null !== elem.closest('[data-submit-on-change="1"]')) {
                            document.dispatchEvent(new CustomEvent('filterAsyncSubmit', {detail: {element: elem, form: elem.closest('form')}, bubbles: true, cancelable: true}));
                        }
                    } else {
                        elem.querySelector('[value="' + value + '"]').click();
                    }
                });
            }
        });
    }

    static visibleForSROnly(field) {
        field.querySelectorAll('.form-check, input, label, select').forEach((elem) => {
            elem.classList.add('sr-only');
        });
    }

    static updateLabel(elem, config) {
        let label = elem.parentNode.querySelector('.checked-value'), 
            value = elem.noUiSlider.get();

        if (Array.isArray(value))
        {
            value = value.map(Math.floor);
        }
        else
        {
            value = Math.floor(value);
        }

        if (!label) 
        {
            label = document.createElement('label');
        }

        let text = NoUiSliderBundle.getLabelFromMapping(elem, value, config);

        if (text) {
            label.textContent = Array.isArray(text) ? text.join(' … ') : text;
        }
        else
        {
            label.textContent = config.label;
        }

        label.classList.add('checked-value');
    }

    static getLabelFromMapping(elem, value, config, isMultiple = false) {
        let mapping = config.titles;

        if (Array.isArray(value))
        {
            let results = [];

            value.forEach(function(val) {
                results.push(NoUiSliderBundle.getLabelFromMapping(elem, val, config, true));
            });

            return results;
        }
        else
        {
            if ('undefined' !== typeof mapping[value]) {
                return mapping[value];
            }
        }

        return isMultiple ? 0 : config.defaultLabel;
    }
}

export {NoUiSliderBundle};