<?php

declare(strict_types=1);

namespace Maginium\AdminFaqs\Controller\Adminhtml;

use Magento\Backend\App\Action;

/**
 * Class Tabs.
 */
abstract class Faqs extends Action
{
    /**
     * Authorization level of a basic admin session.
     *
     * @see _isAllowed()
     */
    public const ADMIN_RESOURCE = 'Maginium_AdminFaqs::page';
}
