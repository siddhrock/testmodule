<?php

namespace Barefoot\ProductContributors\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\UrlInterface;
use Barefoot\ProductContributors\Model\Contributor as ContributorModel;

/**
 * Class storeLocatorActions
 */
//@codingStandardsIgnoreLine
class Contributor extends Column
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
        ContributorModel $contributorModel,
        array $components = [],
        array $data = [],
        $storeKey = 'store_id'
    ) {
        $this->contributorModel = $contributorModel;
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
        $contributor = '';
        $contributor_id = 0;
        if (!empty($item)) {
            $contributor_id =$item["contributor_id"];
            $contributorCollection = $this->contributorModel->load($contributor_id);    
            $contributor = $contributorCollection['first_name']." ".$contributorCollection['last_name'];
        }
        return $contributor;
    }
}
