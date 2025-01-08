<?php

declare(strict_types=1);

namespace Maginium\AdminEmptyStates\Interceptors\Backend\Blocks\Widget\Grid;

use Magento\Backend\Block\Widget\Grid\Extended;

/**
 * Plugin for extending the functionality of the Magento backend grid.
 *
 * This plugin modifies the behavior of adding columns to the grid,
 * specifically to change the renderer of the 'status' column in the 'reviewGrid'.
 */
class ExtendedPlugin
{
    /**
     * Intercept the behavior before `prepareLayout()` is called on the block.
     *
     * @param Extended $subject The intercepted block instance.
     *
     * @return void
     */
    public function beforeGetTemplate(Extended $subject): void
    {
        $subject->setTemplate('Maginium_AdminEmptyStates::widget/grid/extended.phtml');
    }
}
