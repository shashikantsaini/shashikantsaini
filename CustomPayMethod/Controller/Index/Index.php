<?php 

namespace Bluethink\CustomPayMethod\Controller\Index;

use Magento\Checkout\Model\Session;
use Magento\Framework\App\Action\Context;

class Index extends \Magento\Framework\App\Action\Action
{


public function __construct(
        Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        Session $checkoutSession,
        \Magento\Framework\Registry $coreRegistry
    ) {
        parent::__construct($context);
        $this->_coreRegistry = $coreRegistry;
        $this->resultPageFactory = $resultPageFactory;
        $this->checkoutSession = $checkoutSession; //Used for getting the order: $order = $this->checkoutSession->getLastRealOrder(); And other order data like ID & amount
    }

public function execute()
    {
        //Your custom code for getting the data the payment provider needs
        $order = $this->checkoutSession->getLastRealOrder();
        $this->_coreRegistry->register('order', $order);
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend((__('Authorization Page')));
		return $resultPage;
    }
}