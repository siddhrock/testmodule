<?php

namespace Barefoot\ProductContributors\Block\Adminhtml\Product\Edit\Tab;

use Magento\Backend\Block\Widget\Grid;
use Magento\Backend\Block\Widget\Grid\Column;
use Magento\Backend\Block\Widget\Grid\Extended;

class Products extends \Magento\Backend\Block\Widget\Grid\Extended
{
 
    /**
     * core registry
     * 
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry = null;

    /**
     * @var \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory 
     */    
    protected $_productFactory;
    protected $productStatus;
    protected $productVisibility;
 
    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Backend\Helper\Data $backendHelper
     * @param \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory
     * @param \Mageants\DealOfDay\Model\DealFactory $dealFactory
     * @param array $data
     */ 
    public function __construct(
    \Magento\Backend\Block\Template\Context $context,
    \Magento\Backend\Helper\Data $backendHelper,
    \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,  
    \Magento\Framework\Registry $coreRegistry,
    \Barefoot\ProductContributors\Model\Manageproduct $manageproduct,
    \Magento\Catalog\Model\Product\Attribute\Source\Status $productStatus,
    \Magento\Catalog\Model\Product\Visibility $productVisibility,	
    array $data = []
    ) {
    $this->_productFactory = $productCollectionFactory;
    $this->manageproduct = $manageproduct;
    $this->_coreRegistry = $coreRegistry;
    $this->productStatus = $productStatus;
    $this->productVisibility = $productVisibility;
    parent::__construct($context, $backendHelper, $data);
    }
 
	/**
     * Block constructor
     *
     * @return void
     */
    protected function _construct()
    {
     	parent::_construct();
		$this->setId('product_grid');
		$this->setDefaultSort('entity_id');
		$this->setDefaultDir('ASC');
		$this->setSaveParametersInSession(true);
		$this->setUseAjax(true);
		if ($this->getRequest()->getParam('id')) {
			$this->setDefaultFilter(array('in_products' => 1));
		}	 
    }
 
    /**
     * add Column Filter To Collection
     */ 
    protected function _addColumnFilterToCollection($column)
    {
     // Set custom filter for in product flag
        if ($column->getId() == 'in_products') {
            $productIds = $this->_getSelectedProducts();
            if (empty($productIds)) {
                $productIds = 0;
            }
            if ($column->getFilter()->getValue()) {
                $this->getCollection()->addFieldToFilter('entity_id', ['in' => $productIds]);
            } else {
                if ($productIds) {
                    $this->getCollection()->addFieldToFilter('entity_id', ['nin' => $productIds]);
                }
            }
        } else {
            parent::_addColumnFilterToCollection($column);
        }
        return $this;
    }
    
    /**
     * prepare collection
     */ 
	protected function _prepareCollection()
	{
		$collection = $this->_productFactory->create()
            ->addAttributeToSelect('*');
        $collection->addAttributeToFilter('status', ['in' => $this->productStatus->getVisibleStatusIds()]);
        $collection->setVisibility($this->productVisibility->getVisibleInSiteIds());    
		$this->setCollection($collection);
		return parent::_prepareCollection();
	}
 
    /**
     * @return $this
     */ 
    protected function _prepareColumns()
    {
      
        $this->addColumn(
            'in_products',
            [
                'header_css_class' => 'a-center',
                'type' => 'radio',
                'html_name' => 'product_id',
                'name' => 'in_products',
                'required'  => true,
                'align' => 'center',
                'index' => 'entity_id',
                'filter_index' => 'main_table.entity_id',
				'values' => $this->_getSelectedProducts(),
            ]
        );
        
        $this->addColumn(
            'entity_id',
            [
                'header' => __('Product ID'),
                'type' => 'number',
                'index' => 'entity_id',
                'header_css_class' => 'col-id',
                'column_css_class' => 'col-id',
            ]
        );
        $this->addColumn(
            'name',
            [
                'header' => __('Name'),
                'html_name' => 'product_name',
                'index' => 'name',
                'class' => 'xxx',
                'width' => '50px',
            ]
        );
        $this->addColumn(
            'sku',
            [
                'header' => __('Sku'),
                'index' => 'sku',
                'class' => 'xxx',
                'width' => '50px',
            ]
        );
        $this->addColumn(
            'price',
            [
                'header' => __('Price'),
                'type' => 'currency',
                'index' => 'price',
                'width' => '50px',
            ]
        );
 
     return parent::_prepareColumns();
    } 
 
    /**
     * @return string
     */
    public function getGridUrl()
    {
        return $this->getUrl('barefoot/product/productsgrid', ['_current' => true]);
    }
    
     /**
      * @return html
      */   
    public function getFormHtml()
	{		
        $html=parent::getFormHtml();
		$html.=$this->setTemplate('Barefoot_ProductContributors::product/product.phtml')->toHtml();
		return $html;
	}
 
    /**
     * return selected products
     * @return array
     */ 
    protected function _getSelectedProducts()
    {
        $products = $this->getRequest()->getParam('deal_products');        
        if (!is_array($products)) {
            $products = array_keys($this->getSelectedProducts());
        }
        return $products;
    }
 
    /**
     * return selected product id of Deal
     * @return array
     */
    public function getSelectedProducts()
    {
		$tm_id = $this->getRequest()->getParam('id');

		if(!isset($tm_id)) {
			$tm_id = 0;
		}
        $imgIds = array();
		// load Deal From DealFactory
		$collection = $this->manageproduct->load($tm_id);
        $proId =  $collection->getEntityId();
        $imgIds[$proId] = array('id'=>$proId);
		return $imgIds;
    }    
}
