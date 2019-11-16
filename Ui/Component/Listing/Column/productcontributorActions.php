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
class productcontributorActions extends Column
{
    /** Url path */
    const SLIDE_URL_PATH_EDIT = 'barefoot/product/edit';
    const SLIDE_URL_PATH_DELETE = 'barefoot/product/delete';

    /** @var UrlInterface */
    public $urlBuilder;

    /**
     * @param ContextInterface
     * @param UiComponentFactory
     * @param UrlInterface
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = []
    ) {
        $this->urlBuilder = $urlBuilder;
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
                $name = $this->getData('name');
                if (isset($item['store_id'])) {
                    $item[$name]['edit'] = [
                        'href' => $this->urlBuilder->getUrl(
                            self::SLIDE_URL_PATH_EDIT,
                            ['id' => $item['cav']]
                        ),
                        'label' => __('Edit')
                    ];
                    $item[$name]['delete'] = [
                        'href' => $this->urlBuilder->getUrl(
                            self::SLIDE_URL_PATH_DELETE,
                            ['id' => $item['cav']]
                        ),
                        'label' => __('Delete'),
                        'confirm' => [
                            'title' => __('Delete ${ $.$data.entity_id }'),
                            'message' => __('Are you sure you wan\'t to delete a <b> contributor for ${ $.$data.entity_id } Product </b> ?')
                        ]
                    ];
                }
            }
        }
        return $dataSource;
    }
}
