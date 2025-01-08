<?php

declare(strict_types=1);

namespace Maginium\AdminCleanMenu\Models\Config\Structure;

use Magento\Config\Model\Config\Structure\Data as StructureData;
use Magento\Config\Model\Config\Structure\Reader;
use Magento\Framework\Config\CacheInterface;
use Magento\Framework\Config\ScopeInterface;
use Magento\Framework\Serialize\SerializerInterface;
use Maginium\AdminCleanMenu\Interfaces\IsAllowedInterface;
use Maginium\Framework\Support\Arr;

/**
 * Custom configuration structure data model.
 */
class Data extends StructureData
{
    /**
     * @var IsAllowedInterface
     */
    private $isAllowed;

    /**
     * Constructor.
     *
     * @param Reader $reader
     * @param ScopeInterface $configScope
     * @param CacheInterface $cache
     * @param string $cacheId
     * @param SerializerInterface $serializer
     * @param IsAllowedInterface $isAllowed
     */
    public function __construct(
        Reader $reader,
        ScopeInterface $configScope,
        CacheInterface $cache,
        string $cacheId,
        SerializerInterface $serializer,
        IsAllowedInterface $isAllowed,
    ) {
        // Initialize the parent constructor
        parent::__construct(
            $reader,
            $configScope,
            $cache,
            $cacheId,
            $serializer,
        );

        // Set the IsAllowedInterface instance
        $this->isAllowed = $isAllowed;
    }

    /**
     * Get the configuration data.
     *
     * This method overrides the parent method to filter out sections
     * that are not allowed based on the IsAllowedInterface.
     *
     * @param string|null $path
     * @param mixed $default
     *
     * @return mixed
     */
    public function get($path = null, $default = null)
    {
        // Get the configuration data from the parent method
        $data = parent::get($path, $default);

        // Check if tabs and sections are present in the data
        if (isset($data['tabs'], $data['sections'])) {
            // Initialize an array to store third-party tabs
            $thirdPartyTabs = [];

            // Loop through each section
            foreach ($data['sections'] as $sectionId => $section) {
                // Get the tab associated with the section
                $sectionTab = $section['tab'] ?? '';

                // Check if the section tab is not allowed
                if ($sectionTab && ! $this->isAllowed->isAllowed($sectionTab)) {
                    // Store the original tab if it exists
                    if (isset($data['tabs'][$sectionTab])) {
                        $section['tab_original'] = $data['tabs'][$sectionTab];
                    }

                    // Set the section tab to 'extensions_list'
                    $section['tab'] = 'extensions_list';

                    // Add the section to the third-party tabs array
                    $thirdPartyTabs[$sectionTab][$sectionId] = $section;

                    // Remove the section from the data
                    unset($data['sections'][$sectionId]);
                }
            }

            // Sort the third-party tabs array by key
            ksort($thirdPartyTabs);

            // Merge the sections back into the data
            $data['sections'] = Arr::merge(
                $data['sections'],
                Arr::merge(
                    ...Arr::values($this->sortByLabel($thirdPartyTabs)),
                ),
            );
        }

        // Return the filtered configuration data
        return $data;
    }

    /**
     * Sort the array by label.
     *
     * This method is used to sort the sections array by label.
     *
     * @param array $array
     *
     * @return array
     */
    private function sortByLabel(array $array): array
    {
        // Sort each sub-array by label
        return Arr::map($array, static function(array $sections): array {
            // Sort the sections array by label
            uasort(
                $sections,
                static fn(array $a, array $b): int => ($a['label'] ?? '') <=>
                    ($b['label'] ?? ''),
            );

            // Return the sorted sections array
            return $sections;
        });
    }
}
