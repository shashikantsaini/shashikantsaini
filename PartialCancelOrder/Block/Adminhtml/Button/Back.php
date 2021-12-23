<?php 

namespace Bluethink\PartialCancelOrder\Block\Adminhtml\Button;

use Magento\Backend\Model\UrlInterface;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class Back implements ButtonProviderInterface 
{

  /** @var UrlInterface */
  protected $urlInterface;

  public function __construct(
    UrlInterface $urlInterface
  )
  {
    $this->urlInterface = $urlInterface;
  }
  
    public function getButtonData()
    {
        return [
            'label' => __('Back'),
            'on_click' => sprintf("location.href = '%s';", $this->getBackUrl()),
            'class' => 'back',
            'sort_order' => 10
        ];
    }
    
    public function getBackUrl()
    {
        return $this->urlInterface->getUrl('*/*/');
    }
}