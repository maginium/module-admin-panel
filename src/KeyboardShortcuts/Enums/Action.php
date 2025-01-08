<?php

declare(strict_types=1);

namespace Maginium\AdminKeyboardShortcuts\Enums;

use Maginium\Framework\Enum\Attributes\Description;
use Maginium\Framework\Enum\Attributes\Label;
use Maginium\Framework\Enum\Enum;

/**
 * Enum representing common actions.
 *
 * @method static self NAVIGATE() Action to navigate to a specific page.
 * @method static self SAVE() Action to save the current page.
 * @method static self DELETE() Action to delete the selected item.
 */
class Action extends Enum
{
    /**
     * Action to navigate to a specific page.
     */
    #[Label('Navigate')]
    #[Description('Action to navigate to a specific page.')]
    public const NAVIGATE = 'NAVIGATE';

    /**
     * Action to save the current page.
     */
    #[Label('Save')]
    #[Description('Action to save the current page.')]
    public const SAVE = 'SAVE';

    /**
     * Action to delete the selected item.
     */
    #[Label('Delete')]
    #[Description('Action to delete the selected item.')]
    public const DELETE = 'DELETE';
}
