<?php

declare(strict_types=1);

namespace Maginium\AdminCleanMenu\Models;

use Magento\Backend\Model\Menu\Item;

/**
 * Class IsAllowedMenuChildren.
 *
 * This class provides functionality to determine whether a menu item has any children
 * that are both allowed and not disabled.
 */
final class IsAllowedMenuChildren
{
    /**
     * Check if any child item of the given menu item is allowed and not disabled.
     *
     * @param Item $menuItem The menu item whose children will be checked.
     *
     * @return bool Returns true if at least one child menu item is allowed and not disabled, otherwise false.
     */
    public function execute(Item $menuItem): bool
    {
        // Retrieve the children of the provided menu item.
        $children = $menuItem->getChildren();

        // Check if the retrieved children are iterable.
        // If not, return false since no valid children exist to evaluate.
        if (! is_iterable($children)) {
            return false;
        }

        // Iterate over each child menu item.
        foreach ($children as $child) {
            // Check if the current child is allowed and not disabled.
            if ($child->isAllowed() && ! $child->isDisabled()) {
                // Return true as soon as we find a valid child that meets the criteria.
                return true;
            }
        }

        // If no child meets the criteria, return false.
        return false;
    }
}
