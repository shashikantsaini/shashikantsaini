<?php
namespace Bluethink\PartialCancelOrder\Block\Adminhtml\Order\Edit;

class Tabs extends \Magento\Backend\Block\Widget\Tabs
{
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Json\EncoderInterface $jsonEncoder,
        \Magento\Backend\Model\Auth\Session $authSession,
        \Magento\Framework\Registry $coreRegistry,
        array $data = []
    ) {
        $this->_coreRegistry = $coreRegistry;
        parent::__construct($context, $jsonEncoder, $authSession, $data);
    }

    protected function _construct()
    {
        parent::_construct();
        $this->setId('order_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('Cancel Detail'));
    }

    protected function _prepareLayout()
    {
        $this->addTab(
            'main',
            [
                'label' => __('Reason For Cancel'),
                'content' => $this->getLayout()->createBlock(
                    'Bluethink\PartialCancelOrder\Block\Adminhtml\Order\Edit\Tab\Main'
                )->toHtml(),
                'active' => true
            ]
        );

        $this->addTab(
            'status',
            [
                'label' => __('Select Items'),
                'content' => $this->getLayout()->createBlock(
                    'Bluethink\PartialCancelOrder\Block\Adminhtml\Order\Edit\Tab\Status'
                )->toHtml(),
            ]
        );

        return parent::_prepareLayout();
    }
}