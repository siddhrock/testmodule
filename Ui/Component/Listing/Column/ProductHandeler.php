<?php

namespace Barefoot\ProductContributors\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\UrlInterface;

/**
 * Class storeLocatorActions
 */
//@codingStandardsIgnoreLine
class ProductHandeler extends Column
{
    /**
     * System store
     *
     * @var SystemStore
     */
    protected $systemStore;

    /**
     * Store manager
     *
     * @var StoreManager
     */
    protected $storeManager;

    /**
     * @var string
     */
    protected $storeKey;

    /**
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param SystemStore $systemStore
     * @param array $components
     * @param array $data
     * @param string $storeKey
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        array $components = [],
        array $data = [],
        $storeKey = 'store_id'
    ) {        
        $this->storeKey = $storeKey;
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
            foreach ($dataSource['data']['items'] as & $item) {
                $item[$this->getData('name')] = $this->prepareItem($item);
            }
        }
        return $dataSource;
    }

    /**
     * Get data
     *
     * @param array $item
     * @return string
     */
    protected function prepareItem(array $item)
    {
        $productHandeler = '';
        if (!empty($item)) {
            if ($item["contributor_type_handle"] == 'written_by') {
                $productHandeler = "Written By";
            }
            if ($item["contributor_type_handle"] == 'compiled_by') {
                $productHandeler = "Compiled By";
            }
            if ($item["contributor_type_handle"] == 'retold_by') {
                $productHandeler = "Retold By";
            }
            if ($item["contributor_type_handle"] == 'illustrated_by') {
                $productHandeler = "Illustrated By";
            }
            if ($item["contributor_type_handle"] == 'narrated_by') {
                $productHandeler = "Narrated By";
            }
            if ($item["contributor_type_handle"] == 'sung_by') {
                $productHandeler = "Sung By";
            }
            if ($item["contributor_type_handle"] == 'produced_by') {
                $productHandeler = "Produced By";
            }
        }
        return $productHandeler;
    }
}
