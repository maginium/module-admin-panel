<?php

declare(strict_types=1);

namespace Maginium\AdminCleanMenu\Models;

use Maginium\AdminCleanMenu\Interfaces\IsAllowedInterface;
use Maginium\Framework\Support\Facades\Config;
use Maginium\Framework\Support\Php;

/**
 * Class IsAllowedMenuId.
 *
 * This class determines if a menu ID is allowed based on the configuration settings.
 */
final class IsAllowedMenuId implements IsAllowedInterface
{
    /**
     * Configuration path for allowed menu IDs.
     */
    private const CONFIG_PATH_ALLOWED_MENU_IDS = 'clean_admin_menu/developer/allowed_menu_ids';

    /**
     * Check if a menu ID is allowed.
     *
     * @param string $name Menu ID to check.
     *
     * @return bool True if the menu ID is allowed, false otherwise.
     */
    public function isAllowed(string $name): bool
    {
        return Php::inArray($name, $this->resolveAllowedMenus(), true);
    }

    /**
     * Resolve the list of allowed menu IDs from configuration.
     *
     * @return array List of allowed menu IDs.
     */
    public function resolveAllowedMenus(): array
    {
        // Get the configuration value for allowed menu IDs and split it into an array
        return preg_split(
            '/\r\n|[\r\n]/',
            (string)Config::getString(
                self::CONFIG_PATH_ALLOWED_MENU_IDS,
            ),
        ) ?:
        [];
    }
}
