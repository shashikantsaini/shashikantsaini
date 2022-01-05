<?php

namespace Bluethink\Faq\Controller\Adminhtml\Faq;

use Magento\Backend\App\Action\Context;
use Bluethink\Faq\Model\FaqFactory;

class Save extends \Magento\Backend\App\Action
{
    /**
     * @var FaqFactory
     */ 
    var $faqFactory;

    /**
     * Index constructor.
     *
     * @param Context $context
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
        $postdata = $this->getRequest()->getPostValue();
        // $x = $this->getRequest()->getParam('back');
        // echo "<pre>";
        // print_r($x);
        // die;
        if (!$postdata) {
            $this->_redirect('adminfaq/faq/index');
            return;
        }

        $groups = implode(",",$postdata['group']);
        $storeViews = implode(",",$postdata['storeview']);
        $customerGroups = implode(",",$postdata['customer_group']);

        $result = [
            'title'=>$postdata['title'],
            'content'=>$postdata['content'],
            'group'=>$groups,
            'storeview'=>$storeViews,
            'customer_group'=>$customerGroups,
            'sortorder'=>$postdata['sortorder'],
            'status'=>$postdata['status'],
        ];
        
        try {
            $faqData = $this->faqFactory->create();
            $faqData->setData($result);

            if (isset($postdata['faq_id'])) {
                $faqData->setFaqId($postdata['faq_id']);
            }

            $faqData->save();
            $this->messageManager->addSuccess(__('FAQ has been successfully saved.'));

            if ($this->getRequest()->getParam('back')) {
                $this->_redirect('*/*/edit',['faq_id' => $faqData->getFaqId()]);
                return;
            }
            
        } catch (\Exception $e) {
            $this->messageManager->addError(__($e->getMessage()));
        }
        $this->_redirect('*/*/index');
    }
}