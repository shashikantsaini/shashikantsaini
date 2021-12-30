<?php
namespace Bluethink\Faq\Model\FaqGroup;
 
use Bluethink\Faq\Model\ResourceModel\FaqGroup\CollectionFactory;
 
class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    protected $_loadedData;
    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $itemCollectionFactory
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }
 
    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        if (isset($this->_loadedData)) {
            return $this->_loadedData;
        }
        $items = $this->collection->getItems();
    
        foreach ($items as $itemData) {            
            $data = $itemData->getData();      
            $this->_loadedData[$itemData->getFaqgroupId()] = $data;     
        }
        return $this->_loadedData;
    }
    
}