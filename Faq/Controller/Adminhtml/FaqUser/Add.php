<?php

namespace Bluethink\Faq\Controller\Adminhtml\FaqUser;

use Magento\Backend\App\Action\Context;
use Bluethink\Faq\Model\FaqUserFactory;
use Bluethink\Faq\Model\FaqFactory;

class Add extends \Magento\Backend\App\Action
{
    /**
     * @var FaqUserFactory
     */
    var $faqUserFactory;

    /**
     * @var FaqFactory
     */
    var $FaqFactory;

    /**
     * Save constructor.
     *
     * @param Context $context
     * @param FaqUserFactory $faqUserFactory
     * @param FaqFactory $faqFactory
     */
    public function __construct(
        Context $context,
        FaqUserFactory $faqUserFactory,
        FaqFactory $faqFactory
    ) {
        parent::__construct($context);
        $this->faqUserFactory = $faqUserFactory;
        $this->faqFactory = $faqFactory;
    }

    public function execute()
    {
        echo "<pre>";
        $postdata = $this->getRequest()->getPostValue();
        // print_r($postdata);
        // die('Shasi');
        

        if (!$postdata) {
            $this->_redirect('adminfaq/faqgroup/index');
            return;
        }       
        
        
        $modelFaqUser = $this->faqUserFactory->create();
        $modelFaqUser = $modelFaqUser->load([$postdata['user_faq_id']]);
        try {
            if($postdata['checkuserfaq'])
            {
                $modelFaq = $this->faqFactory->create();
                $postdata = $this->_filterFaqGroupData($postdata);
                $modelFaq->setData($postdata);
                $modelFaqUser->setContent($postdata['content'])
                             ->setAuthorizeStatus(1)
                             ->setDeclineStatus(0);
    
                if (isset($postdata['user_faq_id'])) {
                    $modelFaqUser->setUserFaqId($postdata['user_faq_id']);
                }
                
                $modelFaq->save();
                $modelFaqUser->save();
    
                $this->messageManager->addSuccess(__('FAQ has been successfully saved.'));
            }
            else
            {
                $modelFaqUser->setContent($postdata['content'])
                             ->setAuthorizeStatus(0)
                             ->setDeclineStatus(1);
                $modelFaqUser->save();
                $this->messageManager->addSuccess(__('User Faq has Been Updated as You Declined'));
            }

        } catch (\Exception $e) {
            $this->messageManager->addError(__($e->getMessage()));
        }
        $this->_redirect('*/*/index');
    }

    /**
     * Filter faq group data
     *
     * @param array $rawData
     * @return array
     */
    protected function _filterFaqGroupData(array $rawData)
    {
        $data = $rawData;
        $cGroup = $data['customer_group'];
        if (isset($cGroup)) {
            $customerGroup = implode(',', $data['customer_group']);
            $data['customer_group'] = $customerGroup;
        }

        $stores = $data['storeview'];
        if (isset($stores)) {
            $store = implode(',', $data['storeview']);
            $data['storeview'] = $store;
        }

        return $data;
    }
}