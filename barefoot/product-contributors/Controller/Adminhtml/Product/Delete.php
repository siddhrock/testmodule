<?php

namespace Barefoot\ProductContributors\Controller\Adminhtml\Product;

use Magento\Framework\Controller\ResultFactory;

class Delete extends \Magento\Backend\App\Action
{ 

 public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Barefoot\ProductContributors\Model\Manageproduct $manageproductFactory
    )     {
        parent::__construct($context);
        $this->_manageproductFactory = $manageproductFactory;
    }

    /**
     * @return void
     */

   public function execute()
   {
      $productcontributorId = $this->getRequest()->getParam('id');  
      if ($productcontributorId) {        
        try{
          $this->_manageproductFactory->load($productcontributorId)->delete();
          $this->messageManager->addSuccess("Product Contributor Deleted Successfully");
        }
        catch(Exception $e){
           $this->messageManager->addError(__($e->getMessage()));   
         }
      }
      $this->_redirect('barefoot/product/index');
      return;
   }
}
