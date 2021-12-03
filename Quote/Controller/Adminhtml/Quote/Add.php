<?php

namespace Bluethink\Quote\Controller\Adminhtml\Quote;

use Magento\Quote\Model\Quote\Item ;
use Magento\Quote\Model\QuoteFactory ;
use Magento\Quote\Model\QuoteManagement ;
use Magento\Framework\App\ResponseInterface ;
use Magento\Framework\View\Result\PageFactory ;

class Add extends \Magento\Backend\App\Action
{
    /**
     * @var PageFactory
     */
    private $pageFactory;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        PageFactory $pageFactory
    ) {
        parent::__construct($context);
        $this->coreRegistry = $coreRegistry;
        $this->pageFactory = $pageFactory;
    }

    public function execute()
    {
        $quoteId = $this->getRequest()->getParam('id');
        // // echo "<pre>";
        // // print_r($quoteId);
        // // die("Shasi124");
        $this->coreRegistry->register('quote_id', $quoteId);
        $page = $this->pageFactory->create();
        $page->getConfig()->getTitle()->prepend('Add Item(s)');
        return $page;
    }
}