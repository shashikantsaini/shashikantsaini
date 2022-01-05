<?php

namespace Bluethink\Faq\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Backend\Model\UrlInterface;

class Icon extends Column
{
    const ALT_FIELD = 'name';

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var \Magento\Catalog\Helper\Image
     */
    protected $imageHelper;

    /**
     * @param ContextInterface              $context
     * @param UiComponentFactory            $uiComponentFactory
     * @param StoreManagerInterface         $storeManager
     * @param \Magento\Catalog\Helper\Image $imageHelper
     * @param UrlInterface                  $backendUrl
     * @param array                         $components
     * @param array                         $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        StoreManagerInterface $storeManager,
        \Magento\Catalog\Helper\Image $imageHelper,
        UrlInterface $backendUrl,
        array $components = [],
        array $data = []
    ) {
        $this->storeManager = $storeManager;
        $this->imageHelper = $imageHelper;
        $this->_backendUrl = $backendUrl;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }
    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            $fieldName = $this->getData('name');
            foreach ($dataSource['data']['items'] as &$item) {
                $url = '';
                if (isset($item[$fieldName])) {
                    if ($item[$fieldName] != '') {
                        $url = $this->storeManager->getStore()->getBaseUrl(
                            \Magento\Framework\UrlInterface::URL_TYPE_MEDIA
                        ) . "faq/tmp/icon/" . $item[$fieldName];
                    } else {
                        $url = $this->imageHelper->getDefaultPlaceholderUrl('small_image');
                    }
                } else {
                    $url = $this->imageHelper->getDefaultPlaceholderUrl('small_image');
                }
                $item[$fieldName . '_src'] = $url;
                $item[$fieldName . '_alt'] = $this->getAlt($item) ?: '';
                $item[$fieldName . '_orig_src'] = $url;
                $item[$fieldName . '_link'] = $this->_backendUrl->getUrl(
                    "adminfaq/faqgroup/edit",
                    ['faqgroup_id' => $item['faqgroup_id']]
                );
            }
        }
        return $dataSource;
    }
    protected function getAlt($row)
    {
        $altField = $this->getData('config/altField') ?: self::ALT_FIELD;
        return isset($row[$altField]) ? $row[$altField] : null;
    }
}