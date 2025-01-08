<?php

declare(strict_types=1);

namespace Maginium\AdminCleanMenu\Models;

use Maginium\AdminCleanMenu\Interfaces\IsAllowedInterface;
use Maginium\AdminCleanMenu\Spi\RuleConfigInterface;

/**
 * Class IsAllowedStrategy.
 *
 * This class implements a strategy pattern for determining if an item is allowed based on a rule configuration.
 */
final class IsAllowedStrategy implements IsAllowedInterface
{
    /**
     * @var IsAllowedInterface|null
     */
    private $isAllowed;

    /**
     * @var RuleFactory
     */
    private $ruleFactory;

    /**
     * @var RuleConfigInterface
     */
    private $config;

    /**
     * IsAllowedStrategy constructor.
     *
     * @param RuleFactory $ruleFactory
     * @param RuleConfigInterface $config
     */
    public function __construct(
        RuleFactory $ruleFactory,
        RuleConfigInterface $config,
    ) {
        $this->config = $config;
        $this->ruleFactory = $ruleFactory;
    }

    /**
     * Check if an item is allowed based on the rule configuration.
     *
     * @param string $name Name of the item to check.
     *
     * @return bool True if the item is allowed, false otherwise.
     */
    public function isAllowed(string $name): bool
    {
        // Lazy initialization of the rule instance
        if (! $this->isAllowed) {
            $this->isAllowed = $this->ruleFactory->create(
                $this->config->getRuleId(),
                [
                    'items' => $this->config->getItems(),
                    'defaultItems' => $this->config->getDefaultItems(),
                ],
            );
        }

        // Delegate the check to the rule instance
        return $this->isAllowed->isAllowed($name);
    }
}
