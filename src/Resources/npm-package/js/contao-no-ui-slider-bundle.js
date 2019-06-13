import noUiSlider from 'nouislider';
import 'nouislider/distribute/nouislider.css';

class NoUiSliderBundle {
    static init() {
        NoUiSliderBundle.initSlider();
        NoUiSliderBundle.initObserver();
    }

    static initSlider() {
        document.querySelectorAll('[data-no-ui-slider]').forEach((elem) => {
            let range = JSON.parse(elem.getAttribute('data-steps')),
                checked = elem.querySelector('input:checked'),
                start = checked ? checked.value : 0;

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
                NoUiSliderBundle.updateLabel(elem);
            });

            elem.noUiSlider.on('change', function() {
                let value = Math.floor(elem.noUiSlider.get());

                if (0 === value) {
                    elem.querySelector('input:checked').checked = false;

                    if (elem.closest('.mod_filter') !== null) {
                        elem.closest('form').submit();
                    }
                } else {
                    elem.querySelector('[value="' + value + '"]').click();
                }
            });
        });
    }

    static initObserver() {
        let initialized = false,
            observer = new MutationObserver(function(mutations) {
                mutations.forEach((mutation) => {
                    if (mutation.target.getAttribute('data-submit-success') && mutation.target.querySelector('[data-no-ui-slider]') && !initialized) {
                        NoUiSliderBundle.init();
                        initialized = true;
                    }
                });
            });

        document.querySelectorAll('.mod_filter form').forEach((form) => {
            observer.observe(form, {attributes: true, childList: true, characterData: true});
        });
    }

    static visibleForSROnly(field) {
        field.querySelectorAll('.form-check, input, label, select').forEach((elem) => {
            elem.classList.add('sr-only');
        });
    }

    static updateLabel(elem) {
        let label = elem.parentNode.querySelector('.checkedValue');

        if (label) {
            label.textContent = NoUiSliderBundle.getLabelFromMapping(elem, Math.floor(elem.noUiSlider.get()));
            return;
        }

        label = document.createElement('label');
        label.classList.add('checkedValue');
        label.textContent = elem.getAttribute('data-label');
        elem.parentNode.insertBefore(label, elem.nextSibling);
    }

    static getLabelFromMapping(elem, value) {
        let mapping = JSON.parse(elem.getAttribute('data-titles'));

        if (!mapping[value]) {
            return elem.getAttribute('data-default-label');
        }

        return mapping[value];
    }
}

export {NoUiSliderBundle};