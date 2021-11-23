<?php
namespace Bluethink\DuplicateProduct\Controller\Adminhtml\Product;

use Magento\Framework\Controller\ResultFactory;

class Duplicate extends \Magento\Backend\App\Action
{
    
    private $coreRegistry;

    
    private $detailFactory;

    
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Catalog\Model\ProductFactory $productFactory,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Registry $coreRegistry
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->productFactory = $productFactory;
        $this->coreRegistry = $coreRegistry;
    }

    /**
     * Mapped Grid List page.
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        $productId = (int) $this->getRequest()->getParam('id');
        $product = $this->productFactory->create();
        $product = $product->load($productId);
        $productTitle = $product->getName();
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
       
        if ($productId && !$product->getEntityId()) {
            /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
            $resultRedirect = $this->resultRedirectFactory->create();
            $this->messageManager->addErrorMessage(__('This product doesn\'t exist.'));
            return $resultRedirect->setPath('catalog/*/');
        } elseif ($productId === 0) { 
            /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
            $resultRedirect = $this->resultRedirectFactory->create();
            $this->messageManager->addErrorMessage(__('Invalid product id. Should be numeric value greater than 0'));
            return $resultRedirect->setPath('catalog/*/');
        }
        
        $resultPage = $this->resultPageFactory->create();
        $title = $productId ? __('Create Duplicate ').$productTitle :__('Add Customer Data');
        $resultPage->getConfig()->getTitle()->prepend($title);
        return $resultPage;
    }
}