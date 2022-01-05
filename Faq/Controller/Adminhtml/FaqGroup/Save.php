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
     * Save constructor.
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
        
        try {
            $model = $this->faqGroupFactory->create();
            if ($id = (int) $this->getRequest()->getParam('faqgroup_id')) {                
                $model = $model->load($id);
                if ($id != $model->getId()) {
                    $this->messageManager->addErrorMessage(__('This FAQ Group no longer exists.'));
                    return $resultRedirect->setPath('*/*/');
                }
            }
            $postdata = $this->_filterFaqGroupData($postdata);
            $model->setData($postdata);
            

            if (isset($postdata['faqgroup_id'])) {
                $model->setFaqgroupId($postdata['faqgroup_id']);
            }
            
            $model->save();

            $this->messageManager->addSuccess(__('FAQ Group has been successfully saved.'));

            if ($this->getRequest()->getParam('back')) {
                $this->_redirect('*/*/edit',['faqgroup_id' => $model->getFaqgroupId()]);
                return;
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
        if (isset($data['icon'][0]['name'])) {
            $data['icon'] = $data['icon'][0]['name'];
        } else {
            $data['icon'] = null;
        }

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