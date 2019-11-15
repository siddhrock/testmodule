<?php

namespace Barefoot\ProductContributors\Block\Adminhtml\Contributor\Edit\Tab;

use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Backend\Block\Widget\Tab\TabInterface;
use Magento\Backend\Block\Template\Context;
use Magento\Framework\Registry;
use Magento\Framework\Data\FormFactory;

class Info extends Generic implements TabInterface
{

   /**
     * @param Context $context
     * @param Registry $registry
     * @param FormFactory $formFactory
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        FormFactory $formFactory,
        array $data = []
    ) {
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * Prepare form fields
     *
     * @return \Magento\Backend\Block\Widget\Form
     */
    protected function _prepareForm()
    {
        $model = $this->_coreRegistry->registry('barefoot_contributor');
        

        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create();
       
        $form->setHtmlIdPrefix('contributor_');
 
        $fieldset = $form->addFieldset(
            'base_fieldset',
            ['legend' => __('General'),
                'class'  => 'fieldset-wide'
            ]
        );

        if ($model->getId()) {
            $fieldset->addField(
                'contributor_id',
                'hidden',
                ['name' => 'contributor_id']
            );
        }
        $fieldset->addField(
            'first_name',
            'text',
            [
                'name'        => 'first_name',
                'label'    => __('First Name'),
                'required'     => true
            ]
        );
        $fieldset->addField(
            'last_name',
            'text',
            [
                'name'        => 'last_name',
                'label'    => __('Last Name'),
                'required'     => true
            ]
        );

        $data = $model->getData();
        $form->setValues($data);
        $this->setForm($form);
        return parent::_prepareForm();
    }

    /**
     * Prepare label for tab
     *
     * @return string
     */
    public function getTabLabel()
    {
        return __('Contributor Info');
    }
 
    /**
     * Prepare title for tab
     *
     * @return string
     */
    public function getTabTitle()
    {
        return __('Contributor Info');
    }
 
    /**
     * {@inheritdoc}
     */
    public function canShowTab()
    {
        return true;
    }
 
    /**
     * {@inheritdoc}
     */
    public function isHidden()
    {
        return false;
    }
}