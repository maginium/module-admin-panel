<?php

declare(strict_types=1);

namespace Maginium\AdminCleanMenu\Spi;

/**
 * Interface RuleConfigInterface.
 *
 * Represents a configuration interface for rule settings.
 */
interface RuleConfigInterface
{
    /**
     * Get the rule ID.
     *
     * @return string
     */
    public function getRuleId(): string;

    /**
     * Get the items for the rule.
     *
     * @return array
     */
    public function getItems(): array;

    /**
     * Get the default items for the rule.
     *
     * @return array
     */
    public function getDefaultItems(): array;
}
