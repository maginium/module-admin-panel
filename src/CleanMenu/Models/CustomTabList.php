<?php

declare(strict_types=1);

namespace Maginium\AdminCleanMenu\Models;

use Magento\Config\Model\Config\Structure\Data;
use Maginium\AdminCleanMenu\Spi\ListInterface;
use Maginium\Framework\Support\Arr;

/**
 * Class CustomTabList.
 *
 * This class provides a list of custom tabs based on the configuration structure data.
 * It allows customization of the mandatory tabs through dependency injection.
 */
final class CustomTabList implements ListInterface
{
    /**
     * List of default mandatory tabs.
     *
     * @var array
     */
    private const DEFAULT_MANDATORY_TABS = [
        'sales',
        'general',
        'catalog',
        'service',
        'security',
        'customer',
        'advanced',
        'extensions_list',
    ];

    /**
     * List of mandatory tabs.
     *
     * @var array
     */
    private $mandatoryTabs;

    /**
     * Configuration structure data.
     *
     * @var Data
     */
    private $structureData;

    /**
     * Cached list of custom tabs.
     *
     * @var array
     */
    private $list;

    /**
     * CustomTabList constructor.
     *
     * @param Data $structureData Configuration structure data.
     * @param array $mandatoryTabs List of additional mandatory tabs.
     */
    public function __construct(Data $structureData, array $mandatoryTabs = [])
    {
        // Combine default and custom mandatory tabs
        $this->mandatoryTabs = Arr::merge(
            self::DEFAULT_MANDATORY_TABS,
            $mandatoryTabs,
        );
        $this->structureData = $structureData;
    }

    /**
     * Get the list of custom tabs.
     *
     * @return array List of custom tabs.
     */
    public function getList(): array
    {
        // Return cached list if available
        return $this->list ?? ($this->list = $this->resolveCustomTabs());
    }

    /**
     * Resolve the list of custom tabs based on the configuration data.
     *
     * @return array List of custom tabs.
     */
    private function resolveCustomTabs(): array
    {
        $data = $this->structureData->get();

        // Remove default and custom mandatory tabs from the list of all tabs
        $tabs = Arr::diff_key($data['tabs'], Arr::flip($this->mandatoryTabs));

        // Combine tab IDs with their labels
        return Arr::combine(Arr::keys($tabs), Arr::column($tabs, 'label'));
    }
}
