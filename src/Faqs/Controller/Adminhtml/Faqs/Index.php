<?php

declare(strict_types=1);

namespace Maginium\AdminFaqs\Controller\Adminhtml\Faqs;

use Magento\Backend\Model\View\Result\Page;
use Magento\Framework\Controller\ResultFactory;
use Maginium\AdminFaqs\Controller\Adminhtml\Faqs;

/**
 * Class Index.
 */
class Index extends Faqs
{
    /**
     * @return Page
     */
    public function execute()
    {
        /** @var Page $resultPage */
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $resultPage->setActiveMenu('Maginium_AdminFaqs::faqs');
        $resultPage->addBreadcrumb(__('Faqs Page'), __('Faqs Page'));
        $resultPage->addBreadcrumb(__('Faqs'), __('Faqs'));
        $resultPage
            ->getConfig()
            ->getTitle()
            ->prepend(__('Faqs'));

        return $resultPage;
    }
}
