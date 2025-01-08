<?php

declare(strict_types=1);

namespace Maginium\AdminCleanMenu\Models;

use Maginium\AdminCleanMenu\Interfaces\IsAllowedInterface;
use Maginium\Framework\Support\Facades\Container;

/**
 * Class RuleFactory.
 *
 * Factory class for creating rule instances.
 */
final class RuleFactory
{
    /**
     * List of rule class names.
     *
     * @var array
     */
    private $rules;

    /**
     * RuleFactory constructor.
     *
     * @param array $rules
     */
    public function __construct(array $rules = [])
    {
        $this->rules = $rules;
    }

    /**
     * Create an instance of the rule with the specified ID.
     *
     * @param string $ruleId
     * @param array $arguments
     *
     * @return IsAllowedInterface
     */
    public function create(string $ruleId, array $arguments): IsAllowedInterface
    {
        return Container::make($this->rules[$ruleId], $arguments);
    }
}
