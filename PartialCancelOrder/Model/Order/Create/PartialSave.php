<?php

namespace Bluethink\PartialCancelOrder\Model\Order\Create;

use Bluethink\PartialCancelOrder\Model\PartialCancelItemFactory;
use Bluethink\PartialCancelOrder\Model\PartialCancelOrderFactory;
use Bluethink\PartialCancelOrder\Model\PartialCancelReasonFactory;
use Magento\Sales\Api\OrderItemRepositoryInterface;


class PartialSave
{
    public function __construct(
        OrderItemRepositoryInterface $itemRepositoryInterface,
        PartialCancelItemFactory $partialCancelItemFactory,
        PartialCancelOrderFactory $partialCancelOrderFactory,
        PartialCancelReasonFactory $partialCancelReasonFactory,
        \Magento\Framework\Message\ManagerInterface $messageManager
        
    ) {
        $this->itemRepositoryInterface = $itemRepositoryInterface;
        $this->partialCancelItemFactory = $partialCancelItemFactory;
        $this->partialCancelOrderFactory = $partialCancelOrderFactory;
        $this->partialCancelReasonFactory = $partialCancelReasonFactory;
        $this->messageManager = $messageManager;
    }
    
    public function save($order , $data , $itemData , $reasonCode)
    {
        try
        {
            $reasonLabel = $this->partialCancelReasonFactory->create()->getCollection()->getItemByColumnValue('reason_code',$reasonCode)->getReasonLabel();
            
            $modelCancelOrder = $this->partialCancelOrderFactory->create();

            $modelCancelOrder->addData([
                'order_id' => $order->getEntityId(),
                'store_id' => $order->getStoreId(),
                'total_qty' => $data['total_qty'],
            ]);
            
            $modelCancelOrder->save();
            $cancelOrderId = $modelCancelOrder->getEntityId();

            foreach($itemData as $itemId => $itemQty)
            {
                $item = $this->itemRepositoryInterface->get($itemId);
                if($item->getParentItemId()!=null)
                {
                    $rowTotal = $item->getParentItem()->getPrice() * $itemQty;
                    
                    # calculateTaxAmount
                    if (!empty($item->getParentItem()->getTaxPercent())) 
                    {
                        $taxAmount = ($rowTotal * $item->getParentItem()->getTaxPercent()) / 100;
                    }
                    
                    $rowTotalInclTax = $rowTotal + $taxAmount;
                    
                    # Apply Item Discounted Amount (Recaculated Discount)
                    if (!empty($item->getParentItem()->getDiscountPercent())) 
                    {
                        $discountedAmount = $rowTotal * $item->getParentItem()->getDiscountPercent()/100;
                    }
                    elseif (!empty($item->getParentItem()->getDiscountAmount())) 
                    {
                        $discountedAmount = $rowTotal - $item->getParentItem()->getDiscountAmount();
                    }
                    
                    $modelCancelItem = $this->partialCancelItemFactory->create();
                    $modelCancelItem->addData([
                        'parent_id' => $cancelOrderId,
                        'order_item_id' => $item->getItemId(),
                        'qty' => $itemQty,
                        'row_total' => $rowTotal,
                        'base_price' => $item->getParentItem()->getBasePrice(),
                        'price' => $item->getParentItem()->getPrice(),
                        'base_price_incl_tax' => $item->getParentItem()->getPrice(),
                        'price_incl_tax' => $item->getParentItem()->getPrice(),
                        'tax_amount' => $taxAmount,
                        'base_tax_amount' => $taxAmount,
                        'base_row_total' => $rowTotal,
                        'base_row_total_incl_tax' => $rowTotalInclTax,
                        'row_total_incl_tax' => $rowTotalInclTax,
                        'discount_amount' => $discountedAmount,
                        'base_discount_amount' => $discountedAmount,
                        'sku' => $item->getSku(),
                        'name' => $item->getName(),
                        'product_id' => $item->getProductId(),
                    ]);
                    $modelCancelItem->save();
                }
                else
                {
                    $rowTotal = $item->getPrice() * $itemQty;
                    
                    # calculateTaxAmount
                    if (!empty($item->getTaxPercent())) 
                    {
                        $taxAmount = ($rowTotal * $item->getTaxPercent()) / 100;
                    }
                    
                    $rowTotalInclTax = $rowTotal + $taxAmount;
                    
                    # Apply Item Discounted Amount (Recaculated Discount)
                    if (!empty($item->getDiscountPercent())) 
                    {
                        $discountedAmount = $rowTotal * $item->getDiscountPercent()/100;
                    }
                    elseif (!empty($item->getDiscountAmount())) 
                    {
                        $discountedAmount = $rowTotal - $item->getDiscountAmount();
                    }
                    
                    $modelCancelItem = $this->partialCancelItemFactory->create();
                    $modelCancelItem->addData([
                        'parent_id' => $cancelOrderId,
                        'order_item_id' => $item->getItemId(),
                        'qty' => $itemQty,
                        'row_total' => $rowTotal,
                        'base_price' => $item->getBasePrice(),
                        'price' => $item->getPrice(),
                        'base_price_incl_tax' => $item->getPrice(),
                        'price_incl_tax' => $item->getPrice(),
                        'tax_amount' => $taxAmount,
                        'base_tax_amount' => $taxAmount,
                        'base_row_total' => $rowTotal,
                        'base_row_total_incl_tax' => $rowTotalInclTax,
                        'row_total_incl_tax' => $rowTotalInclTax,
                        'discount_amount' => $discountedAmount,
                        'base_discount_amount' => $discountedAmount,
                        'sku' => $item->getSku(),
                        'name' => $item->getName(),
                        'product_id' => $item->getProductId(),
                    ]);
                    $modelCancelItem->save();
                }
            }
            
            $orderSubTotal = 0;
            $orderBaseTax = 0;
            $orderDiscountAmount = 0;
            foreach ($modelCancelItem->getCollection() as $_item) 
            {
                if($_item->getParentId() == $cancelOrderId)
                {
                    $orderSubTotal += $_item->getBaseRowTotal();
                    $orderBaseTax += $_item->getBaseTaxAmount() + $_item->getBaseHiddenTaxAmount();
                    $orderDiscountAmount += $_item->getBaseDiscountAmount();
                }
            }
            
            $subTotalInclTax = $orderSubTotal +  $orderBaseTax;
            $grandTotal = ($orderSubTotal + $orderBaseTax) - $orderDiscountAmount;
            $modelCancelOrder = $this->partialCancelOrderFactory->create()->load($cancelOrderId);
            
            $modelCancelOrder->addData([
                'reason_code' =>$reasonCode,
                'reason_label' =>$reasonLabel,
                'shipping_amount' => 0,
                'base_shipping_amount' => 0,
                'store_currency_code' => $order->getStoreCurrencyCode(),
                'base_currency_code' => $order->getBaseCurrencyCode(),
                'global_currency_code' => $order->getGlobalCurrencyCode(),
                'customer_balance_amount' => $data['customer_balance_amount'],
                'base_customer_balance_amount' => $data['customer_balance_amount'],
                'grand_total' => $grandTotal,
                'base_grand_total' => $grandTotal,
                'discount_amount' => $orderDiscountAmount,
                'base_discount_amount' => $orderDiscountAmount,
                'tax_amount' => $orderBaseTax,
                'base_tax_amount' => $orderBaseTax,
                'subtotal' => $orderSubTotal,
                'base_subtotal' => $orderSubTotal,
                'subtotal_incl_tax' => $subTotalInclTax,
                'base_subtotal_incl_tax' => $subTotalInclTax,
            ]);
            $modelCancelOrder->save();
        }
        catch(\Exception $e)
        {
            $this->messageManager->addErrorMessage($e->getMessage());
        }
        return $cancelOrderId;
    }
}