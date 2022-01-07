<?php

namespace Bluethink\Faq\Controller\Adminhtml\FaqGroup;

use Magento\Backend\App\Action\Context;
use Bluethink\Faq\Model\FaqGroupFactory;

class Delete extends \Magento\Backend\App\Action
{
    /**
     * @var FaqGroupFactory
     */
    var $faqGroupFactory;

    /**
     * Delete constructor.
     *
     * @param Context $context
     * @param FaqGroupFactory $faqGroupFactory
     */
    public function __construct(
        Context $context,
        FaqGroupFactory $faqGroupFactory
    ) {
        parent::__construct($context);
        $this->faqGroupFactory = $faqGroupFactory;
    }

    public function execute()
    {
        $faqGroupId = $this->getRequest()->getParam('faqgroup_id');

        if (!$faqGroupId) {
            $this->messageManager->addError(__('FAQ Group does not exist'));
            $this->_redirect('*/*/index');
            return;
        }

        try {
            $faqGroup = $this->faqGroupFactory->create();
            $faqGroup->load($faqGroupId);
            $faqGroup->delete();
            $this->messageManager->addSuccess(__('FAQ Group has been successfully deleted with ID : %1.', $faqGroupId));
            $this->_redirect('*/*/index');
            return;
        } catch (\Exception $e) {
            $this->messageManager->addError($e->getMessage());
            $this->_redirect('*/*/edit',['faqgroup_id' => $faqGroupId]);
            return;
        }         
    }    
}

