<?php
 
namespace Bluethink\Faq\Api;
 
use Magento\Framework\Api\SearchCriteriaInterface;
use Bluethink\Faq\Api\Data\FaqInterface;
 
interface FaqRepositoryInterface
{
    /**
     * @param int $id
     * @return \Bluethink\Faq\Api\Data\FaqInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById($id);
 
    /**
     * @param \Bluethink\Faq\Api\Data\FaqInterface $faq
     * @return \Bluethink\Faq\Api\Data\FaqInterface
     */
    public function save(FaqInterface $faq);
 
    /**
     * @param \Bluethink\Faq\Api\Data\FaqInterface $faq
     * @return void
     */
    public function delete(FaqInterface $faq);
 
    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Bluethink\Faq\Api\Data\FaqSearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria);
}