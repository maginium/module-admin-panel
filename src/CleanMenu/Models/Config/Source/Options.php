<?php

declare(strict_types=1);

namespace Maginium\AdminCleanMenu\Models\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;
use Maginium\AdminCleanMenu\Spi\ListInterface;
use Maginium\Foundation\Concerns\HasOptionSource;

/**
 * Provides options based on a list.
 */
final class Options implements OptionSourceInterface
{
    use HasOptionSource;

    /**
     * @var ListInterface
     */
    private $list;

    /**
     * @var array|null
     */
    private $optionArray;

    /**
     * Constructor.
     *
     * @param ListInterface $list
     */
    public function __construct(ListInterface $list)
    {
        $this->list = $list;
    }

    /**
     * Retrieve options in a "key-value" format.
     *
     * This method must be implemented by child classes to provide
     * specific key-value options for configuration.
     *
     * @return array An associative array of options in "key => value" format.
     */
    public function toArray(): array
    {
        return $this->list->getList();
    }
}
