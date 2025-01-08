<?php

declare(strict_types=1);

namespace Maginium\AdminCleanMenu\Models;

use Maginium\AdminCleanMenu\Spi\ListInterface;
use Maginium\AdminCleanMenu\Spi\RuleConfigInterface;
use Maginium\Framework\Support\Arr;
use Maginium\Framework\Support\Facades\Config;
use Maginium\Framework\Support\Php;

/**
 * Class RuleConfig.
 *
 * This class provides configuration for rules by fetching settings
 * such as rule IDs, items, and default items from various configuration paths.
 */
final class RuleConfig implements RuleConfigInterface
{
    /**
     * @var ListInterface Provides a list of modules or items for configuration.
     */
    private $list;

    /**
     * @var array Configuration paths for fetching rule-related settings.
     */
    private $configPaths;

    /**
     * @var array Caches configuration values for efficient retrieval.
     */
    private $configCache;

    /**
     * RuleConfig constructor.
     *
     * Initializes the class with a list interface and configuration paths.
     *
     * @param ListInterface $list Provides the list of items to fetch configurations.
     * @param array $configPaths Array of paths for accessing configuration values.
     */
    public function __construct(
        ListInterface $list,
        array $configPaths = [],
    ) {
        // Assign the injected dependencies to the respective class properties.
        $this->list = $list;
        $this->configPaths = $configPaths;
    }

    /**
     * Get the rule ID from configuration.
     *
     * Fetches the rule ID from the configuration using the `ruleId` path.
     * The value is cached for subsequent access.
     *
     * @return string The rule ID as a string.
     */
    public function getRuleId(): string
    {
        // Check if the rule ID is already cached; if not, fetch and cache it.
        return $this->configCache['ruleId'] ??
            ($this->configCache['ruleId'] = (string)Config::getString(
                $this->configPaths['ruleId'],
            ));
    }

    /**
     * Get the items from configuration.
     *
     * Retrieves a list of items from the configuration. The value is split
     * into an array using commas and cached for efficiency.
     *
     * @return array An array of items from the configuration.
     */
    public function getItems(): array
    {
        // Check if the items are already cached; if not, fetch and cache them.
        return $this->configCache['items'] ??
            ($this->configCache['items'] = Php::explode(
                ',',
                Config::getString($this->configPaths['items']) ?? '',
            ));
    }

    /**
     * Get the default items from configuration.
     *
     * Returns a list of default items by retrieving all keys from the list
     * interface. The result is cached for performance optimization.
     *
     * @return array An array of default items.
     */
    public function getDefaultItems(): array
    {
        // Check if the default list is cached; if not, fetch and cache it.
        return $this->configCache['defaultItems'] ??
            ($this->configCache['defaultItems'] = Arr::keys(
                $this->list->getList(),
            ));
    }
}
