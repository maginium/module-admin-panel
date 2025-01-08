<?php

declare(strict_types=1);

namespace Maginium\AdminCleanMenu\Interfaces;

/**
 * Interface IsAllowedInterface.
 */
interface IsAllowedInterface
{
    /**
     * Checks if the specified name is allowed.
     *
     * @param string $name The name to check.
     *
     * @return bool True if the name is allowed, false otherwise.
     */
    public function isAllowed(string $name): bool;
}
