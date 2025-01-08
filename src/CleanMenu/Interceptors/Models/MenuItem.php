<?php

declare(strict_types=1);

namespace Maginium\AdminCleanMenu\Interceptors\Models;

use Magento\Backend\Model\Menu\Item;
use Maginium\AdminCleanMenu\Models\Config;
use Maginium\AdminCleanMenu\Models\IsAllowedMenuChildren;

/**
 * Class MenuItem.
 *
 * A plugin class for modifying menu items, including tooltips for children
 * and ACL (Access Control List) enforcement for specific menu items.
 */
final class MenuItem
{
    /**
     * Service for checking if menu children are allowed.
     *
     * @var IsAllowedMenuChildren
     */
    private $isAllowedMenuChildren;

    /**
     * MenuItem constructor.
     *
     * Initializes the service used to validate menu children permissions.
     *
     * @param IsAllowedMenuChildren $isAllowedMenuChildren Service for validating allowed menu children.
     */
    public function __construct(IsAllowedMenuChildren $isAllowedMenuChildren)
    {
        $this->isAllowedMenuChildren = $isAllowedMenuChildren;
    }

    /**
     * Add a tooltip to the first child item of the specified menu ID.
     *
     * This method checks if the current menu item matches the configured menu ID
     * and, if so, assigns a tooltip to its first available child.
     *
     * @param Item $subject The current menu item being processed.
     * @param mixed $result The list of children for the current menu item.
     *
     * @return mixed The modified list of children with updated tooltips.
     */
    public function afterGetChildren(Item $subject, $result)
    {
        // Check if the current menu item's ID matches the configured menu ID.
        if ($subject->getId() === Config::MENU_ID) {
            // Retrieve the first available child item.
            $firstItem = $result->getFirstAvailable();

            // If a valid first item is found, set its tooltip to the configured menu ID.
            if ($firstItem && $firstItem->getId()) {
                $firstItem->setTooltip(Config::MENU_ID);
            }
        }

        // Return the modified children list.
        return $result;
    }

    /**
     * Force allowed ACL (Access Control List) for the Extensions menu.
     *
     * This method ensures that ACL validation is overridden for the specified menu ID
     * by delegating the decision to a custom service.
     *
     * @param Item $subject The current menu item being processed.
     * @param bool $result The default ACL check result.
     *
     * @return bool The modified ACL check result.
     */
    public function afterIsAllowed(Item $subject, bool $result): bool
    {
        // Retrieve the resource associated with the current menu item.
        $resource = $subject->toArray()['resource'] ?? '';

        // If the resource matches the configured menu ID, use the custom validation service.
        return $resource === Config::MENU_ID
            ? $this->isAllowedMenuChildren->execute($subject)
            : $result; // Otherwise, return the default result.
    }
}
