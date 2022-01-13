<?php

namespace Bluethink\Faq\Controller\Adminhtml\FaqUser;

use Magento\Backend\App\Action\Context;
use Bluethink\Faq\Model\FaqUserFactory;
use Bluethink\Faq\Model\FaqFactory;

class Save extends \Magento\Backend\App\Action
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
        $postdata = $this->getRequest()->getPostValue();        
        $authorizeStatus = $this->getRequest()->getParam('checkuserfaq');
              
        if (!$postdata) {
            $this->_redirect('*/*/index');
            return;
        }      
        
        $modelFaqUser = $this->faqUserFactory->create();
        $modelFaqUser = $modelFaqUser->load([$postdata['user_faq_id']]);
        try {
            if($postdata['checkuserfaq'])
            {
                $postdata = $this->_filterFaqGroupData($postdata);
                $modelFaqUser->setData($postdata)
                             ->setAuthorizeStatus($authorizeStatus)
                             ->setDeclineStatus(0)
                             ->setAddedStatus(0);
    
                if (isset($postdata['user_faq_id'])) {
                    $modelFaqUser->setUserFaqId($postdata['user_faq_id']);
                }
                
                $modelFaqUser->save();
    
                $this->messageManager->addSuccess(__('User FAQ has been Authorized.'));
            }
            else
            {
                $modelFaqUser->setData($postdata)
                             ->setAuthorizeStatus(0)
                             ->setDeclineStatus(1)
                             ->setAddedStatus(0);
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