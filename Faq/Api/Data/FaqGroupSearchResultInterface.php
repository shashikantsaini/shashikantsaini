<?php
 
namespace Bluethink\Faq\Api\Data;
 
use Magento\Framework\Api\SearchResultsInterface;
 
interface FaqGroupSearchResultInterface extends SearchResultsInterface
{
    /**
     * @return \Bluethink\Faq\Api\Data\FaqGroupInterface[]
     */
    public function getItems();
 
    /**
     * @param \Bluethink\Faq\Api\Data\FaqGroupInterface[] $items
     * @return void
     */
    public function setItems(array $items);
}