<?php
namespace Bluethink\Customer\Model;
 
use Bluethink\Customer\Model\ResourceModel\Detail\CollectionFactory;
 
class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $detailCollectionFactory,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $detailCollectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }
 

    public function getData()
    {
        return [];
    }
}