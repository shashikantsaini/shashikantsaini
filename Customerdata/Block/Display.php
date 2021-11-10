<?php
namespace Bluethink\Customerdata\Block;

use Magento\Framework\View\Element\Template;

class Display extends Template
{
    protected $_customer;
    protected $_customerFactory;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Customer\Model\Customer $customers,
        \Magento\Customer\Model\CustomerFactory $customerFactory
    )
    {   
        $this->_customerFactory = $customerFactory;
        $this->_customer = $customers;
        parent::__construct($context);
    }

    public function getCustomersCollection() {

        $collection = $this->_customer->getCollection();
        $collection->getSelect()->join(
            ['customer_address_entity'=>$collection->getTable('customer_address_entity')],
            'e.entity_id = customer_address_entity.parent_id','*');
        $collection->getSelect()->join(
            ['customer_grid_flat'=>$collection->getTable('customer_grid_flat')],
            'e.email = customer_grid_flat.email','*');

        return $collection;
    }

    // public function getFilteredCustomersCollection() {
    //     return $this->_customerFactory->create()->getCollection()
    //             ->addAttributeToSelect("*")->load();
    // }
}