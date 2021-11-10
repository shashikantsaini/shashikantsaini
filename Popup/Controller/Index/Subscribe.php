<?php

namespace Bluethink\Popup\Controller\Index;

use Magento\Newsletter\Model\Subscriber;
use Magento\Newsletter\Model\SubscriberFactory;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Customer\Api\AccountManagementInterface as CustomerAccountManagement;
use Magento\Customer\Model\Session;
use Magento\Framework\App\Action\Action;

class Subscribe extends Action
{
	protected $_pageFactory;


	public function __construct(
		\Magento\Framework\App\Action\Context $context,
		\Magento\Framework\View\Result\PageFactory $pageFactory,
		\Magento\Framework\Controller\Result\JsonFactory   $resultJsonFactory,
		SubscriberFactory $subscriberFactory,
		StoreManagerInterface $storeManager,
		CustomerAccountManagement $customerAccountManagement,
		Session $customerSession
	) {
		$this->resultJsonFactory = $resultJsonFactory;
		$this->_customerSession = $customerSession;
		$this->customerAccountManagement = $customerAccountManagement;
		$this->_storeManager = $storeManager;
		$this->_subscriberFactory = $subscriberFactory;
		$this->_pageFactory = $pageFactory;
		return parent::__construct($context);
	}


	public function execute()
	{
		$result = $this->resultJsonFactory->create();

		if ($this->getRequest()->isPost() && $this->getRequest()->getPost('email')) {
			$email = $this->getRequest()->getPost('email');

			//Format Validation
			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$message = array("status" => "0", "message" => "Please enter a valid email address.");
				return $result->setData($message);
			}

			//Duplicate Validation
			$websiteId = $this->_storeManager->getStore()->getWebsiteId();
			if ($this->_customerSession->getCustomerDataObject()->getEmail() !== $email	&& !$this->customerAccountManagement->isEmailAvailable($email, $websiteId)) {
				$message = array("status" => "0", "message" => "This email address is already assigned to another user.");
				return $result->setData($message);
			}

			$subscriber = $this->_subscriberFactory->create()->loadByEmail($email);

			//Subscription Validation
			if ($subscriber->getId() && (int) $subscriber->getSubscriberStatus() === Subscriber::STATUS_SUBSCRIBED) {
				$message = array("status" => "0", "message" => "This email address is already subscribed.");
				return $result->setData($message);
			}

			$status = (int) $this->_subscriberFactory->create()->subscribe($email);

			if ($status === Subscriber::STATUS_NOT_ACTIVE) {
				$message = array("status" => "1", "message" => "The confirmation request has been sent.");
				return $result->setData($message);
			}
			$message = array("status" => "1", "message" => "Thank you for your subscription.");
			return $result->setData($message);
		} else {
			$message = array("status" => "0", "message" => "Please fill email");
			return $result->setData($message);
		}
	}
}
