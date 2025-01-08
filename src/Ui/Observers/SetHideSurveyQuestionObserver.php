<?php

declare(strict_types=1);

namespace Maginium\AdminUi\Observers;

use Magento\Backend\Model\Auth\Session;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

/**
 * Observer to set the 'hide survey question' flag in the admin session.
 *
 * This observer listens to a specified event and sets a custom session variable
 * to control the visibility of the survey question in the admin panel.
 */
class SetHideSurveyQuestionObserver implements ObserverInterface
{
    /**
     * @var Session
     */
    protected $_authSession;

    /**
     * Constructor to initialize session object.
     *
     * @param Session $authSession The Magento backend authentication session model.
     */
    public function __construct(Session $authSession)
    {
        $this->_authSession = $authSession;
    }

    /**
     * Set the 'hide survey question' flag in the session.
     *
     * This method is executed when the observer is triggered, setting a session
     * variable that controls whether the survey question should be hidden.
     *
     * @param Observer $observer The event observer.
     *
     * @return $this Returns the current instance for method chaining.
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter) Prevents warnings for unused parameter.
     */
    public function execute(Observer $observer)
    {
        // Set the 'hide survey question' flag in the session
        $this->_authSession->setHideSurveyQuestion(true);

        // Return the current instance to allow method chaining
        return $this;
    }
}
