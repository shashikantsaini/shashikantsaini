<?php

namespace Bluethink\Faq\Controller\Adminhtml\FaqUser;

use Magento\Backend\App\Action\Context;
use Bluethink\Faq\Model\FaqUserFactory;

class Delete extends \Magento\Backend\App\Action
{
    /**
     * @var FaqUserFactory
     */
    var $faqUserFactory;

    /**
     * Delete constructor.
     *
     * @param Context    $context
     * @param FaqUserFactory $faqUserFactory
     */
    public function __construct(
        Context $context,
        FaqUserFactory $faqUserFactory
    ) {
        parent::__construct($context);
        $this->faqUserFactory = $faqUserFactory;
    }

    public function execute()
    {
        $faqUserId = $this->getRequest()->getParam('user_faq_id');
        
        if (!$faqUserId) {
            $this->messageManager->addError(__('FAQ does not exist'));
            $this->_redirect('*/*/index');
            return;
        }

        try {
            $faqUser = $this->faqUserFactory->create();
            $faqUser->load($faqUserId);
            $faqUser->delete();
            $this->messageManager->addSuccess(__('FAQ has been successfully deleted with ID : %1.', $faqUserId));
            $this->_redirect('*/*/index');
            return;
        } catch (\Exception $e) {
            $this->messageManager->addError($e->getMessage());
            $this->_redirect('*/*/edit',['user_faq_id' => $faqUserId]);
            return;
        }         
    }    
}

