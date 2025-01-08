<?php

declare(strict_types=1);

namespace Maginium\AdminInfoBox\Blocks;

use Magento\Framework\View\Element\Template;
use Maginium\Framework\Support\Facades\Request;
use Maginium\Framework\Support\Php;
use Maginium\Framework\Support\Str;
use Maginium\Framework\Support\Validator;

/**
 * Class Title.
 *
 * This class is responsible for generating and processing the title of an model
 * in the admin panel. It uses the full action name from the request to derive
 * a meaningful and user-friendly model name to be used as the title.
 */
class Title extends Template
{
    /**
     * A list of replacements and removals to apply to the full action name.
     * This array contains mappings where the key is a term to remove or replace,
     * and the value is the replacement string.
     *
     * Example:
     * 'mst' => '' will remove 'mst' from the action name.
     * 'customer' => 'Customer' will replace 'customer' with 'Customer'.
     *
     * @var array<string, string>
     */
    private $replacementsAndRemovables = [
        'mst' => '',
        'view' => '',
        'edit' => '',
        'save' => '',
        'index' => '',
        'delete' => '',
        'create' => '',
        'update' => '',
        'pending' => '',
        'adminhtml' => '',
        'customer' => 'Customer',
        'seoaudit' => 'seo audit',
        'seoautolink' => 'seo auto',
        're_product' => 'product review',
        're_customer' => 'product review',
        'reportBuilder' => 'report Builder',
        'Currencysymbol' => 'Currency symbols',
        'customersegment' => 'Customer Segment',
        'sales_rule_promo_quote' => 'Sales Rule',
        'loginascustomer' => 'Login as customer',
        'catalog_rule_promo_catalog' => 'Catalog Rule',
        'dashboard_dashboard' => 'dashboard & analytics',
        'seo_canonicalRewrite' => 'Seo Canonical rewrites',
    ];

    /**
     * Title constructor.
     *
     * Initializes the block with the given context and data.
     *
     * @param Template\Context $context The context for the template.
     * @param array $data The additional data passed to the block.
     */
    public function __construct(
        Template\Context $context,
        array $data = [],
    ) {
        parent::__construct($context, $data);
    }

    /**
     * Get the current full action name from the request.
     *
     * Retrieves the full action name from the current request.
     *
     * @return string|null The full action name or null if not available.
     */
    public function getFullActionName()
    {
        return Request::getFullActionName();
    }

    /**
     * Get the model name derived from the full action name.
     *
     * Processes the full action name by applying custom replacements,
     * splitting it into words, and returning a user-friendly model name
     * by converting it into a plural form.
     *
     * @return string The processed model name.
     */
    public function getEntityName()
    {
        // Get the full action name from the request
        $fullActionName = $this->getFullActionName();

        // Apply custom replacements and remove unwanted segments
        $fullActionName = $this->applyReplacementsAndRemovables($fullActionName);

        // Split the action name into words by non-alphanumeric characters
        $words = preg_split('/[^a-zA-Z0-9]/', $fullActionName, -1, PREG_SPLIT_NO_EMPTY);

        // Get unique words and format them
        $uniqueWords = $this->getUniqueWords($words);

        // Combine the unique words back into a string and return the pluralized version
        return Str::plural(Php::implode(' ', $uniqueWords));
    }

    /**
     * Apply custom replacements and removals to the full action name.
     *
     * This method replaces or removes specific substrings in the action name
     * to standardize or simplify the string before processing it further.
     *
     * @param string $fullActionName The full action name.
     *
     * @return string The modified full action name.
     */
    private function applyReplacementsAndRemovables($fullActionName)
    {
        // Apply each replacement/removal to the full action name
        foreach ($this->replacementsAndRemovables as $search => $replace) {
            // Use Str::replace for case-insensitive replacement
            $fullActionName = Str::replace(Str::lower($search), Str::lower($replace), $fullActionName);
        }

        return $fullActionName;
    }

    /**
     * Get unique words from an array of words.
     *
     * This method processes an array of words, converts each word to its singular form,
     * capitalizes the first letter, and ensures uniqueness by adding only distinct words.
     *
     * @param array $words The array of words to process.
     *
     * @return array The array of unique words, each formatted correctly.
     */
    private function getUniqueWords($words)
    {
        $uniqueWords = [];

        // Iterate over each word in the array
        foreach ($words as $word) {
            // Convert the word to singular form, and capitalize the first letter
            $singularWord = Str::singular($word);
            $singularWord = Str::ucfirst($singularWord);

            // Add the word to the uniqueWords array if it is not already present
            if (! Validator::inArray($singularWord, $uniqueWords)) {
                $uniqueWords[] = $singularWord;
            }
        }

        return $uniqueWords;
    }
}
