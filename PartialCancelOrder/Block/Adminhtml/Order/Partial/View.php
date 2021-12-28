<?php

namespace Bluethink\PartialCancelOrder\Block\Adminhtml\Order\Partial;

use Magento\Framework\Pricing\Helper\Data;
use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Customer\Api\GroupRepositoryInterface;

class View extends \Magento\Backend\Block\Template
{
    /**
 	* Block template.
 	*
 	* @var string
 	*/
    protected $_template = 'partial_cancel.phtml';

	protected $priceHelper;

	public function __construct(
        \Magento\Backend\Block\Template\Context $context,  
        \Magento\Framework\Data\Form\FormKey $formKey,      
        \Magento\Framework\Registry $coreRegistry,
		OrderRepositoryInterface $orderRepository,
        GroupRepositoryInterface $groupRepository,
        Data $priceHelper,        
        array $data = []
    )
    {
        $this->_coreRegistry = $coreRegistry; 
        $this->formKey = $formKey;
        $this->priceHelper = $priceHelper; 
		$this->orderRepository = $orderRepository;
        $this->groupRepository = $groupRepository;  
        parent::__construct($context, $data);
    }

    public function getPartialOrder()
    {
        return $this->_coreRegistry->registry('partialcancelorder_data');
    }

    public function getPartialOrderId()
    {
        return $this->getPartialOrder()->getEntityId();
    }

    public function getItemsCollection()
    {
        return $this->getOrder()->getItemsCollection();
    }

    public function getFormKey()
    {
        return $this->formKey->getFormKey();
    }

    public function getFormattedPrice($price)
    {
        return $this->priceHelper->currency($price, true, false);
    }

	public function getOrderAdminDate($createdAt)
    {
        return $this->_localeDate->date(new \DateTime($createdAt));
    }

	public function getOrder()
    {
		$orderId = $this->getPartialOrder()->getOrderId();
		$order = $this->orderRepository->get($orderId);
        return $order;
    }

    public function getCustomerGroupName()
    {
        $groupId = $this->getOrder()->getCustomerGroupId();
        $group = $this->groupRepository->getById($groupId);
        return $group->getCode();
    }
}