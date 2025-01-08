<?php

declare(strict_types=1);

namespace Maginium\AdminCleanMenu\Models\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;
use Maginium\Foundation\Concerns\HasOptionSource;

/**
 * Option source for menu rule selection.
 */
final class Rules implements OptionSourceInterface
{
    use HasOptionSource;

    /**
     * @var array
     */
    private $options;

    /**
     * Constructor.
     *
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        $this->options = $options;
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
        return $this->options;
    }
}
