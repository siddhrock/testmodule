<?php

namespace Barefoot\ProductContributors\Block\Adminhtml\Product\Edit;

class Form extends \Magento\Backend\Block\Widget\Form\Generic
{
    /**
     * Prepare form
     *
     * @return $this
     */
    protected function _prepareForm()
    {
        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create(
            array(
                'data' => array(
                    'id' => 'edit_form',
                    'action' => $this->getUrl('*/*/save'),
                    'method' => 'post',
                    'enctype' => 'multipart/form-data'
                )
            )
        );
        $form->setUseContainer(true);
        $this->setForm($form);
        return parent::_prepareForm();
    }
    /**
     * @return html 
     */
    public function getFormHtml()
    {
        $html=parent::getFormHtml();
        $html.=$this->setTemplate('Barefoot_ProductContributors::product/product.phtml')->toHtml();
        return $html;
    }
}
