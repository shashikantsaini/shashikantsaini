<?php

namespace Bluethink\Quote\Ui\Component\Listing\Grid\Column;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\UrlInterface;

class Action extends Column
{
    /** Url path */
    const UPDATE_QUOTE_URL = 'quote/quote/update';
    /** @var UrlInterface */
    protected $_urlBuilder;

    /**
     * @var string
     */
    private $_editUrl;

    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = [],
        $updateUrl = self::UPDATE_QUOTE_URL
    ) 
    {
        $this->_urlBuilder = $urlBuilder;
        $this->_updateUrl = $updateUrl;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }


    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                $name = $this->getData('name');
                if (isset($item['entity_id'])) {
                    $item[$name]['update'] = [
                        'href' => $this->_urlBuilder->getUrl(
                            $this->_updateUrl, 
                            ['quote_id' => $item['entity_id']]
                        ),
                        'label' => __('Update'),
                    ];
                }
            }
        }

        return $dataSource;
    }
}