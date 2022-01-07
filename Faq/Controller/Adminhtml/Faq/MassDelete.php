<?php

namespace Bluethink\Faq\Controller\Adminhtml\Faq;

use Magento\Framework\Controller\ResultFactory;
use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use Bluethink\Faq\Model\ResourceModel\Faq\CollectionFactory;

class MassDelete extends \Magento\Backend\App\Action
{
    /**
     * @var Filter
     */ 
    protected $_filter;

    /**
     * @var CollectionFactory
     */ 
    protected $_collectionFactory;

    /**
     * MassDelete constructor.
     *
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param CollectionFactory $collectionFactory
     */    
    public function __construct(
        Context $context,
        Filter $filter,
        CollectionFactory $collectionFactory
    ) {

        $this->_filter = $filter;
        $this->_collectionFactory = $collectionFactory;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        $collection = $this->_filter->getCollection($this->_collectionFactory->create());   
        $recordDeleted = 0;
        foreach ($collection as $record) {
            if($record->delete()){
               $recordDeleted++; 
           }            
        }
        $this->messageManager->addSuccess(__('A total of %1 record(s) have been deleted.', $recordDeleted));

        return $this->resultFactory->create(ResultFactory::TYPE_REDIRECT)->setPath('*/*/index');
    }
}