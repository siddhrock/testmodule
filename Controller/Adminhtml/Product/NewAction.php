<?php

namespace Barefoot\ProductContributors\Controller\Adminhtml\Product;

use Magento\Framework\App\Action\HttpGetActionInterface as HttpGetActionInterface;

class NewAction extends \Magento\Backend\App\Action
{
   /**
     * Create new Product Contributor action
     *
     * @return void
     */
   public function execute()
   {
      $this->_forward('edit');
   }
}
