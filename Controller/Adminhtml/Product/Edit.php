<?php

namespace Barefoot\ProductContributors\Controller\Adminhtml\Product;

use Magento\Framework\Controller\ResultFactory;

class Edit extends \Magento\Backend\App\Action
{ 

 public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Barefoot\ProductContributors\Model\Manageproduct $manageproductFactory,
        \Magento\Catalog\Model\Product $productModel,
        \Magento\Framework\Registry $coreRegistry
    )     {
        parent::__construct($context);
        $this->manageproductFactory = $manageproductFactory;
        $this->productModel = $productModel;
        $this->_coreRegistry = $coreRegistry;
    }
/**
     * @return void
     */
   public function execute()
   {
      	$contributorId = $this->getRequest()->getParam('id');
      	$resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
      	$title =  __('Add Contributor');
      	$resultPage->getConfig()->getTitle()->prepend($title);
     	$model = $this->manageproductFactory;

	    if ($contributorId) {
	        $model->load($contributorId);
	        if (!$model->getId()) {
	            $this->messageManager->addError(__('This news no longer exists.'));
	            $this->_redirect('*/*/');
	            return;
	        }
	    }

        // Restore previously entered form data from session
        $data = $this->_session->getNewsData(true);
        $data = $model->getData();
       /* echo "<pre>";
        print_r($data);
        exit();*/
        if ($data) {
          $entityId = $data['entity_id'];
          $data['contributor'] = $data['contributor_id'];
          $product = $this->productModel->load($entityId);
          if ($product) {
            $data['product_name'] = $product->getName();
          }
        }        

        if (!empty($data)) {
            $model->setData($data);
        }
        $this->_coreRegistry->register('contributer_product', $model);
        
        return $resultPage;
   }
}
