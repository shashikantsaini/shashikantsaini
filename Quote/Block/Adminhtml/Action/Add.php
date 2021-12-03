<?php
/**
 *
 * @package     magento2
 * @author      Codilar Technologies
 * @license     https://opensource.org/licenses/OSL-3.0 Open Software License v. 3.0 (OSL-3.0)
 * @link        https://www.codilar.com/
 */

namespace Bluethink\Quote\Block\Adminhtml\Action;

use Magento\Framework\View\Element\Template;

class Add extends Template
{
    protected $_productCollectionFactory;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,  
        \Magento\Framework\Data\Form\FormKey $formKey,      
        \Magento\Framework\Registry $coreRegistry,       
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,        
        array $data = []
    )
    {    
        $this->_productCollectionFactory = $productCollectionFactory;
        $this->_coreRegistry = $coreRegistry; 
        $this->formKey = $formKey;   
        parent::__construct($context, $data);
    }
    
    public function getProductCollection()
    {
        $collection = $this->_productCollectionFactory->create();
        $collection->addAttributeToSelect('*');
        return $collection;
    }

    public function getQuoteId()
    {
        // will return 'bar'
        return $this->_coreRegistry->registry('quote_id');
    }

    public function getFormKey()
    {
        return $this->formKey->getFormKey();
    }
}

