<?php

declare(strict_types=1);

namespace Maginium\AdminKeyboardShortcuts\Blocks;

use Magento\Backend\Model\UrlInterface as BackendUrl;
use Magento\Backend\Setup\ConfigOptionsList;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Maginium\AdminKeyboardShortcuts\Interfaces\Data\HotKeyShortcutInterface;
use Maginium\Framework\Config\Enums\ConfigDrivers;
use Maginium\Framework\Support\Facades\Config;
use Maginium\Framework\Support\Path;

/**
 * Block class responsible for rendering icon configuration settings.
 */
class HotKeyShortcut extends Template
{
    /**
     * @var BackendUrl
     */
    private BackendUrl $backendUrl;

    /**
     * @var HotKeyShortcutInterface Icon configuration interface for fetching data.
     */
    private HotKeyShortcutInterface $hotKeyShortcut;

    /**
     * Constructor.
     *
     * Initializes the block with necessary dependencies, including the backend URL configuration and hotkey shortcut data.
     *
     * @param Context $context The template context that provides necessary context for the rendering process.
     * @param BackendUrl $backendUrl The service for managing backend URL configurations, used to interact with backend settings.
     * @param HotKeyShortcutInterface $hotKeyShortcut Interface that defines methods for handling hotkey shortcut configuration data.
     * @param array $data Optional additional data for the template, such as layout-related information or custom configuration.
     */
    public function __construct(
        Context $context,
        BackendUrl $backendUrl,
        HotKeyShortcutInterface $hotKeyShortcut,
        array $data = [],
    ) {
        parent::__construct($context, $data);

        $this->backendUrl = $backendUrl;
        $this->hotKeyShortcut = $hotKeyShortcut;
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
        return $this->hotKeyShortcut->all();
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
        return $this->hotKeyShortcut->has($id);
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
        return $this->hotKeyShortcut->get($id) ?? $default;
    }

    /**
     * Generate the full backend URL for a given route.
     *
     * Constructs the full backend URL by combining the backend front name
     * and the specified route using the backend URL helper.
     *
     * @param string|null $route The relative route to generate the URL for. Defaults to an empty string.
     *
     * @return string The constructed full backend URL.
     */
    public function getBackendUrl(?string $route = ''): string
    {
        // Retrieve the backend front name from the configuration.
        $backendFrontName = Config::driver(ConfigDrivers::DEPLOYMENT)->getString(ConfigOptionsList::CONFIG_PATH_BACKEND_FRONTNAME);

        // Construct the relative path by joining the backend front name and the relative route.
        $relativePath = Path::join($backendFrontName, $route);

        // Generate and return the complete backend URL.
        return Path::join($this->backendUrl->getRouteUrl($route), $relativePath);
    }
}
