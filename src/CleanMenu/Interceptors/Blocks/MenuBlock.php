<?php

declare(strict_types=1);

namespace Maginium\AdminCleanMenu\Interceptors\Blocks;

use Magento\Backend\Block\Menu;
use Maginium\AdminCleanMenu\Models\Config;

/**
 * Class MenuBlock.
 *
 * A plugin class for modifying the navigation menu before it is rendered.
 */
final class MenuBlock
{
    /**
     * Maximum number of items allowed in a single column.
     */
    private const MAX_ITEMS = 10;

    /**
     * Modify the navigation menu before rendering.
     *
     * This method adjusts the menu level, limits the number of items, and modifies
     * column break settings if certain conditions are met.
     *
     * @param Menu $subject The menu block being modified.
     * @param mixed $menu The menu object to be rendered.
     * @param int $level The current depth level of the menu.
     * @param int $limit The item limit for the menu level.
     * @param array|null $colBrakes Column break settings for the menu.
     *
     * @return array Modified parameters: menu, level, limit, and column breaks.
     */
    public function beforeRenderNavigation(
        Menu $subject,
        $menu,
        int $level = 0,
        int $limit = 0,
        ?array $colBrakes = null,
    ): array {
        // Retrieve the first available item in the menu.
        $firstItem = $menu->getFirstAvailable();

        // Check if the menu is at level 1 and if the first item's tooltip matches the target configuration.
        if (
            $level === 1 &&
            $firstItem &&
            $firstItem->toArray()['toolTip'] === Config::MENU_ID
        ) {
            // Reset the menu level and apply the maximum item limit.
            $level = 0;
            $limit = self::MAX_ITEMS;

            // Modify the column break settings to align with the new item limit.
            foreach ($colBrakes ?? [] as $key => $colBrake) {
                if (isset($colBrake['colbrake'])) {
                    if ($colBrake['colbrake']) {
                        // Disable the existing column break if it is set.
                        $colBrakes[$key]['colbrake'] = false;
                    } elseif (($key - 1) % $limit === 0) {
                        // Enable a new column break at positions aligned with the item limit.
                        $colBrakes[$key]['colbrake'] = true;
                    }
                }
            }
        }

        // Return the modified parameters for rendering the navigation menu.
        return [$menu, $level, $limit, $colBrakes];
    }
}
