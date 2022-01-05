<?php
 
namespace Bluethink\Faq\Model;
 
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Exception\NoSuchEntityException;
use Bluethink\Faq\Api\Data\FaqInterface;
use Bluethink\Faq\Api\Data\FaqSearchResultInterface;
use Bluethink\Faq\Api\Data\FaqSearchResultInterfaceFactory;
use Bluethink\Faq\Api\FaqRepositoryInterface;
use Bluethink\Faq\Model\ResourceModel\Faq\CollectionFactory as FaqCollectionFactory;
use Bluethink\Faq\Model\ResourceModel\Faq\Collection;
 
class FaqRepository implements FaqRepositoryInterface
{
    /**
     * @var FaqFactory
     */
    private $faqFactory;
 
    /**
     * @var FaqCollectionFactory
     */
    private $faqCollectionFactory;
 
    /**
     * @var FaqSearchResultInterfaceFactory
     */
    private $searchResultFactory;
 
    public function __construct(
        FaqFactory $faqFactory,
        FaqCollectionFactory $faqCollectionFactory,
        FaqSearchResultInterfaceFactory $faqSearchResultInterfaceFactory
    ) {
        $this->faqFactory = $faqFactory;
        $this->faqCollectionFactory = $faqCollectionFactory;
        $this->searchResultFactory = $faqSearchResultInterfaceFactory;
    }
 
    public function getById($id)
    {
        $faq = $this->faqFactory->create();
        $faq->getResource()->load($faq, $id);
        if (!$faq->getId()) {
            throw new NoSuchEntityException(__('Unable to find Faq with ID "%1"', $id));
        }
        return $faq;
    }
    
    public function save(FaqInterface $faq)
    {
        $faq->getResource()->save($faq);
        return $faq;
    }
    
    public function delete(FaqInterface $faq)
    {
        $faq->getResource()->delete($faq);
    }
 
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        $collection = $this->faqCollectionFactory->create();
 
        $this->addFiltersToCollection($searchCriteria, $collection);
        $this->addSortOrdersToCollection($searchCriteria, $collection);
        $this->addPagingToCollection($searchCriteria, $collection);
 
        $collection->load();
 
        return $this->buildSearchResult($searchCriteria, $collection);
    }
 
    private function addFiltersToCollection(SearchCriteriaInterface $searchCriteria, Collection $collection)
    {
        foreach ($searchCriteria->getFilterGroups() as $filterGroup) {
            $fields = $conditions = [];
            foreach ($filterGroup->getFilters() as $filter) {
                $fields[] = $filter->getField();
                $conditions[] = [$filter->getConditionType() => $filter->getValue()];
            }
            $collection->addFieldToFilter($fields, $conditions);
        }
    }
 
    private function addSortOrdersToCollection(SearchCriteriaInterface $searchCriteria, Collection $collection)
    {
        foreach ((array) $searchCriteria->getSortOrders() as $sortOrder) {
            $direction = $sortOrder->getDirection() == SortOrder::SORT_ASC ? 'asc' : 'desc';
            $collection->addOrder($sortOrder->getField(), $direction);
        }
    }
 
    private function addPagingToCollection(SearchCriteriaInterface $searchCriteria, Collection $collection)
    {
        $collection->setPageSize($searchCriteria->getPageSize());
        $collection->setCurPage($searchCriteria->getCurrentPage());
    }
 
    private function buildSearchResult(SearchCriteriaInterface $searchCriteria, Collection $collection)
    {
        $searchResults = $this->searchResultFactory->create();
 
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());
 
        return $searchResults;
    }
}