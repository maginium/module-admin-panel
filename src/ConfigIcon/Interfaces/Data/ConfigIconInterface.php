<?php

declare(strict_types=1);

namespace Maginium\AdminConfigIcon\Interfaces\Data;

/**
 * ConfigIconInterface.
 *
 * Defines the contract for the ConfigIcon model, specifying the methods that
 * must be implemented for managing admin configuration icons.
 */
interface ConfigIconInterface
{
    /**
     * Key for configuration items data.
     */
    public const ITEMS = 'items';

    /**
     * Retrieves all configuration items.
     *
     * @return array An array of configuration items.
     */
    public function getItems(): array;

    /**
     * Sets the configuration items.
     *
     * @param array $items An array of configuration items.
     *
     * @return self
     */
    public function setItems(array $items): self;

    /**
     * Retrieves a specific configuration item by ID.
     *
     * @param string $id The ID of the item to retrieve.
     *
     * @return array|null The configuration item, or null if not found.
     */
    public function getItemById(string $id): ?array;

    /**
     * Adds a new configuration item.
     *
     * @param array $item The configuration item to add.
     *
     * @return self
     */
    public function addItem(array $item): self;

    /**
     * Removes a configuration item by ID.
     *
     * @param string $id The ID of the item to remove.
     *
     * @return self
     */
    public function removeItemById(string $id): self;

    /**
     * Checks if a configuration item exists by ID.
     *
     * @param string $id The ID to check.
     *
     * @return bool True if the item exists, false otherwise.
     */
    public function hasItem(string $id): bool;
}
