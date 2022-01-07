<?php
 
namespace Bluethink\Faq\Api\Data;
 
use Magento\Framework\Api\SearchResultsInterface;
 
interface FaqSearchResultInterface extends SearchResultsInterface
{
    /**
     * @return \Bluethink\Faq\Api\Data\FaqInterface[]
     */
    public function getItems();
 
    /**
     * @param \Bluethink\Faq\Api\Data\FaqInterface[] $items
     * @return void
     */
    public function setItems(array $items);
}