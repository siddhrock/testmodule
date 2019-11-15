<?php
namespace Barefoot\ProductContributors\Block\Adminhtml;

class Contributor extends \Magento\Backend\Block\Widget\Grid\Container
{

	protected function _construct()
	{
		$this->_controller = 'barefoot_contributor';
		$this->_blockGroup = 'Barefoot_ProductContributors';
		$this->_headerText = __('Contributor Manager');
		$this->_addButtonLabel = __('Add New');
		parent::_construct();
	}
}