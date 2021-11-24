<?php

namespace Bluethink\DuplicateProduct\Controller\Adminhtml\Product;

class Save extends \Magento\Backend\App\Action
{
    
    var $detailFactory;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Catalog\Model\ProductFactory $productFactory,
        \Magento\Catalog\Model\Product\Copier $productCopier
    ) {
        parent::__construct($context);
        $this->productFactory = $productFactory;
        $this->productCopier = $productCopier;
    }

    /**
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {
        $data = $this->getRequest()->getParams();
        $dupnum = $this->getRequest()->getParam('duplicate_no');
        echo "<pre>"; print_r($data); print_r($dupnum);die("shashsi");
        if (!$data) {
            $this->_redirect('catalog/*/');
            return;
        }
        try {
            $x = 1;
            while($x <= $dupnum) 
            {
                // $product = $this->productFactory->create();
                $product = $this->productFactory->load($data);
                $productCopier = $this->productCopier->copy($product);
                $x++;
            }
            //$rowData->setData($data);
            //print_r($rowData->getData());
            //die();
            // if (isset($data['entity_id'])) {
            //     $rowData->setCustId($data['cust_id']);
            // }
            //$rowData->save();
            $this->messageManager->addSuccess(__('Product Duplicate(s) has been successfully created.'));
        } catch (\Exception $e) {
            $this->messageManager->addError(__($e->getMessage()));
        }
        $this->_redirect('catalog/*/');
    }
}