<?php

declare(strict_types=1);

namespace Maginium\AdminCleanMenu\Models\Config\Backend;

use Magento\Framework\App\Cache\Manager as CacheManager;
use Magento\Framework\App\Cache\TypeListInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Config\Value;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Model\Context;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Registry;

/**
 * Custom configuration backend model for cache management.
 *
 * This class extends Magento's `Value` class to handle backend logic for
 * configuration values. It ensures cache is flushed when the associated
 * configuration value changes.
 */
class Cache extends Value
{
    /**
     * @var CacheManager Handles cache-related operations such as flushing.
     */
    private $cacheManager;

    /**
     * Constructor.
     *
     * Initializes the custom cache backend model with the required dependencies.
     *
     * @param Context $context Provides access to the current application context.
     * @param Registry $registry Enables registry usage for managing global data.
     * @param CacheManager $cacheManager Handles cache flushing operations.
     * @param ScopeConfigInterface $config Provides access to scope-specific configuration values.
     * @param TypeListInterface $cacheTypeList Allows interactions with cache types.
     * @param AbstractResource|null $resource Provides the resource model for database operations.
     * @param AbstractDb|null $resourceCollection Handles resource collections for database access.
     * @param array $data Additional data for initializing the model.
     */
    public function __construct(
        Context $context,
        Registry $registry,
        CacheManager $cacheManager,
        ScopeConfigInterface $config,
        TypeListInterface $cacheTypeList,
        ?AbstractResource $resource = null,
        ?AbstractDb $resourceCollection = null,
        array $data = [],
    ) {
        // Call parent constructor to initialize the base `Value` model.
        parent::__construct(
            $context,
            $registry,
            $config,
            $cacheTypeList,
            $resource,
            $resourceCollection,
            $data,
        );

        // Assign the CacheManager instance to the class property.
        $this->cacheManager = $cacheManager;
    }

    /**
     * Flush cache after saving configuration value if it has been changed.
     *
     * This method overrides the `afterSave` method of the parent `Value` class.
     * It checks if the configuration value has changed and flushes cache
     * related to the specified cache tags if applicable.
     *
     * @return $this Returns the current instance for method chaining.
     */
    public function afterSave()
    {
        // Check if the value of the configuration has been changed.
        if ($this->isValueChanged()) {
            // Flush the cache associated with the provided cache tags.
            $this->cacheManager->flush($this->getData('cache_tags'));
        }

        // Return the current object instance for further use.
        return $this;
    }
}
