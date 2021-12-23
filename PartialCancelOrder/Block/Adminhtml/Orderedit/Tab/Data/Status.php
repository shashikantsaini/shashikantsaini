<?php

namespace  Bluethink\PartialCancelOrder\Block\Adminhtml\Orderedit\Tab\Data;

class Status extends \Magento\Backend\Block\Widget\Grid\Extended
{
    protected $productFactory;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Helper\Data $backendHelper,
        \Bluethink\PartialCancelOrder\Model\PartialCancelOrderFactory $partialCancelOrderFactory,
        \Magento\Framework\Registry $coreRegistry,
        array $data = []
    ) {
        $this->partialCancelOrderFactory = $partialCancelOrderFactory;
        $this->_coreRegistry = $coreRegistry;
        parent::__construct($context, $backendHelper, $data);
    }

    /**
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('hello_tab_grid');
        $this->setDefaultSort('entity_id');
        $this->setUseAjax(false);
    }

    /**
     * @return Grid
     */
    protected function _prepareCollection()
    {
        $orderId = $this->_coreRegistry->registry('current_order')->getEntityId();
        $collection = $this->partialCancelOrderFactory->create()->getCollection()->addFieldToFilter('order_id',$orderId);
        // ->getItemsByColumnValue('order_id',$orderId);
        // echo "<pre>";
        // print_r(get_class_methods($collection));
        // die("Shashi");
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * @return Extended
     */
    protected function _prepareColumns()
    {
        $this->addColumn(
            'id',
            [
                'header' => __('Id'),
                'sortable' => true,
                'index' => 'entity_id',
                'header_css_class' => 'col-id',
                'column_css_class' => 'col-id'
            ]
        );
        $this->addColumn(
            'created_at',
            [
                'header' => __('Created At'),
                'index' => 'created_at'
            ]
        );
        $this->addColumn(
            'reason_label',
            [
                'header' => __('Reason'),
                'index' => 'reason_label'
            ]
        );
        $this->addColumn(
            'action', [
                'header' => __('Action'),
                'type' => 'action',
                'getter' => 'getId',
                'actions' => [
                    [
                        'caption' => __('View'),
                        'url' => ['base' => 'partialcancelorder/order_partialcancel/view'],
                        'field' => 'partialcancelorder_id',
                    ],
                ],
                'filter' => false,
                'sortable' => false,
                'index' => 'stores',
                'header_css_class' => 'col-action',
                'column_css_class' => 'col-action',
            ]
        );

        return parent::_prepareColumns();
    }

}