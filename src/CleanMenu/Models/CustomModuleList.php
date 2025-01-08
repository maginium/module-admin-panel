<?php

declare(strict_types=1);

namespace Maginium\AdminCleanMenu\Models;

use Magento\Framework\Component\ComponentRegistrarInterface;
use Maginium\AdminCleanMenu\Spi\ListInterface;
use Maginium\Framework\Component\ComponentRegistrar;
use Maginium\Framework\Support\Arr;
use Maginium\Framework\Support\Str;

/**
 * Provides a list of custom modules, excluding Magento core modules and the current module.
 */
final class CustomModuleList implements ListInterface
{
    /**
     * The prefix used to identify Magento core modules.
     */
    private const MAGENTO_MODULE_PREFIX = 'Magento_';

    /**
     * The name of the current module.
     */
    private const MODULE_NAME = 'Maginium_AdminCleanMenu';

    /**
     * @var ComponentRegistrarInterface The registrar used to retrieve module paths.
     */
    private $componentRegistrar;

    /**
     * @var array|null Cached list of custom modules.
     */
    private $list;

    /**
     * Constructor.
     *
     * Initializes the class with the component registrar dependency.
     *
     * @param ComponentRegistrarInterface $componentRegistrar The registrar for retrieving module paths.
     */
    public function __construct(ComponentRegistrarInterface $componentRegistrar)
    {
        $this->componentRegistrar = $componentRegistrar;
    }

    /**
     * Retrieve the list of custom modules.
     *
     * If the list has already been prepared, it returns the cached value; otherwise, it prepares a new list.
     *
     * @return array Returns an array where each key and value is the name of a custom module.
     */
    public function getList(): array
    {
        return $this->list ?? ($this->list = $this->prepareList());
    }

    /**
     * Prepare the list of custom modules.
     *
     * Filters out Magento core modules and the current module from the list of all registered modules.
     *
     * @return array Returns an associative array of custom module names.
     */
    private function prepareList(): array
    {
        // Retrieve custom modules by resolving them from all registered modules.
        $customModules = $this->resolveCustomModules();

        // Create an associative array where each key and value is the module name.
        return Arr::combine($customModules, $customModules);
    }

    /**
     * Resolve custom modules from all registered modules.
     *
     * Filters out modules that:
     * - Start with the `MAGENTO_MODULE_PREFIX` (Magento core modules).
     * - Match the current module name (`MODULE_NAME`).
     *
     * @return array Returns a list of custom module names.
     */
    private function resolveCustomModules(): array
    {
        return Arr::keys(
            Arr::filter(
                // Get all module paths registered under the `MODULE` component type.
                $this->componentRegistrar->getPaths(ComponentRegistrar::MODULE),

                // Filter the modules based on the module name.
                static function(string $moduleName): bool {
                    // Exclude modules that:
                    // 1. Start with the `MAGENTO_MODULE_PREFIX`.
                    // 2. Match the name of the current module.
                    return strncmp(
                        $moduleName,
                        self::MAGENTO_MODULE_PREFIX,
                        Str::length(self::MAGENTO_MODULE_PREFIX),
                    ) !== 0 && $moduleName !== self::MODULE_NAME;
                },

                // Specify that the array keys should be used for filtering.
                ARRAY_FILTER_USE_KEY,
            ),
        );
    }
}
