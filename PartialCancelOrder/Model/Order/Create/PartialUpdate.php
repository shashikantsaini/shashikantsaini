<?php

namespace Bluethink\PartialCancelOrder\Model\Order\Create;

use Magento\Sales\Api\OrderItemRepositoryInterface;
use Magento\Sales\Model\OrderFactory;
use Magento\Catalog\Model\ProductFactory;


class PartialUpdate
{
    public function __construct(
        OrderItemRepositoryInterface $itemRepositoryInterface,
        OrderFactory $orderFactory,
        ProductFactory $productFactory,
        \Magento\Framework\Message\ManagerInterface $messageManager
    ) {
        $this->itemRepositoryInterface = $itemRepositoryInterface;
        $this->orderFactory = $orderFactory;
        $this->productFactory = $productFactory;
        $this->messageManager = $messageManager;
    }
    
    public function update($order , $itemData)
    {
        $totalItemQty = 0;
        foreach($itemData as $itemId => $itemQty)
        {
            $item = $this->updateItem( $itemId , $itemQty);
            $totalItemQty += $itemQty;           
        }
        $customerBalance = $this->updateOrder($order);

        $data = ['total_qty' => $totalItemQty , 'customer_balance_amount' => $customerBalance ];
        return $data;
    }

    public function updateItem( $itemId , $itemQty)
    {  
        try
        {
            $item = $this->itemRepositoryInterface->get($itemId);
             // Product Price For One Quantity
            if($item->getParentItemId()!=null)
            {
                $productPrice = $item->getParentItem()->getPrice();
                if($item)
                { //Check item object exists or not
                    $qtyCanceled = 0;
                    $qtyInvoiced = 0;
                    $qtyCanceled = $item->getParentItem()->getQtyCanceled() + $itemQty;
                    $qtyInvoiced = $item->getParentItem()->getQtyInvoiced() - $itemQty;
                    
                    $item->setQtyCanceled($qtyCanceled)
                        ->setQtyInvoiced($qtyInvoiced);
                    $item->getParentItem()->setQtyCanceled($qtyCanceled)
                                        ->setQtyInvoiced($qtyInvoiced);
                    
                    $rowTotal = $productPrice * $qtyInvoiced;
                
                    # calculateTaxAmount
                    if (!empty($item->getParentItem()->getTaxPercent())) 
                    {
                        $taxAmount = ($rowTotal * $item->getParentItem()->getTaxPercent()) / 100;
                        $item->getParentItem()->setTaxAmount($taxAmount)
                                            ->setBaseTax_amount($taxAmount);
                    }
                
                    #  Price In Grid Update
                    $item->getParentItem()->setPrice($productPrice)
                                        ->setBasePrice($productPrice);
                
                    #Subtotal On Order * Qty
                    $item->getParentItem()->setRowTotal($rowTotal)
                        ->setBaseRowTotal($rowTotal)
                        ->setRowTotalInclTax($rowTotal)
                        ->setBaseRowTotalInclTax($rowTotal);
                
                    # Apply Item Discounted Amount (Recaculated Discount)
                    if (!empty($item->getParentItem()->getDiscountPercent())) 
                    {
                        $discountedAmount = $item->getParentItem()->getRowTotal()*$item->getParentItem()->getDiscountPercent()/100;
                        $item->getParentItem()->setDiscountAmount($discountedAmount)
                             ->setBaseDiscountAmount($discountedAmount);
                    }
                    elseif (!empty($item->getParentItem()->getDiscountAmount())) 
                    {
                        $discountedAmount = $item->getParentItem()->getRowTotal()-$item->getParentItem()->getDiscountAmount();
                        $item->getParentItem()->setDiscountAmount($discountedAmount)
                            ->setBaseDiscountAmount($discountedAmount);
                    }
                    $item->getParentItem()->save();
                    $item->save();
                }
            }
            else
            {
                $productPrice = $item->getPrice();
                
                if($item)
                { //Check item object exists or not
                    $qtyCanceled = 0;
                    $qtyInvoiced = 0;
                    $qtyCanceled = $item->getQtyCanceled() + $itemQty;
                    $qtyInvoiced = $item->getQtyInvoiced() - $itemQty;
                    
                    $item->setQtyCanceled($qtyCanceled)
                        ->setQtyInvoiced($qtyInvoiced);
                    
                    $rowTotal = $productPrice * $qtyInvoiced;
                
                    # calculateTaxAmount
                    if (!empty($item->getTaxPercent())) 
                    {
                        $taxAmount = ($rowTotal * $item->getTaxPercent()) / 100;
                        $item->setTaxAmount($taxAmount)
                            ->setBaseTax_amount($taxAmount);
                    }
                
                    #  Price In Grid Update
                    $item->setPrice($productPrice)
                        ->setBasePrice($productPrice);
                
                    #Subtotal On Order * Qty
                    $item->setRowTotal($rowTotal)
                        ->setBaseRowTotal($rowTotal)
                        ->setRowTotalInclTax($rowTotal)
                        ->setBaseRowTotalInclTax($rowTotal);
                
                    # Apply Item Discounted Amount (Recaculated Discount)
                    if (!empty($item->getDiscountPercent())) 
                    {
                        $discountedAmount = $item->getRowTotal()*$item->getDiscountPercent()/100;
                        $item->setDiscountAmount($discountedAmount)
                            ->setBaseDiscountAmount($discountedAmount);
                    }
                    elseif (!empty($item->getDiscountAmount())) 
                    {
                        $discountedAmount = $item->getRowTotal()-$item->getDiscountAmount();
                        $item->setDiscountAmount($discountedAmount)
                            ->setBaseDiscountAmount($discountedAmount);
                    }
                    $item->save();
                }            
            }
        }
        catch(\Exception $e)
        {
            $this->messageManager->addErrorMessage($e->getMessage());
        }
        return $item;
    }

    public function updateOrder($order)
    {  
        try
        {
            $orderSubTotal = 0;
            $orderBaseTax = 0;
            $orderDiscountAmount = 0;
            foreach ($order->getAllVisibleItems() as $_item) 
            {
                $orderSubTotal += $_item->getBaseRowTotal();
                $orderBaseTax += $_item->getBaseTaxAmount() + $_item->getBaseHiddenTaxAmount();
                $orderDiscountAmount += $_item->getBaseDiscountAmount();
            }
            
            $subTotalInclTax = $orderSubTotal +  $orderBaseTax;
            $grandTotal = ($orderSubTotal + $order->getShippingAmount() + $orderBaseTax) - $orderDiscountAmount;
            $customerBalanceAmount = $order->getGrandTotal() - $grandTotal;
            
            # Update Order Totals
            $order->setSubtotal($orderSubTotal)
                ->setBaseSubtotal($orderSubTotal)
                ->setSubtotalInclTax($subTotalInclTax)
                ->setBaseSubtotalInclTax($subTotalInclTax)
                ->setDiscountAmount($orderDiscountAmount)
                ->setBaseDiscountAmount($orderDiscountAmount)
                ->setTaxAmount($orderBaseTax)
                ->setBaseTaxAmount($orderBaseTax)
                ->setGrandTotal($grandTotal)
                ->setBaseGrandTotal($grandTotal)
                ->save();
        }
        catch(\Exception $e)
        {
            $this->messageManager->addErrorMessage($e->getMessage()); 
        }
        return $customerBalanceAmount;
    }


}
