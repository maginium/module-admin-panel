<?php

declare(strict_types=1);

namespace Maginium\AdminChosenJS\Interceptors\Form\Element;

use Maginium\Framework\Support\Php;
use Maginium\Framework\Support\Validator;

/**
 * Class Select.
 */
class Select
{
    /**
     * Plugin to add Chosen script to Select form element.
     *
     * @param \Magento\Framework\Data\Form\Element\Select $subject The Select element.
     * @param string $result The original HTML result.
     *
     * @return string The modified HTML result with the Chosen script.
     */
    public function afterGetElementHtml(
        \Magento\Framework\Data\Form\Element\Select $subject,
        $result,
    ) {
        // Extract the classes from the Select element.
        $classes = Php::explode(' ', $subject->getClass());

        // Check if the Select element has specific classes, and skip processing if true.
        if (
            Validator::inArray('on-off-trigger', $classes) ||
            Validator::inArray('select-image', $classes)
        ) {
            return $result;
        }

        // Generate Chosen script for the Select element.
        $select2Script = $this->getChosenScript($subject->getHtmlId());

        // Append the Chosen script to the original HTML result.
        $result .= $select2Script;

        return $result;
    }

    /**
     * Generate the Chosen script for a specific Select element.
     *
     * @param string $htmlId The HTML ID of the Select element.
     *
     * @return string The Chosen script.
     */
    private function getChosenScript(string $htmlId): string
    {
        // Define the Chosen script using a template string.
        return "
            <script type='text/javascript'>
                // Load dependencies and execute script after a delay.
                require([
                    'jquery',
                    'prototype',
                    'Maginium_AdminChosenJS/js/chosen.proto'
                ], function($){
                    setTimeout(function() {
                        // Select the Select element.
                        var element = document.querySelector('#{$htmlId}');
                        // Check if the element exists.
                        if (!element) return;

                        // Check if the 'Please select' option needs to be added.
                        var plzSel = 0;
                        element.childNodes.forEach(function(opt, index) {
                            if(opt.value == '') {
                                plzSel = 1;
                                if (opt.innerHTML.trim() == '') {
                                    opt.innerHTML = 'Please select';
                                }
                            }
                        });

                        // Add the 'Please select' option if needed.
                        if (plzSel == 0) {
                            element.insertAdjacentHTML('beforeend', '<option value=\"\">Please select</option>');
                        }

                        // Calculate the width of the element for Chosen.
                        var elwidth = element.offsetWidth;
                        if (elwidth <= 0) {
                            elwidth = '100%';
                        } else {
                            elwidth = elwidth + 'px';
                        }
                        // Initialize Chosen for the element.
                        new Chosen(element, {width: elwidth});

                        // Observe changes in the element's attributes and update Chosen accordingly.
                        var observer = new MutationObserver(function(mutations) {
                            mutations.forEach(function(mutation) {
                                // Fire chosen:updated event when attributes change.
                                Event.fire(element, 'chosen:updated');
                                // Hide the element if its style changes.
                                if (mutation.type == 'attributes') {
                                    if (mutation.attributeName == 'style') {
                                        element.style.display = 'none';
                                    }
                                }
                            });
                        });
                        // Start observing the element.
                        observer.observe(element, {
                            subtree: true,
                            childList: true,
                            attributes: true
                        });
                    }, 1000); // Delay execution to ensure element is rendered.
                });
            </script>
        ";
    }
}
