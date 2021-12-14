<?php

namespace Bluethink\CustomApi\Controller\Adminhtml\Action;

class Shipping extends \Magento\Backend\App\Action
{
	protected $resultPageFactory = false;

	public function __construct(
		\Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
		\Magento\Framework\View\Result\PageFactory $resultPageFactory
	)
	{
		parent::__construct($context);
		$this->resultPageFactory = $resultPageFactory;
        $this->coreRegistry = $coreRegistry;
	}

	public function execute()
	{
        echo $orderId = $this->getRequest()->getParam('order_id');
		$resultPage = $this->resultPageFactory->create();
        $this->coreRegistry->register('order_id', $orderId);
		$resultPage->getConfig()->getTitle()->prepend((__('Tracking Details')));
		$block = $resultPage->getLayout()
                ->createBlock('Bluethink\CustomApi\Block\Adminhtml\Action\Shipping')
                ->setTemplate('Bluethink_CustomApi::shipping.phtml')
                ->toHtml();
        $this->getResponse()->setBody($block);
	}


}