<?php //declare(strict_types=1);

namespace Bluethink\PartialCancelOrder\Plugin\Block\Widget\Button;

use Magento\Sales\Block\Adminhtml\Order\Create;
use Magento\Framework\View\Element\AbstractBlock;
use Magento\Backend\Block\Widget\Button\ButtonList;
use Magento\Backend\Block\Widget\Button\Toolbar as ToolbarContext;
use Magento\Framework\UrlInterface;
use Magento\Framework\Registry ;

class ToolbarPlugin
{
    public function __construct(
        UrlInterface $urlBuilder,
        Registry $registry
    ) 
    {
        $this->urlBuilder = $urlBuilder;
        $this->_coreRegistry = $registry;
    }

    /**
     * @param ToolbarContext $toolbar
     * @param AbstractBlock $context
     * @param ButtonList $buttonList
     * @return array
     */
    public function beforePushButtons(
        ToolbarContext $toolbar,
        AbstractBlock $context,
        ButtonList $buttonList
    ): array {
        $order = false;
        $nameInLayout = $context->getNameInLayout();
        if ('sales_order_edit' == $nameInLayout) {
            $order = $context->getOrder();
        }
        
        if ($order) 
        {
            $itemToShip = 0;
            $itemInvoiced = 0;
            foreach ($order->getAllItems() as $item) 
            {
                $itemInvoiced += $item->getQtyInvoiced();
            }
            if($itemInvoiced)
            {
                $url = $this->urlBuilder->getUrl('partialcancelorder/order/view',['order_id' => $order->getEntityId()]); // add your full url
                $buttonList->add(
                    'partial_cancel_order',
                    [
                        'label' => __('Partial Cancel Order'),
                        'on_click' => sprintf("location.href = '%s';", $url),
                        'class' => 'secondary',
                        'id' => 'partial_cancel_order'
                    ]
                );
            }
        }
        $result = [$context, $buttonList];
        return $result;        
    }
}