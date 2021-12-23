<?php

namespace Bluethink\PartialCancelOrder\Controller\Adminhtml\Order;

use Bluethink\PartialCancelOrder\Model\Order\Create\PartialUpdate;
use Bluethink\PartialCancelOrder\Model\Order\Create\PartialSave;

class Create extends \Magento\Backend\App\Action
{
	protected $resultPageFactory = false;

	public function __construct(
		\Magento\Backend\App\Action\Context $context,
		\Magento\Framework\View\Result\PageFactory $resultPageFactory,
		\Magento\Sales\Model\OrderFactory $orderFactory,
		\Magento\Sales\Api\OrderItemRepositoryInterface $itemRepositoryInterface,
		PartialUpdate $partialUpdate,
		PartialSave $partialSave,
		\Magento\Framework\Registry $coreRegistry
	)
	{
		parent::__construct($context);
		$this->resultPageFactory = $resultPageFactory;
		$this->orderFactory = $orderFactory;
		$this->coreRegistry = $coreRegistry;
		$this->partialUpdate = $partialUpdate;
		$this->partialSave = $partialSave;
		$this->itemRepositoryInterface = $itemRepositoryInterface;
	}

	public function execute()
	{
		
		try
		{
			// $order = $this->getRequest()->getParams();
			$orderId = $this->getRequest()->getParam('order_id');
			
			$order = $this->orderFactory->create()->load($orderId);//Load order by Order ID
			
			$reasonCode = $this->getRequest()->getParam('reason_code');//get Param reason_code
			
			$itemData = array_filter($this->getRequest()->getParam('item_data'));//get Item Id and Item Quantity
	
			$data = $this->partialUpdate->update($order , $itemData);
	
			$cancelOrderId = $this->partialSave->save($order , $data , $itemData , $reasonCode);	
			
			$msg= sprintf('Partially Cancelled Order Created with Id: %s.', $cancelOrderId);
			$this->messageManager->addSuccess(__($msg));			
		}
		catch(\Exception $e)
		{
			$this->messageManager->addErrorMessage($e->getMessage());
		}
		$resultRedirect = $this->resultRedirectFactory->create();
		$resultRedirect->setPath('sales/order/view',['order_id' => $orderId]);
		return $resultRedirect;
	}
}

// foreach($itemData as $itemId => $itemQty)
		// {		
		// 	$orderItem = $this->itemRepositoryInterface->get($itemId);
		// 	try
		// 	{
		// 		if($orderItem->getProductType()!="configurable")
		// 		{
		// 			if($orderItem->getParentItemId()!=null)
		// 			{
		// 				$customerBalanceAmount = $this->updateOrder->update($order , $orderItem , $itemQty);//updating Order and Order_item
		// 				$orderId = $this->createPartialOrder->create($order , $orderItem , $reasonCode , $customerBalanceAmount);//saving to Paritial Order and items
		// 			}
		// 			else
		// 			{
		// 				$customerBalanceAmount = $this->updateOrder->update($order , $orderItem , $itemQty);//updating Order and Order_item
		// 				$orderId = $this->createPartialOrder->create($order , $orderItem , $reasonCode ,  $customerBalanceAmount);//saving to Paritial Order and items
		// 			}
		// 		}

		// 		$msg= sprintf('Partially Cancelled Order Created with Id: %s.', $orderId);
		// 		$this->messageManager->addSuccess(__($msg));			
		// 	}
		// 	catch(\Exception $e)
		// 	{
		// 		$this->messageManager->addErrorMessage($e->getMessage());
		// 	}
		// }