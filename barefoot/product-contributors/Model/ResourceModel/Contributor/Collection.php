<?php
namespace Barefoot\ProductContributors\Model\ResourceModel\Contributor;

/** 
 * Contributor model collection
 */
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
	/**
     * init constructor
     */
  	protected function _construct()
    {
        $this->_init('Barefoot\ProductContributors\Model\Contributor', 'Barefoot\ProductContributors\Model\ResourceModel\Contributor');
    }
}