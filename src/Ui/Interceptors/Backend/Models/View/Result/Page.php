<?php

declare(strict_types=1);

namespace Maginium\AdminUi\Interceptors\Backend\Models\View\Result;

use Magento\Backend\Model\View\Result\Page\Interceptor;
use Magento\Framework\App\ResponseInterface;

/**
 * Class Page.
 *
 * This plugin modifies the Magento backend page result by injecting custom CSS body classes
 * to enhance or customize the page's styling for specific functionalities, such as a React-based
 * panel or Maginium-specific features.
 */
class Page
{
    /**
     * CSS class for identifying React-based panels in the backend.
     *
     * This class is added to the page's `<body>` element to enable React-based
     * components or custom styling for React panels.
     */
    public const BODY_CLASS_REACT_PANEL = 'react-panel';

    /**
     * CSS class for identifying Maginium-specific pages or functionalities.
     *
     * This class is added to the page's `<body>` element to customize styles
     * and behavior for Maginium-related modules.
     */
    public const BODY_CLASS_PIXICOMMERCE = '__maginium';

    /**
     * Before Render Result.
     *
     * This method intercepts the `renderResult` method of the Page class in Magento's
     * backend, allowing the addition of custom CSS body classes to the page.
     *
     * @param Interceptor $interceptor The page interceptor instance, which represents
     *                                 the result of a page rendering in Magento.
     * @param ResponseInterface $response The HTTP response object, which may contain headers
     *                                    and other response data for the current request.
     *
     * @return array An array containing the modified response object.
     */
    public function beforeRenderResult(
        Interceptor $interceptor,
        ResponseInterface $response,
    ): array {
        // Add custom body classes to the page
        $this->addCustomBodyClasses($interceptor);

        // Return the original response object to continue the rendering process
        return [$response];
    }

    /**
     * Add Custom Body Classes.
     *
     * This private method encapsulates the logic for adding custom CSS body classes
     * to the backend page. It ensures that only valid methods are called on the configuration object.
     *
     * @param Interceptor $interceptor The page interceptor instance, used to access
     *                                 the page's configuration for customization.
     *
     * @return void
     */
    private function addCustomBodyClasses(Interceptor $interceptor): void
    {
        // Retrieve the page configuration object from the interceptor
        $config = $interceptor->getConfig();

        // Check if the 'addBodyClass' method exists to prevent errors in case of API changes
        if (method_exists($config, 'addBodyClass')) {
            // Add the React panel body class to enable React-specific styling
            $config->addBodyClass(self::BODY_CLASS_REACT_PANEL);

            // Add the Maginium body class for Maginium-specific styling
            $config->addBodyClass(self::BODY_CLASS_PIXICOMMERCE);
        }
    }
}
