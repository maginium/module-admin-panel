<?php

declare(strict_types=1);

namespace Maginium\AdminKeyboardShortcuts\Models;

use Maginium\AdminKeyboardShortcuts\Interfaces\Data\HotKeyShortcutInterface;
use Maginium\Framework\Database\CollectionModel;

/**
 * HotKeyShortcut Model.
 *
 * A model class to manage admin hot key shortcuts.
 * It allows for adding, retrieving, updating, and removing navigation hot key shortcuts
 * within the admin panel. This class extends Magento's DataObject for easy data management.
 */
class HotKeyShortcut extends CollectionModel implements HotKeyShortcutInterface
{
    /**
     * Constructor to initialize the HotKeyShortcut model.
     *
     * @param array $data Optional initial data to set for the object.
     */
    public function __construct(array $shortcuts = [])
    {
        // Initialize parent DataObject with optional data array
        parent::__construct($shortcuts);
    }
}
