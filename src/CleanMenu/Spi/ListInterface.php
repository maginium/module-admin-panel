<?php

declare(strict_types=1);

namespace Maginium\AdminCleanMenu\Spi;

/**
 * Interface ListInterface.
 *
 * This interface defines a method to get a list of items.
 */
interface ListInterface
{
    /**
     * Get the list of items.
     *
     * @return array The list of items.
     */
    public function getList(): array;
}
