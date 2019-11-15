<?php
namespace Barefoot\ProductContributors\Model\ResourceModel\Manageproduct;

/** 
 * Manageproduct model collection
 */
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
	/**
     * init constructor
     */
  	protected function _construct()
    {
        $this->_init('Barefoot\ProductContributors\Model\Manageproduct', 'Barefoot\ProductContributors\Model\ResourceModel\Manageproduct');
    }
}