<?php

namespace Barefoot\ProductContributors\Model\ResourceModel;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
/**
 * Contributor ResourceModel class
 */ 
class Contributor extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
	/**
	 * Init resource Model
	 */
    protected function _construct()
    {
        $this->_init('barefoot_contributors', 'contributor_id');
    }
}