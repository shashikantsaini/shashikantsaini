<?php

namespace Bluethink\Faq\Controller\Adminhtml\Faq;

use Magento\Backend\App\Action\Context;
use Bluethink\Faq\Model\FaqFactory;

class Delete extends \Magento\Backend\App\Action
{
    /**
     * @var FaqFactory
     */
    var $faqFactory;

    /**
     * Delete constructor.
     *
     * @param Context    $context
     * @param FaqFactory $faqFactory
     */
    public function __construct(
        Context $context,
        FaqFactory $faqFactory
    ) {
        parent::__construct($context);
        $this->faqFactory = $faqFactory;
    }

    public function execute()
    {
        $faqId = $this->getRequest()->getParam('faq_id');
        
        if (!$faqId) {
            $this->messageManager->addError(__('FAQ does not exist'));
            $this->_redirect('*/*/index');
            return;
        }

        try {
            $faq = $this->faqFactory->create();
            $faq->load($faqId);
            $faq->delete();
            $this->messageManager->addSuccess(__('FAQ has been successfully deleted with ID : %1.', $faqId));
            $this->_redirect('*/*/index');
            return;
        } catch (\Exception $e) {
            $this->messageManager->addError($e->getMessage());
            $this->_redirect('*/*/edit',['faq_id' => $faqId]);
            return;
        }         
    }    
}

