<?php

namespace Barefoot\ProductContributors\Controller\Adminhtml\Product;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
/**
 * index Action for locator
 */
class Import extends \Magento\Backend\App\Action
{
  /**
   * result page Factory
   *
   * @var Magento\Framework\View\Result\PageFactory
   */
    protected $resultPageFactory;

  /**
   * @param \Magento\Backend\Block\Template\Context 
   * @param Magento\Framework\View\Result\PageFactory
   */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    ) 
    {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }
  
  /**
   * {@inheritdoc}
   */
    protected function _isAllowed()
    {
        return true;
    }
  
  /**
   * Execute method for locator index action
   *
   * @return $resultPage
   */ 
    public function execute()
    {
        /**
         * render The admin grid page
         */            
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Barefoot_ProductContributors::product_contributor');
        $resultPage->addBreadcrumb(__('Import Product Contributors'), __('Import Product Contributors'));
        $resultPage->addBreadcrumb(__('Import Locator'), __('Import Product Contributors'));
        $resultPage->getConfig()->getTitle()->prepend(__('Import Product Contributors'));
        return $resultPage;
    }
}
