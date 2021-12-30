<?php
namespace Bluethink\Faq\Ui\Component\Listing\Column;

use Magento\Framework\Data\OptionSourceInterface;
use Bluethink\Faq\Model\ResourceModel\FaqGroup\CollectionFactory;

class FaqGroup implements OptionSourceInterface
{
    /**
     * @var CollectionFactory
     */
    private $groupCollection;

    /**
     * FaqGroup constructor.
     *
     * @param CollectionFactory $groupCollection
     */
    public function __construct(
        CollectionFactory $groupCollection
    ) {
        $this->groupCollection = $groupCollection;
    }

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        $groupArr = [];
        $groups = $this->groupCollection->create();

        foreach ($groups as $group) {
            $groupArr[] = ['value' => $group->getFaqroupId(), 'label' => __($group->getGroupname())];
        }
        
        return $groupArr;
    }
}
