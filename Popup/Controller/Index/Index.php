<?php

namespace Bluethink\Popup\Controller\Index;

use Magento\Framework\App\Action\Action;

class Index extends Action
{
	protected $_pageFactory;


	public function __construct(
		\Magento\Framework\App\Action\Context $context,
		\Magento\Framework\View\Result\PageFactory $pageFactory
	) {
		$this->_pageFactory = $pageFactory;
		return parent::__construct($context);
	}


	public function execute()
	{
		$email = array("abc", "xyz", "lkh", "rty", "bvc", "mko");
		    $toArr = [];
            foreach ($email as $toAddr) {
                $toArr[] = $toAddr;
            }
        $emailas =implode(',', $toArr);

        echo $emailas;
		die();
	}
}
