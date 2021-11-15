<?php

namespace Bluethink\CustomProductTab\Block;

use Magento\Catalog\Block\Product\AbstractProduct;
use Magento\Catalog\Api\ProductRepositoryInterface;

class View extends AbstractProduct
{
	protected $productRepository;

	public function __construct(
        \Magento\Catalog\Block\Product\Context $context,       
        ProductRepositoryInterface $productRepository,
        array $data = []
    ) {        
        $this->productRepository = $productRepository;
        parent::__construct(
            $context,
            $data
        );
    }

	public function getProduct()
    {
        if (!$this->_coreRegistry->registry('product') && $this->getProductId()) {
            $product = $this->productRepository->getById($this->getProductId());
            $this->_coreRegistry->register('product', $product);
        }
        return $this->_coreRegistry->registry('product');
    }

	public function getProductdetail($attcode)
	{
		$product = $this->getProduct();
		$attribute = $product->getResource()->getAttribute($attcode);
		$attribute_value = $attribute->getFrontend()->getValue($product);
		return $attribute_value;
	}    
}
