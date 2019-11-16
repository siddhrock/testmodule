<?php

namespace Barefoot\ProductContributors\Controller\Adminhtml\Contributor;

use Magento\Framework\Controller\ResultFactory;

class Save extends \Magento\Backend\App\Action
{ 

 public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Barefoot\ProductContributors\Model\Contributor $contributorFactory
    )     {
        parent::__construct($context);
        $this->_contributorFactory = $contributorFactory;
    }

    /**
     * @return void
     */

   public function execute()
   {
    $data=$this->getRequest()->getPostValue();
     if ($data) {
       try{
        $this->_contributorFactory->setData($data);
        $id = $this->_contributorFactory->Save()->getId();
        $this->messageManager->addSuccess("Contributor Saved Successfully");
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
     $this->_redirect('barefoot/contributor/index');
     return;
   }
}
