<?php

declare(strict_types=1);

namespace Maginium\AdminEmptyStates\Blocks\Widget\Grid;

use Magento\Backend\Block\Widget\Grid\ColumnSet as BaseColumnSet;
use Maginium\Framework\Support\Arr;
use Maginium\Framework\Support\Php;
use Maginium\Framework\Support\Str;

/**
 * Extended Grid Widget Column Set.
 *
 * This class represents an extended grid widget column set.
 * It extends the MagentoColumnSet class.
 */
class ColumnSet extends BaseColumnSet
{
    /**
     * The template file for the column set.
     *
     * @var string
     */
    protected $_template = 'Maginium_AdminEmptyStates::widget/grid/column_set.phtml';

    /**
     * Substrings to be replaced.
     *
     * @var array
     */
    protected $unwantedSubstrings = [
        'adminhtml',
        'block',
        'columnSet',
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
     * @return string The processed model name.
     */
    public function getEntityName()
    {
        // Retrieve the name in the layout
        $nameInLayout = $this->getNameInLayout();

        // Replace specific substrings
        $modelName = Str::replace(Arr::keys($this->replacements), Arr::values($this->replacements), $nameInLayout);

        // Remove unwanted substrings
        $modelName = Str::replace($this->unwantedSubstrings, '', $modelName);

        // Replace multiple consecutive dashes with a single dash
        $modelName = Php::pregReplace('/-+/', '-', $modelName);

        // Trim leading and trailing dashes
        $modelName = trim($modelName, '-');

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
