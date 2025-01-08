<?php

declare(strict_types=1);

namespace Maginium\AdminCleanMenu\Models\AllowedRule;

use Maginium\AdminCleanMenu\Interfaces\IsAllowedInterface;
use Maginium\Framework\Support\Php;

/**
 * Rule that allows values by default unless they are in the forbidden list.
 */
final class AllowedByDefault implements IsAllowedInterface
{
    /**
     * The rule code for the allowedByDefault rule.
     */
    public const RULE_CODE = 'allowedByDefault';

    /**
     * @var array List of forbidden values.
     */
    private $forbiddenList;

    /**
     * Constructor.
     *
     * @param string[] $items List of forbidden values.
     */
    public function __construct(array $items)
    {
        $this->forbiddenList = $items;
    }

    /**
     * Checks if a value is allowed.
     *
     * @param string $value The value to check.
     *
     * @return bool Returns true if the value is allowed, false otherwise.
     */
    public function isAllowed(string $value): bool
    {
        return ! Php::inArray($value, $this->forbiddenList, true);
    }
}
