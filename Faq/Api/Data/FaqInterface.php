<?php
 
namespace Bluethink\Faq\Api\Data;
 
use Magento\Framework\Api\ExtensibleDataInterface;
 
interface FaqInterface extends ExtensibleDataInterface
{
    /**
     * Faq Id.
     */
    const FAQ_ID = 'faq_id';

    /**
     * Title.
     */
    const TITLE = 'title';

    /**
     * Content.
     */
    const CONTENT = 'content';

    /**
     * Group.
     */
    const GROUP = 'group';

    /**
     * Sort Order.
     */
    const SORT_ORDER = 'sortorder';

    /**
     * Status.
     */
    const STATUS = 'status';
    
    /**
     * @return int
     */
    public function getFaqId();
 
    /**
     * @param int $faqId
     * @return void
     */
    public function setFaqId($faqId);
 
    /**
     * @return string
     */
    public function getTitle();
 
    /**
     * @param string $title
     * @return void
     */
    public function setTitle($title);

    /**
     * @return string
     */
    public function getContent();
 
    /**
     * @param string $content
     * @return void
     */
    public function setContent($content);

    /**
     * @return string
     */
    public function getGroup();
 
    /**
     * @param string $group
     * @return void
     */
    public function setGroup($group);

    /**
     * @return string
     */
    public function getSortOrder();
 
    /**
     * @param string $sortOrder
     * @return void
     */
    public function setSortOrder($sortOrder);

    /**
     * @return string
     */
    public function getStatus();
 
    /**
     * @param string $status
     * @return void
     */
    public function setStatus($status);

}