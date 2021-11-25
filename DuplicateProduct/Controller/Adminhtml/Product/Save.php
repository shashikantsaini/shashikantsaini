<?php

namespace Bluethink\DuplicateProduct\Controller\Adminhtml\Product;

use \Magento\ConfigurableProduct\Model\Product\Type\Configurable;

class Save extends \Magento\Backend\App\Action
{
    
    var $detailFactory;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Catalog\Model\ProductFactory $productFactory,
        Configurable $configurable
    ) {
        parent::__construct($context);
        $this->productFactory = $productFactory;
        $this->configurable = $configurable; 
    }

    /**
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {
        $data = (int) $this->getRequest()->getParam('entity_id');
        if (!$data) {
            $this->_redirect('catalog/*/');
            return;
        }
        $dupnum = $this->getRequest()->getParam('duplicate_no');        
        $product = $this->productFactory->create()->load($data);
        // $parentId = $this->configurable->getParentIdsByChild($data);
        // echo "<pre>";
        // print_r($product->getMediaGalleryImages()->getItems());
        // foreach($product->getMediaGalleryImages()->getItems() as $proImg)
        // {            
        //     $dirname = pathinfo($proImg['path'],PATHINFO_DIRNAME);
        //     $dirname = pathinfo($proImg['path'],PATHINFO_FILENAME);
        //     $dirname = pathinfo($proImg['path'],PATHINFO_EXTENSION);
        // }
        // die();
        try 
        {
            $x = 1;
            while($x <= $dupnum) 
            {                
                $duplicate = $this->productFactory->create();
                $duplicate->setSku($product->getSku().$x);
                $duplicate->setName($product->getName().$x);
                $duplicate->setUrlKey($product->getUrlKey()."-".$x);
                $duplicate->setTypeId($product->getTypeId());
                $duplicate->setAttributeSetId($product->getAttributeSetId());
                $duplicate->setWebsiteIds($product->getWebsiteIds());            
                $duplicate->setVisibility($product->getVisibility());
                $duplicate->setPrice($product->getPrice());
                $duplicate->setStoreId($product->getStoreId());
                $duplicate->setCategoryIds($product->getCategoryIds());
                $duplicate->setStockData(array(
                    'use_config_manage_stock' => 0,
                    'manage_stock' => 1,
                    'min_sale_qty' => 1,
                    'max_sale_qty' => 5,
                    'is_in_stock' => 1,
                    'qty' => 100
                    )
                );
                $duplicate->save();
                $x++;
            }
            $this->messageManager->addSuccess(__('Product Duplicate(s) has been successfully created.'));
        } catch (\Exception $e) {
            $this->messageManager->addError(__($e->getMessage()));
        }
        $this->_redirect('catalog/*/');
    }
}