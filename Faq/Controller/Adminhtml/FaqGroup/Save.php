<?php

namespace Bluethink\Faq\Controller\Adminhtml\FaqGroup;

use Magento\Backend\App\Action\Context;
use Bluethink\Faq\Model\FaqGroupFactory;

class Save extends \Magento\Backend\App\Action
{
    /**
     * @var FaqGroupFactory
     */
    var $faqGroupFactory;

    /**
     * Index constructor.
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
        $postdata = $this->getRequest()->getPostValue();

        if (!$postdata) {
            $this->_redirect('adminfaq/faqgroup/index');
            return;
        }

        $storeViews = implode(",",$postdata['storeview']);
        $customerGroups = implode(",",$postdata['customer_group']);
        $result = [
            'groupname'=>$postdata['groupname'],
            'storeview'=>$storeViews,
            'customer_group'=>$customerGroups,
            'sortorder'=>$postdata['sortorder'],
            'status'=>$postdata['status'],
        ];
        
        try {
            $faqGroupData = $this->faqGroupFactory->create();
            $faqGroupData->setData($result);

            if (isset($postdata['faqgroup_id'])) {
                $faqGroupData->setFaqgroupId($postdata['faqgroup_id']);
            }
            
            $faqGroupData->save();
            $this->messageManager->addSuccess(__('FAQ Group has been successfully saved.'));

            if ($this->getRequest()->getParam('back')) {
                $this->_redirect('*/*/edit',['faqgroup_id' => $faqGroupData->getFaqgroupId()]);
                return;
            }

        } catch (\Exception $e) {
            $this->messageManager->addError(__($e->getMessage()));
        }
        $this->_redirect('*/*/index');
    }
}