<?php

namespace Bluethink\Faq\Controller\Adminhtml\Faq;

use Magento\Backend\App\Action\Context;
use Bluethink\Faq\Model\FaqFactory;
use Bluethink\Faq\Api\FaqRepositoryInterface;

class Save extends \Magento\Backend\App\Action
{
    /**
     * @var FaqFactory
     */ 
    var $faqFactory;

    /**
     * @var FaqRepositoryInterface
     */ 
    var $faqRepository;

    /**
     * Save constructor.
     *
     * @param Context $context
     * @param FaqFactory $faqFactory
     * @param FaqRepositoryInterface $faqRepository
     */
    public function __construct(
        Context $context,
        FaqFactory $faqFactory,
        FaqRepositoryInterface $faqRepository
    ) {
        parent::__construct($context);
        $this->faqFactory = $faqFactory;
        $this->faqRepository = $faqRepository;
    }

    public function execute()
    {
        $postdata = $this->getRequest()->getPostValue();
        if (!$postdata) {
            $this->_redirect('*/*/index');
            return;
        }
        
        try {
            $model = $this->faqFactory->create();
            if ($id = (int) $this->getRequest()->getParam('faq_id')) {                
                $model = $model->load($id);
                if ($id != $model->getId()) {
                    $this->messageManager->addErrorMessage(__('This FAQ no longer exists.'));
                    return $resultRedirect->setPath('*/*/');
                }
            }
            $postdata = $this->_filterFaqGroupData($postdata);
            $model->setData($postdata);
            
            if (isset($postdata['faq_id'])) {
                $model->setFaqId($postdata['faq_id']);
            }

            $model->save();
            $this->messageManager->addSuccess(__('FAQ has been successfully saved.'));

            if ($this->getRequest()->getParam('back')) {
                $this->_redirect('*/*/edit',['faq_id' => $model->getFaqId()]);
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