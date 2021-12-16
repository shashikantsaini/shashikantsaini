<?php

namespace Bluethink\CsvOperation\Controller\Adminhtml\Csv;

use Magento\SalesRule\Model\Rule;

class Export extends \Magento\Backend\App\Action
{
	protected $resultPageFactory = false;

	public function __construct(
		\Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
		\Magento\Framework\View\Result\PageFactory $resultPageFactory,
		\Magento\Framework\Controller\Result\JsonFactory $jsonResultFactory,
		\Magento\Framework\App\Response\Http\FileFactory $fileFactory,
    	\Magento\Framework\File\Csv $csvProcessor,
        \Magento\Framework\App\Filesystem\DirectoryList $directoryList,
        Rule $rule
	)
	{
		parent::__construct($context);
		$this->resultPageFactory = $resultPageFactory;
        $this->coreRegistry = $coreRegistry;
        $this->rule = $rule;
		$this->jsonResultFactory = $jsonResultFactory;
		$this->fileFactory = $fileFactory;
    	$this->csvProcessor = $csvProcessor;
    	$this->directoryList = $directoryList;
	}

	public function execute()
	{
		try
		{		
				$fileName = 'csv_coupon.csv';
				$filePath = $this->directoryList->getPath(\Magento\Framework\App\Filesystem\DirectoryList::VAR_DIR)
					. "/" . $fileName;

				$salesRuleData = $this->getSalesRuleData();

				$this->csvProcessor
					->setDelimiter(';')
					->setEnclosure('"')
					->saveData(
						$filePath,
						$salesRuleData
					);

				// $this->fileFactory->create(
				// 	$fileName,
				// 	[
				// 		'type' => "filename",
				// 		'value' => $fileName,
				// 		'rm' => true,
				// 	],
				// 	\Magento\Framework\App\Filesystem\DirectoryList::VAR_DIR,
				// 	'application/octet-stream'
				// );
				$result = $this->jsonResultFactory->create();
				$result->setData(['status'=>200,'message'=>'CSV exported']);
				return $result;
		}
		catch(\Exception $e)
		{
			$result = $this->jsonResultFactory->create();
            $this->messageManager->addError(__($e->getMessage()));
            $result->setData(['status'=>201,'message'=>$e->getMessage()]);
            return $result;
		}

		// echo "<pre>";
		// // print_r(get_class_methods($this->rule->getCollection()));
		// // die;
        // $ruleCollection = $this->rule->getCollection();
		// $ruleCollection->getSelect()->join(
		// 	'salesrule_coupon',
		// // note this join clause!
		// 	'main_table.rule_id = salesrule_coupon.rule_id'
		// );
		// // ->where("sales_flat_order_address.address_type = 'billing'");
        // print_r($ruleCollection->getData());
	}



	protected function getSalesRuleData()
	{
    	$result = [];
		$ruleCollection = $this->rule->getCollection();
		$ruleCollection->getSelect()->join(
			'salesrule_coupon',
		// note this join clause!
			'main_table.rule_id = salesrule_coupon.rule_id'
		);
    	$ruleCollectionData = $ruleCollection->getData();
    	$result[] = [
        	'rule_id',
        	'name',
        	'description',
        	'from_date',
 	       	'to_date',
			'uses_per_customer',
			'is_active',
			// 'conditions_serialized',
			// 'actions_serialized',
			// 'stop_rules_processing',
			// 'is_advanced',
			// 'product_ids',
            // 'sort_order',
        	// 'simple_action',
        	'discount_amount',
        	'discount_qty',
            // 'discount_step',
            'apply_to_shipping',
        	'times_used',
            // 'is_rss',
            // 'coupon_type',
            // 'use_auto_generation',
            'uses_per_coupon',
            'simple_free_shipping',
			'code',
			'coupon_id',
            'usage_limit',		
            'usage_per_customer',
            'expiration_date',
			// 'is_primary',
            'created_at'            
			// 'type',
            // 'generated_by_dotmailer'   	
		];
		foreach($ruleCollectionData as $data)
		{
			$result[] = [
				$data['rule_id'],
				$data['name'],
				$data['description'], 
				$data['from_date'],
				$data['to_date'],
				$data['uses_per_customer'],
				$data['is_active'],
				// $data['conditions_serialized'],
				// $data['actions_serialized'],
				// $data['stop_rules_processing'],
				// $data['is_advanced'],
				// $data['product_ids'],
				// $data['sort_order'],
				// $data['simple_action'],
				$data['discount_amount'],
				$data['discount_qty'],
				// $data['discount_step'],
				$data['apply_to_shipping'],
				$data['times_used'],
				// $data['is_rss'], 
				// $data['coupon_type'], 
				// $data['use_auto_generation'], 
				$data['uses_per_coupon'],
				$data['simple_free_shipping'], 
				$data['code'], 
				$data['coupon_id'],
				$data['usage_limit'],
				$data['usage_per_customer'],
				$data['expiration_date'],
				// $data['is_primary'],
				$data['created_at']
				// $data['type'],
				// $data['generated_by_dotmailer']
			];
		}
    	return $result;
	}
}