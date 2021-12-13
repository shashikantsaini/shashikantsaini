<?php

namespace Bluethink\Quote\Controller\Adminhtml\Quote;

use Magento\Quote\Model\Quote\Item ;
use Magento\Quote\Model\QuoteFactory ;
use Magento\Quote\Model\QuoteManagement ;

class Order extends \Magento\Backend\App\Action
{

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magento\Customer\Model\CustomerFactory $customerFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository,
        \Magento\Sales\Model\Order\Email\Sender\OrderSender $orderSender,
        \Magento\Framework\Controller\Result\JsonFactory $jsonResultFactory,
        Item $quoteItem,
        QuoteFactory $quoteFactory,
        QuoteManagement $quoteManagement
    ) {
        parent::__construct($context);
        $this->quoteItem=$quoteItem;
        $this->quoteFactory=$quoteFactory;
        $this->quoteManagement=$quoteManagement;
        $this->_checkoutSession = $checkoutSession;
        $this->customerFactory = $customerFactory;
        $this->storeManager = $storeManager;
        $this->customerRepository = $customerRepository;
        $this->orderSender = $orderSender;
        $this->jsonResultFactory = $jsonResultFactory;
    }

    public function execute()
    {        
        $store = $this->storeManager->getStore();
        $storeId = $store->getStoreId();
        $websiteId = $this->storeManager->getStore()->getWebsiteId();
        $quoteId = $this->getRequest()->getParam('quote_id');
        $quote = $this->quoteFactory->create()->load($quoteId);
        $quote->setStore($store);
        $customer = $this->customerFactory->create();
        $customer->setWebsiteId($websiteId);
        $customer->loadByEmail($quote->getCustomerEmail());
        $customer= $this->customerRepository->getById($customer->getId());
        $quote->assignCustomer($customer); //Assign quote to customer
        // echo "<pre>";
        // print_r($customer);
        // die();

        if (!$quote) {
            $this->_redirect('quote/quote/index');
            return;
        }

        try {
            $shippingAddress=$quote->getShippingAddress();            
            $shippingAddress->setCollectShippingRates(true)->collectShippingRates()->setShippingMethod('freeshipping_freeshipping');

            // echo "<pre>";
            // print_r($shippingAddress->getData());
            // die();

            $quote->setPaymentMethod('cashondelivery'); //payment method
            $quote->setInventoryProcessed(false); //not effetc inventory

            // Set Sales Order Payment
            $quote->getPayment()->importData(['method' => 'cashondelivery']);
            $quote->save(); //Now Save quote and your quote is ready
            // Collect Totals
            $quote->collectTotals()->save();
            

            $order = $this->quoteManagement->submit($quote);
            $order->setEmailSent(0);
            $increment_id = $order->getRealOrderId();
            $this->_checkoutSession->setLastOrderId($order->getId())->setLastRealOrderId($order->getIncrementId());
            $msg= sprintf('Order has been successfully Placed with Order Id: %s.', $increment_id);
            $this->messageManager->addSuccess(__($msg));
            $result = $this->jsonResultFactory->create();
            $result->setData(['status'=>200,'message'=>$msg]);
            return $result;
        } catch (\Exception $e) {
            $result = $this->jsonResultFactory->create();
            $this->messageManager->addError(__($e->getMessage()));
            $result->setData(['status'=>201,'message'=>'Order not created have some issue']);
            return $result;
        }
        $this->_redirect('quote/quote/index');
    }
}