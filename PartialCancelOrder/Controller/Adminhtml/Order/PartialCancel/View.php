<?php

namespace Bluethink\PartialCancelOrder\Controller\Adminhtml\Order\PartialCancel;

use Bluethink\PartialCancelOrder\Model\PartialCancelOrderFactory;

class View extends \Magento\Backend\App\Action
{
	protected $resultPageFactory = false;

	public function __construct(
		\Magento\Backend\App\Action\Context $context,
		\Magento\Framework\View\Result\PageFactory $resultPageFactory,
		\Magento\Sales\Model\OrderFactory $orderFactory,
        PartialCancelOrderFactory $partialCancelOrderFactory,
		\Magento\Framework\Registry $coreRegistry
	)
	{
		parent::__construct($context);
		$this->resultPageFactory = $resultPageFactory;
		$this->orderFactory = $orderFactory;
        $this->partialCancelOrderFactory = $partialCancelOrderFactory;
		$this->_coreRegistry = $coreRegistry;
	}

	public function execute()
	{
		$cancelOrderId = $this->getRequest()->getParam('id');
		$cancelOrderModel = $this->partialCancelOrderFactory->create()->load($cancelOrderId);
		$this->_coreRegistry->register('partialcancelorder_data', $cancelOrderModel);
		$resultPage = $this->resultPageFactory->create();
		$resultPage->getConfig()->getTitle()->prepend((__('Partial Cancellation Details')));
		$resultPage->getLayout()->getBlock('Bluethink\PartialCancelOrder\Block\Adminhtml\Order\Partial\View');
		return $resultPage;
	}
}