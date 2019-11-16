<?php
namespace Barefoot\ProductContributors\Controller\Adminhtml\Product;

use Magento\Backend\App\Action;
use Magento\TestFramework\ErrorLog\Logger;

class Products extends \Magento\Backend\App\Action
{
    /**
     * @var \Magento\Framework\View\Result\LayoutFactory
     */
    protected $_resultLayoutFactory;
    /**
     * @param \Magento\Framework\View\Result\LayoutFactory $resultLayoutFactory
     * @param Action\Context $context
     */
    public function __construct(
        Action\Context $context,
        \Magento\Framework\View\Result\LayoutFactory $resultLayoutFactory
    ) {
        parent::__construct($context);
        $this->_resultLayoutFactory = $resultLayoutFactory;
    }
    /**
     * {@inheritdoc}
     */
    protected function _isAllowed()
    {
        return true;
    }
    /**
     * Save action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $resultLayout = $this->_resultLayoutFactory->create();
		$block = $resultLayout->getLayout()
				->createBlock('Magento\Framework\View\Element\Template')
				->setTemplate('Barefoot_ProductContributors::product/products.phtml')
				->toHtml();
		echo $block;
        $resultLayout->getLayout()->getBlock('productcontributors.product.edit.tab.productgrid')
                     ->setInProducts($this->getRequest()->getPost('deal_products', null));
        return $resultLayout;
    }
}
