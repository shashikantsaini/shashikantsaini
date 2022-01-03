<?php

namespace Bluethink\Faq\Block\Frontend\Faq;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\Registry;
use Bluethink\Faq\Model\ResourceModel\Faq\CollectionFactory as FaqCollection;
use Bluethink\Faq\Model\ResourceModel\FaqGroup\CollectionFactory as FaqGroupCollection;

class View extends Template
{
    /**
     * @var Registry
     */
    protected $coreRegistry;

    /**
     * @var FaqCollection
     */
    protected $faqCollection;

    /**
     * @var FaqGroupCollection
     */
    protected $faqGroupCollection;

    public function __construct(
        Context $context,      
        Registry $coreRegistry,
        FaqCollection $faqCollection,
        FaqGroupCollection $faqGroupCollection,     
        array $data = []
    )
    { 
        $this->_coreRegistry = $coreRegistry;
        $this->faqCollection = $faqCollection;
        $this->faqGroupCollection =     $faqGroupCollection;  
        parent::__construct($context, $data);
    }

    public function getFaqCollection()
    {
        $collection = $this->faqCollection->create();
        return $collection;
    }

    public function getFaqGroupCollection()
    {
        $collection = $this->faqGroupCollection->create();
        $collection->setPageSize(15);
        return $collection;
    }

    public function getFaqCollectionByGroupId($groupId)
    {
        $collection = $this->getFaqCollection()->addFieldToFilter('group', ['eq' => $groupId]);
        return $collection;
    }
}