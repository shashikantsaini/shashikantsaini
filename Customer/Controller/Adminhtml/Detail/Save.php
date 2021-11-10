<?php


namespace Bluethink\Customer\Controller\Adminhtml\Detail;

class Save extends \Magento\Backend\App\Action
{
    
    var $detailFactory;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Bluethink\Customer\Model\DetailFactory $detailFactory
    ) {
        parent::__construct($context);
        $this->detailFactory = $detailFactory;
    }

    /**
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        if (!$data) {
            $this->_redirect('bluethink_customer/detail/addrow');
            return;
        }
        try {
            $rowData = $this->detailFactory->create();
            $rowData->setData($data);
            //print_r($rowData->getData());
            //die();
            if (isset($data['cust_id'])) {
                $rowData->setCustId($data['cust_id']);
            }
            $rowData->save();
            $this->messageManager->addSuccess(__('Customer data has been successfully saved.'));
        } catch (\Exception $e) {
            $this->messageManager->addError(__($e->getMessage()));
        }
        $this->_redirect('bluethink_customer/detail/index');
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Bluethink_Customer::save');
    }
}