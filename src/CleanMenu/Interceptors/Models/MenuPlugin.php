<?php

declare(strict_types=1);

namespace Maginium\AdminCleanMenu\Interceptors\Models;

use Magento\Backend\Model\Menu;
use Magento\Backend\Model\Menu\Item;
use Maginium\AdminCleanMenu\Models\Config;
use Maginium\AdminCleanMenu\Models\IsAllowedMenuId;
use Maginium\AdminCleanMenu\Models\IsAllowedModule;

/**
 * Class MenuPlugin.
 *
 * A plugin class for modifying menu items before they are added to the backend menu structure.
 */
class MenuPlugin
{
    /**
     * Service for checking if a module is allowed.
     *
     * @var IsAllowedModule
     */
    private $isAllowedModule;

    /**
     * Service for checking if a menu ID is allowed.
     *
     * @var IsAllowedMenuId
     */
    private $isAllowedMenuId;

    /**
     * MenuPlugin constructor.
     *
     * Initializes services used for validating module and menu item permissions.
     *
     * @param IsAllowedModule $isAllowedModule Service to check module permissions.
     * @param IsAllowedMenuId $isAllowedMenuId Service to check menu ID permissions.
     */
    public function __construct(
        IsAllowedModule $isAllowedModule,
        IsAllowedMenuId $isAllowedMenuId,
    ) {
        $this->isAllowedModule = $isAllowedModule;
        $this->isAllowedMenuId = $isAllowedMenuId;
    }

    /**
     * Modify the menu item before adding it to the menu.
     *
     * Adjusts the parent ID for menu items based on specific rules related to menu ID
     * and module permissions. If the parent ID is null and the menu configuration ID is present,
     * this method assigns the configured menu ID as the parent ID.
     *
     * @param Menu $subject The menu object being modified.
     * @param Item $item The menu item being added.
     * @param mixed|null $parentId The ID of the parent menu item.
     * @param mixed|null $index The index at which the item is being added.
     *
     * @return array Modified parameters: item, parentId, and index.
     */
    public function beforeAdd(
        Menu $subject,
        Item $item,
        $parentId = null,
        $index = null,
    ): array {
        // Retrieve the module name associated with the menu item, if available.
        $module = $item->toArray()['module'] ?? null;

        // Check if the parent ID is null, and validate menu ID and module permissions.
        if (
            $parentId === null &&
            $subject->get(Config::MENU_ID) && // Check if the menu contains the configured menu ID.
            (
                $this->isAllowedMenuId->isAllowed($item->getId()) || // Allow if the menu ID is valid.
                ! $this->isAllowedModule->isAllowed($module) // Disallow if the module is invalid.
            )
        ) {
            // Assign the configured menu ID as the parent ID.
            $parentId = Config::MENU_ID;
        }

        // Return the modified parameters for adding the menu item.
        return [$item, $parentId, $index];
    }
}
