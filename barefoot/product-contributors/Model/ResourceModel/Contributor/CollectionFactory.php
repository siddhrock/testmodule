<?php
namespace Barefoot\ProductContributors\Model\ResourceModel\Contributor;

/** 
 * Contributor model collection Factory
 */
class CollectionFactory
{
    /**
     * Object Managet
     *
     * @var \Magento\Framework\ObjectManagerInterface
     */
    protected $_objectManager = null;
    
    /**
     * Instance name
     *
     * @var \Barefoot\ProductContributors\Model\ResourceModel\Contributor\Collection
     */
    protected $_instanceName = null;
    
    /**
     * @param \Magento\Framework\ObjectManagerInterface $objectManager
     * @param \Barefoot\ProductContributors\Model\ResourceModel\Contributor\Collection $instanceName
     */
    public function __construct(\Magento\Framework\ObjectManagerInterface $objectManager, $instanceName = '\\Barefoot\\ProductContributors\\Model\\ResourceModel\\Contributor\\Collection')
    {
        $this->_objectManager = $objectManager;
        $this->_instanceName = $instanceName;
    }

    /**
     * @return instance
     */
    public function create(array $data = array())
    {
        return $this->_objectManager->create($this->_instanceName, $data);
    }
}