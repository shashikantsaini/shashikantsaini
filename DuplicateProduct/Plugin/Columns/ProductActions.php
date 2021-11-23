<?php
namespace Bluethink\DuplicateProduct\Plugin\Columns;

class ProductActions
{
    protected $context;

    protected $urlBuilder;

    public function __construct(
        \Magento\Framework\View\Element\UiComponent\ContextInterface $context,
        \Magento\Framework\UrlInterface $urlBuilder
    )
    {
        $this->context = $context;
        $this->urlBuilder = $urlBuilder;
    }

    public function afterPrepareDataSource(\Magento\Catalog\Ui\Component\Listing\Columns\ProductActions $subject,array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            $storeId = $this->context->getFilterParam('store_id');
            foreach ($dataSource['data']['items'] as &$item) {
                $item[$subject->getData('name')]['duplicate'] = [
                    'href' => $this->urlBuilder->getUrl(
                        'duplicate/product/duplicate',
                        ['id' => $item['entity_id'], 'store' => $storeId]
                    ),
                    'label' => __('Duplicate'),
                    'hidden' => false,
                ];
            }
        }
        return $dataSource;
    }
}