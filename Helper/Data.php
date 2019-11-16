<?php
namespace Barefoot\ProductContributors\Helper;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * @var \Magento\Framework\ObjectManagerInterface
     */	
    protected $_objectManager;

    /**
     * @var \Magento\Framework\Registry
     */   
    protected $_coreRegistry;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */    
    protected $_storeManager;

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface 
     */
	protected $scopeConfig;

    /**
     * @var \Magento\Backend\Helper\Js 
     */
    protected $_jsHelper;

    /**
     * @var \Mageants\DealOfDay\Model\ResourceModel\Deal\CollectionFactory 
     */    
    protected $_Deal;

    /**
     * @var \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory
     */
	protected $_productloader;

    /**
     * @var \Magento\Backend\Helper\Data
     */
	protected $_backendUrl;
	
    /**
     * @var \Magento\CatalogInventory\Model\Stock\StockItemRepository
     */	
    protected $_stockItemRepository;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\ObjectManagerInterface $objectManager
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Backend\Helper\Js $jsHelper
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Backend\Helper\Data $backendHelper
     * @param \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory
     * @param \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $_productloader
     * @param \Magento\CatalogInventory\Model\Stock\StockItemRepository $stockItemRepository
     * @param array $data
     */ 

	public function __construct(
		\Magento\Framework\ObjectManagerInterface $objectManager,
		\Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Backend\Helper\Js $jsHelper,
		\Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
		\Magento\Framework\Registry $registry,
		\Magento\Catalog\Model\ProductFactory $_productloader,
        \Magento\CatalogInventory\Model\Stock\StockItemRepository $stockItemRepository,
        \Barefoot\ProductContributors\Model\Config\Source\StoreList $storeList,
        \Barefoot\ProductContributors\Model\Contributor $contributorModel,
		\Magento\Backend\Model\UrlInterface $backendUrl
    ){
        $this->_objectManager = $objectManager;
        $this->_storeManager = $storeManager;
        $this->contributorModel = $contributorModel;
        $this->_jsHelper = $jsHelper;
		$this->scopeConfig = $scopeConfig;
		$this->_coreRegistry = $registry;
		$this->_productloader = $_productloader;
        $this->_allStoreList=$storeList;
        $this->_stockItemRepository = $stockItemRepository;
		$this->_backendUrl = $backendUrl;
    }
	
	public function getProductGridUrl()
	{
		return $this->_backendUrl->getUrl('barefoot/product/products', ['_current' => true]);
	}  

    public function getStoreList()
    {
     return $this->_allStoreList->toOptionArray();
    }

    public function getContributorTypeHandle()
    {
     $handel = array();
        $handel = ["" => " ","written_by" => "Written By", "compiled_by" => "Compiled By", "retold_by" => "Retold By", "illustrated_by" => "Illustrated By", "narrated_by" => "Narrated By", "sung_by" => "Sung By", "produced_by" => "Produced By"];
        return $handel;

    }

    public function getContributor()
    {
        $contributorCollection = $this->contributorModel->getCollection()->getData();
        $contributor = array();
        $contributor[""] = "";
        if ($contributorCollection) {
            foreach ($contributorCollection as $contributorData) {
                $contributor[$contributorData['contributor_id']] = $contributorData['first_name']." ".$contributorData['last_name']; 
            }
        }
    return $contributor;
    }

}
 
