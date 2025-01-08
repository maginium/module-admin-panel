<?php

declare(strict_types=1);

namespace Maginium\AdminConfigIcon\Blocks;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Maginium\AdminConfigIcon\Interfaces\Data\ConfigIconInterface;

/**
 * Block class responsible for rendering icon configuration settings.
 */
class ConfigIcon extends Template
{
    /**
     * @var ConfigIconInterface Icon configuration interface for fetching data.
     */
    private ConfigIconInterface $configIcon;

    /**
     * Constructor.
     *
     * Initializes the block with necessary dependencies.
     *
     * @param Context $context The template context.
     * @param ConfigIconInterface $configIcon The icon configuration data provider.
     * @param array $data Optional additional data for the template.
     */
    public function __construct(
        Context $context,
        ConfigIconInterface $configIcon,
        array $data = [],
    ) {
        parent::__construct($context, $data);

        $this->configIcon = $configIcon;
    }

    /**
     * Retrieve the icon configuration settings.
     *
     * This method fetches and returns an array of configuration settings
     * for the icon widget from the injected configuration provider.
     *
     * @return array<string, mixed> An array of icon configuration settings.
     */
    public function getItems(): array
    {
        return $this->configIcon->getItems();
    }

    /**
     * Check if the configuration contains a specific item.
     *
     * @param string $id The id to check in the configuration settings.
     *
     * @return bool True if the item exists, false otherwise.
     */
    public function hasConfigKey(string $id): bool
    {
        return $this->configIcon->hasItem($id);
    }

    /**
     * Retrieve a specific configuration item by id.
     *
     * @param string $id The id of the configuration item to retrieve.
     * @param mixed $default The default value to return if the item does not exist.
     *
     * @return mixed The configuration value or the default value if the item is not found.
     */
    public function getConfigItem(string $id, $default = null)
    {
        return $this->configIcon->getItemById($id) ?? $default;
    }
}
