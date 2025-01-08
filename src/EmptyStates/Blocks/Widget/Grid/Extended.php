<?php

declare(strict_types=1);

namespace Maginium\AdminEmptyStates\Blocks\Widget\Grid;

use Maginium\Framework\Support\Arr;
use Maginium\Framework\Support\Php;
use Maginium\Framework\Support\Str;

/**
 * Extended Grid Widget Extended.
 *
 * This class represents an extended grid widget extended.
 * It extends the MagentoColumnSet class.
 */
class Extended
{
    /**
     * Substrings to be replaced.
     *
     * @var array
     */
    protected $unwantedSubstrings = [
        'adminhtml',
        'block',
        'Extended',
        'list',
        'listing',
        'grid',
        'container',
        'system',
        'view',
        'edit',
        'tab',
        'admin',
    ];

    /**
     * Replacements to be made.
     *
     * @var array
     */
    protected $replacements = [
        'newslettrer' => 'newsletter',
        '.' => '-',
        '_' => '-',
        '--' => '-',
    ];

    /**
     * Get the model name from the layout name.
     *
     * This method processes the layout name by performing a series of replacements
     * to produce a cleaned-up model name suitable for further use.
     *
     * @param string $nameInLayout The original name in the layout
     *
     * @return string The processed model name
     */
    public function getEntityName(string $nameInLayout): string
    {
        // Replace specific substrings
        $modelName = Str::replace(Arr::keys($this->replacements), Arr::values($this->replacements), $nameInLayout);

        // Remove unwanted substrings
        $modelName = Str::replace($this->unwantedSubstrings, '', $modelName);

        // Replace multiple consecutive dashes with a single dash
        $modelName = Php::pregReplace('/-+/', '-', $modelName);

        // Trim leading and trailing dashes
        $modelName = Str::trim($modelName, '-');

        // Deduplicate parts to prevent repetitions
        $modelName = $this->deduplicateParts($modelName);

        return $modelName ?? '';
    }

    /**
     * Deduplicate consecutive repeated parts in the model name.
     *
     * @param string $modelName The model name with potential repetitions
     *
     * @return string The deduplicated model name
     */
    private function deduplicateParts(string $modelName): string
    {
        // Split the model name into parts
        $parts = Php::explode('-', $modelName);

        // Deduplicate parts
        $deduplicatedParts = [];
        $lastPart = null;

        foreach ($parts as $part) {
            if ($part !== $lastPart) {
                $deduplicatedParts[] = $part;
                $lastPart = $part;
            }
        }

        // Join the deduplicated parts with dashes
        return Php::implode('-', $deduplicatedParts);
    }
}
