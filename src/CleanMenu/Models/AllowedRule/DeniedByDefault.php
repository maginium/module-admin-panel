<?php

declare(strict_types=1);

namespace Maginium\AdminCleanMenu\Models\AllowedRule;

use Maginium\AdminCleanMenu\Interfaces\IsAllowedInterface;
use Maginium\Framework\Support\Arr;
use Maginium\Framework\Support\Php;

/**
 * Rule that denies values by default unless they are in the allowed list.
 */
final class DeniedByDefault implements IsAllowedInterface
{
    /**
     * The rule code for the deniedByDefault rule.
     */
    public const RULE_CODE = 'deniedByDefault';

    /**
     * @var array List of values that are denied by default.
     */
    private $forbiddenList;

    /**
     * Constructor.
     *
     * @param string[] $defaultItems The default list of items.
     * @param string[] $items The list of items that are allowed.
     */
    public function __construct(array $defaultItems = [], array $items = [])
    {
        $this->forbiddenList = Arr::diff($defaultItems, $items);
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
