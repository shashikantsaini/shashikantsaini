<?php
 
namespace Bluethink\Faq\Api;
 
use Magento\Framework\Api\SearchCriteriaInterface;
use Bluethink\Faq\Api\Data\FaqGroupInterface;
 
interface FaqGroupRepositoryInterface
{
    /**
     * @param int $id
     * @return \Bluethink\Faq\Api\Data\FaqGroupInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById($id);
 
    /**
     * @param \Bluethink\Faq\Api\Data\FaqGroupInterface $faqGroup
     * @return \Bluethink\Faq\Api\Data\FaqGroupInterface
     */
    public function save(FaqGroupInterface $faqGroup);
 
    /**
     * @param \Bluethink\Faq\Api\Data\FaqGroupInterface $faqGroup
     * @return void
     */
    public function delete(FaqGroupInterface $faqGroup);
 
    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Bluethink\Faq\Api\Data\FaqGroupSearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria);
}