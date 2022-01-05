<?php
 
namespace Bluethink\Faq\Api\Data;
 
use Magento\Framework\Api\ExtensibleDataInterface;
 
interface FaqGroupInterface extends ExtensibleDataInterface
{
    /**
     * Faqgroup Id.
     */
    const FAQGROUP_ID = 'faqgroup_id';

    /**
     * Groupname.
     */
    const GROUPNAME = 'groupname';

    /**
     * Icon.
     */
    const ICON = 'icon';

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
    public function getFaqgroupId();
 
    /**
     * @param int $faqGroupId
     * @return void
     */
    public function setFaqgroupId($faqGroupId);
 
    /**
     * @return string
     */
    public function getGroupname();
 
    /**
     * @param string $groupName
     * @return void
     */
    public function setGroupname($groupName);

    /**
     * @return string
     */
    public function getIcon();
 
    /**
     * @param string $icon
     * @return void
     */
    public function setIcon($icon);

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