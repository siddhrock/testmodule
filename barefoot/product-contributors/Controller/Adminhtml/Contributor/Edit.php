<?php

namespace Barefoot\ProductContributors\Controller\Adminhtml\Contributor;

use Magento\Framework\Controller\ResultFactory;

class Edit extends \Magento\Backend\App\Action
{ 

 public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Barefoot\ProductContributors\Model\Contributor $contributorFactory,
        \Magento\Framework\Registry $coreRegistry
    )     {
        parent::__construct($context);
        $this->_contributorFactory = $contributorFactory;
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
     	$model = $this->_contributorFactory;

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
        if (!empty($data)) {
            $model->setData($data);
        }
        $this->_coreRegistry->register('barefoot_contributor', $model);

        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
      /*  $resultPage = $this->_resultPageFactory->create();
        $resultPage->setActiveMenu('Barefoot_Contributor::main_menu');
        $resultPage->getConfig()->getTitle()->prepend(__('Contributor'));*/

        return $resultPage;
   }
}
