<?php

declare(strict_types=1);

namespace Maginium\AdminChosenJS\Interceptors\Form\Element;

/**
 * Class Time.
 */
class Time
{
    /**
     * Plugin to add Chosen script to Time form element.
     *
     * @param \Magento\Framework\Data\Form\Element\Time $subject The Time element.
     * @param string $result The original HTML result.
     *
     * @return string The modified HTML result with the Chosen script.
     */
    public function afterGetElementHtml(
        \Magento\Framework\Data\Form\Element\Time $subject,
        $result,
    ) {
        // Generate Chosen script for the Time element.
        $select2Script = $this->getChosenScript($subject->getName());

        // Append the Chosen script to the original HTML result.
        $result .= $select2Script;

        return $result;
    }

    /**
     * Generate the Chosen script for a specific Time element.
     *
     * @param string $name The name of the Time element.
     *
     * @return string The Chosen script.
     */
    private function getChosenScript(string $name): string
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
                        // Select all select elements with the same name as the Time element.
                        $$('select[name=\'{$name}\']').each(function(element){
                            // Initialize Chosen for the element with a specific width.
                            new Chosen(element, {width: '80px'});
                        });
                    }, 1000); // Delay execution to ensure element is rendered.
                });
            </script>
        ";
    }
}
