<?php
 
namespace Bluethink\Faq\Model;
 
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Exception\NoSuchEntityException;
use Bluethink\Faq\Api\Data\FaqGroupInterface;
use Bluethink\Faq\Api\Data\FaqGroupSearchResultInterface;
use Bluethink\Faq\Api\Data\FaqGroupSearchResultInterfaceFactory;
use Bluethink\Faq\Api\FaqGroupRepositoryInterface;
use Bluethink\Faq\Model\ResourceModel\FaqGroup\CollectionFactory as FaqGroupCollectionFactory;
use Bluethink\Faq\Model\ResourceModel\FaqGroup\Collection;
 
class FaqGroupRepository implements FaqGroupRepositoryInterface
{
    /**
     * @var FaqGroupFactory
     */
    private $faqGroupFactory;
 
    /**
     * @var FaqGroupCollectionFactory
     */
    private $faqGroupCollectionFactory;
 
    /**
     * @var FaqGroupSearchResultInterfaceFactory
     */
    private $searchResultFactory;
 
    public function __construct(
        FaqGroupFactory $faqGroupFactory,
        FaqGroupCollectionFactory $faqGroupCollectionFactory,
        FaqGroupSearchResultInterfaceFactory $faqGroupSearchResultInterfaceFactory
    ) {
        $this->faqGroupFactory = $faqGroupFactory;
        $this->faqGroupCollectionFactory = $faqGroupCollectionFactory;
        $this->searchResultFactory = $faqGroupSearchResultInterfaceFactory;
    }
 
    public function getById($id)
    {
        $faqGroup = $this->faqGroupFactory->create();
        $faqGroup->getResource()->load($faqGroup, $id);
        if (!$faqGroup->getId()) {
            throw new NoSuchEntityException(__('Unable to find FaqGroup with ID "%1"', $id));
        }
        return $faqGroup;
    }
    
    public function save(FaqGroupInterface $faqGroup)
    {
        $faqGroup->getResource()->save($faqGroup);
        return $faqGroup;
    }
    
    public function delete(FaqGroupInterface $faqGroup)
    {
        $faqGroup->getResource()->delete($faqGroup);
    }
 
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        $collection = $this->faqGroupCollectionFactory->create();
 
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