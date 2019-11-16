<?php

namespace Barefoot\ProductContributors\Controller\Adminhtml\Contributor;

use Magento\Framework\App\Action\HttpGetActionInterface as HttpGetActionInterface;

class NewAction extends \Magento\Backend\App\Action
{
   /**
     * Create new Contributor action
     *
     * @return void
     */
   public function execute()
   {
      $this->_forward('edit');
   }
}
