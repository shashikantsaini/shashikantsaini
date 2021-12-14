<?php
namespace Bluethink\CsvOperation\Model\Export;

/**
 * Class Manufacturer
 */
class CouponData extends \Magento\ImportExport\Model\Export\AbstractEntity
{
    /**
     * Permanent column names
     */
    const COLUMN_MANUFACTURER = 'manufacturer';
    const COLUMN_MODEL = 'model';
    const COLUMN_PROD_IDS = 'product_ids';

    /**
     * Permanent entity columns
     *
     * @var string[]
     */
    protected $_permanentAttributes = [
        self::COLUMN_MANUFACTURER,
        self::COLUMN_MODEL,
        self::COLUMN_PROD_IDS,
    ];

    public function export()
    {
        // TODO: Implement export() method.
    }

    public function exportItem($item)
    {
        // TODO: Implement exportItem() method.
    }

    public function getEntityTypeCode()
    {
        return  'manufacturer';
    }

    protected function _getHeaderColumns()
    {
        return $this->_permanentAttributes;
    }

    protected function _getEntityCollection()
    {
        // TODO: Implement _getEntityCollection() method.
    }
}