<?php

namespace Bluethink\PartialCancelOrder\Controller\Adminhtml\Order;

class View extends \Magento\Backend\App\Action
{
	protected $resultPageFactory = false;

	public function __construct(
		\Magento\Backend\App\Action\Context $context,
		\Magento\Framework\View\Result\PageFactory $resultPageFactory,
		\Magento\Sales\Model\OrderFactory $orderFactory,
		\Magento\Framework\Registry $coreRegistry
	)
	{
		parent::__construct($context);
		$this->resultPageFactory = $resultPageFactory;
		$this->orderFactory = $orderFactory;
		$this->coreRegistry = $coreRegistry;
	}

	public function execute()
	{
		$orderId = $this->getRequest()->getParam('order_id');
		$orderModel = $this->orderFactory->create()->load($orderId);
		$this->coreRegistry->register('order_data', $orderModel);
		$resultPage = $this->resultPageFactory->create();
		$resultPage->getConfig()->getTitle()->prepend((__('Partial Cancel Order')));

		return $resultPage;
	}


}