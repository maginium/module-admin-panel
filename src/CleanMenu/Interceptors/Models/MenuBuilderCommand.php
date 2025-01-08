<?php

declare(strict_types=1);

namespace Maginium\AdminCleanMenu\Interceptors\Models;

use Magento\Backend\Model\Menu\Builder\AbstractCommand;
use Maginium\AdminCleanMenu\Models\Config;
use Maginium\AdminCleanMenu\Models\IsAllowedMenuId;
use Maginium\AdminCleanMenu\Models\IsAllowedModule;

/**
 * Class MenuBuilderCommand.
 */
final class MenuBuilderCommand
{
    /**
     * @var IsAllowedModule
     */
    private $isAllowedModule;

    /**
     * @var IsAllowedMenuId
     */
    private $isAllowedMenuId;

    /**
     * MenuBuilderCommand constructor.
     *
     * @param IsAllowedModule $isAllowedModule
     * @param IsAllowedMenuId $isAllowedMenuId
     */
    public function __construct(
        IsAllowedModule $isAllowedModule,
        IsAllowedMenuId $isAllowedMenuId,
    ) {
        $this->isAllowedModule = $isAllowedModule;
        $this->isAllowedMenuId = $isAllowedMenuId;
    }

    /**
     * Add the parent ID for menu items based on the module or menu ID being allowed.
     *
     * @param AbstractCommand $subject
     * @param array $result
     *
     * @return array
     */
    public function afterExecute(AbstractCommand $subject, array $result): array
    {
        // Check if the menu item's ID or module is allowed, and set the parent ID to the configured menu ID.
        if (
            (isset($result['id']) &&
                $this->isAllowedMenuId->isAllowed($result['id'])) ||
            (isset($result['module']) &&
                ! isset($result['parent']) &&
                ! $this->isAllowedModule->isAllowed($result['module']))
        ) {
            $result['parent'] = Config::MENU_ID;
        }

        return $result;
    }
}
