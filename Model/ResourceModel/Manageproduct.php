<?php

namespace Barefoot\ProductContributors\Model\ResourceModel;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
/**
 * Manageproduct ResourceModel class
 */ 
class Manageproduct extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
	/**
	 * Init resource Model
	 */
    protected function _construct()
    {
        $this->_init('barefoot_product_contributor_values', 'cav');
    }
}