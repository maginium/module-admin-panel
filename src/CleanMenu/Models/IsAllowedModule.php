<?php

declare(strict_types=1);

namespace Maginium\AdminCleanMenu\Models;

use Maginium\AdminCleanMenu\Interfaces\IsAllowedInterface;
use Maginium\Framework\Support\Facades\Config;

/**
 * Class IsAllowedModule.
 *
 * This class determines if a module is allowed based on the configuration settings.
 */
final class IsAllowedModule implements IsAllowedInterface
{
    /**
     * Name of the Magento Marketplace module.
     */
    private const MODULE_NAME = 'Magento_Marketplace';

    /**
     * Configuration path for the flag indicating if Magento Marketplace should be moved.
     */
    private const CONFIG_PATH_MAGENTO_MARKETPLACE_MOVED = 'clean_admin_menu/marketplace/move';

    /**
     * @var IsAllowedInterface
     */
    private $isAllowed;

    /**
     * IsAllowedModule constructor.
     *
     * @param IsAllowedInterface $isAllowed
     */
    public function __construct(
        IsAllowedInterface $isAllowed,
    ) {
        $this->isAllowed = $isAllowed;
    }

    /**
     * Check if a module is allowed.
     *
     * @param string $name Module name to check.
     *
     * @return bool True if the module is allowed, false otherwise.
     */
    public function isAllowed(string $name): bool
    {
        $isAllowed = true;

        // Check if the module is Magento Marketplace and if it should be moved
        if ($name === self::MODULE_NAME) {
            $isAllowed = ! Config::getBool(
                self::CONFIG_PATH_MAGENTO_MARKETPLACE_MOVED,
            );
        }

        // Check if the module is allowed based on the general rules
        return $isAllowed && $this->isAllowed->isAllowed($name);
    }
}
