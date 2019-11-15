<?php

namespace Barefoot\ProductContributors\Model;
use Magento\Framework\Exception\LocalizedException as CoreException;

/**
 * Contributor Model class
 */
class Contributor extends \Magento\Framework\Model\AbstractModel
{
	/**
	 * init Model class
	 */
  	protected function _construct()
    {
        $this->_init('Barefoot\ProductContributors\Model\ResourceModel\Contributor');
    }
}