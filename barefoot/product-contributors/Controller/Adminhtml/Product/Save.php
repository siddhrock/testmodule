<?php

namespace Barefoot\ProductContributors\Controller\Adminhtml\Product;

use Magento\Framework\Controller\ResultFactory;

class Save extends \Magento\Backend\App\Action
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
    $params=$this->getRequest()->getPostValue();
    if (array_key_exists('cav', $params)) {
        $cav_id = $params['cav'];
        $data = $this->_manageproductFactory->load($cav_id)->getData();
    }
     if ($params) {
      if (array_key_exists('store_id', $params)) {
        $data['store_id'] = $params['store_id'][0];
      }
      if (array_key_exists('product_id', $params)) {
        $data['entity_id'] = $params['product_id'];
      }
      if (array_key_exists('contributor', $params)) {
        $data['contributor_id'] = $params['contributor'];
      }
      if (array_key_exists('contributor_type_handle', $params)) {
        $data['contributor_type_handle'] = $params['contributor_type_handle'];
      }
       
       if ($data) {
         try{
          $this->_manageproductFactory->setData($data);
          $id = $this->_manageproductFactory->Save()->getId();
          $this->messageManager->addSuccess("Product Contributor Saved Successfully");
          if($this->getRequest()->getParam('back')){
            $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
            return $resultRedirect->setPath('*/*/edit', ['id' => $id, '_current' => true]);
            $this->_redirect($this->_redirect->getRefererUrl());
            return;
          }

         }
         catch(Exception $e){
           $this->messageManager->addError(__($e->getMessage()));   
         }
       }
     }
     $this->_redirect('barefoot/product/index');
     return;
   }
}
