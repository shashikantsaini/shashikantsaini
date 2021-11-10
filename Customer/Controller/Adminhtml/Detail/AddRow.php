<?php
namespace Bluethink\Customer\Controller\Adminhtml\Detail;

use Magento\Framework\Controller\ResultFactory;

class AddRow extends \Magento\Backend\App\Action
{
    
    private $coreRegistry;

    
    private $detailFactory;

    
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Bluethink\Customer\Model\DetailFactory $detailFactory
    ) {
        parent::__construct($context);
        $this->coreRegistry = $coreRegistry;
        $this->detailFactory = $detailFactory;
    }

    /**
     * Mapped Grid List page.
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        $rowId = (int) $this->getRequest()->getParam('id');
        $rowData = $this->detailFactory->create();
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        if ($rowId) {
           $rowData = $rowData->load($rowId);
           $rowTitle = $rowData->getTitle();
           if (!$rowData->getCustId()) {
               $this->messageManager->addError(__('customer data no longer exist.'));
               $this->_redirect('bluethink_customer/detail/rowdata');
               return;
           }
       }

       $this->coreRegistry->register('row_data', $rowData);
       $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
       $title = $rowId ? __('Edit Customer Data ').$rowTitle : __('Add Customer Data');
       $resultPage->getConfig()->getTitle()->prepend($title);
       return $resultPage;
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('bluethink_customer::add_row');
    }
}