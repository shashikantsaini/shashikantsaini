<?php

namespace  Bluethink\PartialCancelOrder\Block\Adminhtml\Order\Edit\Tab;

class Status extends \Magento\Backend\Block\Widget\Grid\Extended
{
    protected $productFactory;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Helper\Data $backendHelper,
        \Magento\Catalog\Model\ProductFactory $productFactory,
        \Magento\Framework\Registry $coreRegistry,
        array $data = []
    ) {
        $this->productFactory = $productFactory;
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
        // $this->setDefaultSort('entity_id');
        // $this->setUseAjax(false);
    }

    /**
     * @return Grid
     */
    protected function _prepareCollection()
    {
        $collection = $this->productFactory->create()->getCollection()->addAttributeToSelect("*");
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * @return Extended
     */
    protected function _prepareColumns()
    {
        $this->addColumn(
            'entity_id',
            [
                'header' => __('Product Id'),
                'sortable' => true,
                'index' => 'entity_id',
                'header_css_class' => 'col-id',
                'column_css_class' => 'col-id'
            ]
        );
        $this->addColumn(
            'name',
            [
                'header' => __('Product Name'),
                'index' => 'name'
            ]
        );
        $this->addColumn(
            'sku',
            [
                'header' => __('Sku'),
                'index' => 'sku'
            ]
        );

        return parent::_prepareColumns();
    }

}



// <?php
// namespace Bluethink\PartialCancelOrder\Block\Adminhtml\Order\Edit\Tab;

// class Status extends \Magento\Backend\Block\Widget\Form\Generic
// {
//     public function __construct(
//         \Magento\Backend\Block\Template\Context $context,
//         \Magento\Framework\Registry $registry,
//         \Magento\Framework\Data\FormFactory $formFactory,
//         array $data = []
//     ) {
//         parent::__construct($context, $registry, $formFactory, $data);
//     }

//     protected function _prepareForm()
//     {
       
//         $model = $this->_coreRegistry->registry('order_data');

//         $form = $this->_formFactory->create();

//         $form->setHtmlIdPrefix('blogmanager_');

//         $fieldset = $form->addFieldset(
//             'base_fieldset',
//             ['legend' => __('Edit Blog'), 'class' => 'fieldset-wide']
//         );

//         $fieldset->addField(
//             'status',
//             'select',
//             [
//                 'name' => 'status',
//                 'label' => __('Status'),
//                 'options' => [0=>__('Disabled'), 1=>__('Enabled')],
//                 'id' => 'status',
//                 'title' => __('Status'),
//                 'class' => 'required-entry',
//                 'required' => true,
//             ]
//         );

//         $form->setValues($model->getData());
//         $this->setForm($form);

//         return parent::_prepareForm();
//     }
// }