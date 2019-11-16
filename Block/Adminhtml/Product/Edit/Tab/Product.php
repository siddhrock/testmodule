<?php

namespace Barefoot\ProductContributors\Block\Adminhtml\Product\Edit\Tab;

class Product extends \Magento\Backend\Block\Widget\Form\Generic implements \Magento\Backend\Block\Widget\Tab\TabInterface
{
    /**
     * @var \Magento\Store\Model\System\Store
     */
    protected $_systemStore;
    
    /**
     * DealFactory
     */
    protected $_dealFactory;

    
    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Data\FormFactory $formFactory
     * @param \Magento\Store\Model\System\Store $systemStore
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Store\Model\System\Store $systemStore,
        \Barefoot\ProductContributors\Helper\Data $barefootHelper,
        array $data = array()
    ) {
        $this->_systemStore = $systemStore;
        $this->_barefootHelper = $barefootHelper;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * Prepare form
     *
     * @return $this
     */
    protected function _prepareForm()
    {
        $model = $this->_coreRegistry->registry('contributer_product');
        $isElementDisabled = false;
        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create();

        $fieldset = $form->addFieldset('base_fieldset', array('legend' => __('Product Contributer')));

        if ($model->getId()) {
            $fieldset->addField('cav', 'hidden', array('name' => 'cav'));
        }

        $fieldset->addField(
            'product_name',
            'text',
            array(
                'name' => 'product_name',
                'label' => __('Product Name'),
                'title' => __('Product Name'),
                'required' => true,
            )
        );

        $fieldset->addField(
            'store_id',
            'multiselect',
            [
                'name'     => 'store_id',
                'label'    => __('Store'),
                'title'    => __('Store'),
                'required' => true,
                'values'   => $this->_barefootHelper->getStoreList()
            ]
        );
        

        $fieldset->addField(
            'contributor',
            'select',
            [
                'name'     => 'contributor',
                'label'    => __('Contributor'),
                'title'    => __('Contributor'),
                'required' => true,
                'options'   => $this->_barefootHelper->getContributor()
            ]
        );

        $fieldset->addField(
            'contributor_type_handle',
            'select',
            [
                'name'     => 'contributor_type_handle',
                'label'    => __('Contributor Type Handle'),
                'title'    => __('Contributor Type Handle'),
                'required' => true,
                'options'   => $this->_barefootHelper->getContributorTypeHandle()
            ]
        );

        
        if (!$model->getId()) {
            $model->setData('is_active', $isElementDisabled ? '0' : '1');
        }

        $form->setValues($model->getData());
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
        return __('Product');
    }

    /**
     * Prepare title for tab
     *
     * @return string
     */
    public function getTabTitle()
    {
        return __('Product');
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

    /**
     * Check permission for passed action
     *
     * @param string $resourceId
     * @return bool
     */
    protected function _isAllowedAction($resourceId)
    {
        return $this->_authorization->isAllowed($resourceId);
    }
}
