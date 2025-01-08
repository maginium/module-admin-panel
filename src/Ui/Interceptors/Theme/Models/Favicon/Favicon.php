<?php

declare(strict_types=1);

namespace Maginium\AdminUi\Interceptors\Theme\Models\Favicon;

use Magento\Theme\Model\Favicon\Favicon as DefaultFavicon;

/**
 * Plugin to override the default favicon with a custom one.
 * This class modifies the behavior of the getDefaultFavicon method.
 */
class Favicon
{
    /**
     * After plugin to return the custom favicon URL.
     *
     * This method overrides the default favicon URL with a custom one,
     * typically used for brand-specific favicons in the admin panel.
     *
     * @param DefaultFavicon $subject The subject (instance) of the Favicon model.
     *
     * @return string The path to the custom favicon.
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter) Prevents warning for unused parameter $subject.
     */
    public function afterGetDefaultFavicon(DefaultFavicon $subject): string
    {
        // Return the custom favicon path
        return 'Maginium_AdminUi::favicon.ico';
    }
}
