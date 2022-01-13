<?php

namespace Bluethink\Faq\Controller\Adminhtml\FaqUser;

use Magento\Framework\Controller\ResultFactory;
use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use Bluethink\Faq\Model\ResourceModel\FaqUser\CollectionFactory;
use Bluethink\Faq\Model\FaqFactory;

class MassAdd extends \Magento\Backend\App\Action
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
     * @var FaqFactory
     */
    private $faqFactory;

    /**
     * MassDelete constructor.
     *
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param CollectionFactory $collectionFactory
     * @param FaqFactory $faqFactory
     */    
    public function __construct(
        Context $context,
        Filter $filter,
        CollectionFactory $collectionFactory,
        FaqFactory $faqFactory
    ) {

        $this->_filter = $filter;
        $this->faqFactory = $faqFactory;
        $this->_collectionFactory = $collectionFactory;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        $collection = $this->_filter->getCollection($this->_collectionFactory->create());
        $collection->addFieldToFilter('added_status', ['eq' => 0])
                   ->addFieldToFilter('authorize_status', ['eq' => 1]);
        $size = $collection->getSize();   
        $recordAdded = 0;
        foreach ($collection as $record) 
        {
            $faq = $this->faqFactory->create();
            $faq->setData($collection->getData());

            if($faq->save())
            {
                $collection->setAddedStatus(1);
                $collection->save();
                $recordAdded++;
            }
        }
        $this->messageManager->addSuccess(__('A total of %1 record(s) have been Added out of %2.', $recordAdded , $size));

        return $this->resultFactory->create(ResultFactory::TYPE_REDIRECT)->setPath('*/*/index');
    }
}