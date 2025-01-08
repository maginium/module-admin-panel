<?php

declare(strict_types=1);

namespace Maginium\AdminConfigIcon\Models;

use Maginium\AdminConfigIcon\Interfaces\Data\ConfigIconInterface;
use Maginium\Framework\Database\ObjectModel;

/**
 * ConfigIcon Model.
 *
 * A model class to manage admin configuration icons.
 * It allows for adding, retrieving, updating, and removing navigation configurations
 * within the admin panel. This class extends Magento's DataObject for easy data management.
 */
class ConfigIcon extends ObjectModel implements ConfigIconInterface
{
    /**
     * Constructor to initialize the ConfigIcon model.
     *
     * @param array $data Optional initial data to set for the object.
     */
    public function __construct(array $items = [])
    {
        // Initialize parent DataObject with optional data array
        parent::__construct($items);
    }

    /**
     * Retrieves all configuration items.
     *
     * Fetches the array of configuration items stored in the model.
     * If no items are set, returns an empty array.
     *
     * @return array An array of configuration items.
     */
    public function getItems(): array
    {
        // Default to an empty array if no items exist
        return $this->getData();
    }

    /**
     * Sets multiple configuration items.
     *
     * Stores an array of configuration items in the model.
     *
     * @param array $items An array of configuration items to store.
     *
     * @return $this The current instance for method chaining.
     */
    public function setItems(array $items): self
    {
        return $this->setData($items);
    }

    /**
     * Retrieves a specific configuration item by its ID.
     *
     * Searches the stored items for an entry matching the provided ID.
     * If found, the item is returned; otherwise, null is returned.
     *
     * @param string $id The unique identifier of the configuration item.
     *
     * @return array|null The configuration item or null if not found.
     */
    public function getItemById(string $id): ?array
    {
        return $this->getData($id);
    }

    /**
     * Adds a new configuration item to the existing list.
     *
     * Appends a new item to the list of configuration items.
     *
     * @param array $item The new configuration item to add.
     *
     * @return $this The current instance for method chaining.
     */
    public function addItem(array $item): self
    {
        return $this->addData($item);
    }

    /**
     * Removes a configuration item by its ID.
     *
     * Filters out an item from the list based on its ID.
     *
     * @param string $id The unique identifier of the configuration item to remove.
     *
     * @return $this The current instance for method chaining.
     */
    public function removeItemById(string $id): self
    {
        return $this->unsetData($id);
    }

    /**
     * Checks if a configuration item exists by its ID.
     *
     * Determines if an item with the provided ID is present in the configuration list.
     *
     * @param string $id The unique identifier of the configuration item to check.
     *
     * @return bool True if the item exists, false otherwise.
     */
    public function hasItem(string $id): bool
    {
        return $this->hasData($id);
    }
}
