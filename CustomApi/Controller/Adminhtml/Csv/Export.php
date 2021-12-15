<?php

namespace Bluethink\CustomApi\Controller\Adminhtml\Csv;

use Magento\SalesRule\Model\Rule;

class Export extends \Magento\Backend\App\Action
{
	protected $resultPageFactory = false;

	public function __construct(
		\Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
		\Magento\Framework\View\Result\PageFactory $resultPageFactory,
        Rule $rule
	)
	{
		parent::__construct($context);
		$this->resultPageFactory = $resultPageFactory;
        $this->coreRegistry = $coreRegistry;
        $this->rule = $rule;

	}

	public function execute()
	{
		echo "<pre>";
		// print_r(get_class_methods($this->rule->getCollection()));
		// die;
        $ruleCollection = $this->rule->getCollection();
		$ruleCollection->getSelect()->join(
			'salesrule_coupon',
		// note this join clause!
			'main_table.rule_id = salesrule_coupon.rule_id'
		);
		// ->where("sales_flat_order_address.address_type = 'billing'");
        print_r($ruleCollection->getData());
       
	}


}