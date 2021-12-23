<?php 

namespace Bluethink\CustomPayMethod\Controller\Index;

use Magento\Checkout\Model\Session;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Sales\Model\OrderFactory;

class Index extends \Magento\Framework\App\Action\Action
{


public function __construct(
        Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig, 
        Session $checkoutSession, 
        \Magento\Framework\Locale\Resolver $store,
        \Magento\Framework\UrlInterface $urlBuilder,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory, 
        \Magento\Directory\Model\CountryFactory $countryFactory,
        OrderFactory $orderFactory,
        \Magento\Framework\Registry $coreRegistry
    ) {
        parent::__construct($context);
        $this->orderFactory = $orderFactory;
        $this->_coreRegistry = $coreRegistry;
        $this->resultPageFactory = $resultPageFactory;
        $this->scopeConfig = $scopeConfig; //Used for getting data from System/Admin config
        $this->checkoutSession = $checkoutSession; //Used for getting the order: $order = $this->checkoutSession->getLastRealOrder(); And other order data like ID & amount
        $this->store = $store; //Used for getting store locale if needed $language_code = $this->store->getLocale();
        $this->urlBuilder = $urlBuilder; //Used for creating URLs to other custom controllers, for example $success_url = $this->urlBuilder->getUrl('frontname/path/action');
        $this->resultJsonFactory = $resultJsonFactory; //Used for returning JSON data to the afterPlaceOrder function ($result = $this->resultJsonFactory->create(); return $result->setData($post_data);)
    }

public function execute()
    {
        //Your custom code for getting the data the payment provider needs
        $order = $this->checkoutSession->getLastRealOrder();
        $this->_coreRegistry->register('order', $order);
        //Structure your return data so the form-builder.js can build your form correctly
        // $post_data = array(
        //     'action' => $form_action_url,
        //     'fields' => array (
        //         'shop_id' => $shop_id,
        //         'order_id' => $order_id,
        //         'api_key' => $api_key,
        //         //add all the fields you need
        //     )
        // );
        // $result = $this->resultJsonFactory->create();
        $resultPage = $this->resultPageFactory->create();
        // $block = $resultPage->getLayout()
        // ->createBlock('Bluethink\CustomPayMethod\Block\Frontend\Authorize\Check')
        // ->setTemplate('Bluethink_CustomPayMethod::authorize.phtml')
        // ->toHtml();
        // $this->getResponse()->setBody($block);
        $resultPage->getConfig()->getTitle()->prepend((__('Authorization Page')));
		return $resultPage;

        // return $result->setData($post_data); //return data in JSON format
    }
}