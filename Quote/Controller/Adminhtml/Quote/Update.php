<?php
namespace Bluethink\Quote\Controller\Adminhtml\Quote;

use Magento\Framework\Controller\ResultFactory;

class Update extends \Magento\Backend\App\Action
{
    
    private $coreRegistry;

    
    private $detailFactory;

    
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Quote\Model\QuoteFactory $quoteFactory,
        \Magento\Quote\Model\QuoteRepository $quoteRepository
    ) {
        parent::__construct($context);
        $this->coreRegistry = $coreRegistry;
        $this->quoteFactory = $quoteFactory;
        $this->quoteRepository = $quoteRepository;
    }

    /**
     * Mapped Grid List page.
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        $quoteId = $this->getRequest()->getParam('id');
        $quoteData = $this->quoteFactory->create();
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        if ($quoteId) {
           $quoteData = $quoteData->load($quoteId);
           $quoteItems = $this->quoteRepository->get($quoteId);
           $items = $quoteItems->getAllItems();
           if (!$quoteData->getEntityId()) {
               $this->messageManager->addError(__('Quote data no longer exist.'));
               $this->_redirect('quote/quote/index');
               return;
           }
       }

       $this->coreRegistry->register('quote_items', $items);
       $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
       $title = $quoteId."Edit Quote Data";
       $resultPage->getConfig()->getTitle()->prepend($title);
       return $resultPage;
    }
}