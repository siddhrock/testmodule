<?php
namespace Barefoot\ProductContributors\Block\Adminhtml;

class Product extends \Magento\Backend\Block\Widget\Grid\Container
{

	protected function _construct()
	{
		$this->_controller = 'barefoot_product';
		$this->_blockGroup = 'Barefoot_ProductContributors';
		$this->_headerText = __('Manage Product Contributors');
		$this->_addButtonLabel = __('Add New');
		$this->_addNewButton();
		parent::_construct();
	}

	protected function _addImportButton()
    {
        $this->addButton(
            'add',
            [
                'label' => "Import",
                'onclick' => 'setLocation(\'' . $this->getCreateUrl() . '\')',
                'class' => 'add primary'
            ]
        );
    }
}