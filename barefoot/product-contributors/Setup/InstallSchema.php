<?php

namespace Barefoot\ProductContributors\Setup;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\DB\Ddl\Table;

/**
 * InstallSchema for Update Database for Product label
 */
class InstallSchema implements InstallSchemaInterface
{
    /**
     * install Database for Product Label
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    { 
        $installer = $setup;
        $installer->startSetup();
        if (!$installer->tableExists('barefoot_contributors')) {
            $table = $installer->getConnection()->newTable(
                $installer->getTable('barefoot_contributors')
            )
            ->addColumn(
                'contributor_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                [
                    'identity' => true,
                    'nullable' => false,
                    'primary'  => true,
                    'unsigned' => true,
                ],
                'Contributor Id'
            )
            ->addColumn(
                'first_name',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                ['nullable => false'],
                'First Name'
            )
            ->addColumn(
                'last_name',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                ['nullable => false'],
                'Last Name'
            )
            ->setComment('Barefoot Contributors');

            $installer->getConnection()->createTable($table);
        }
        if (!$installer->tableExists('barefoot_product_contributor_values')) {
            $table = $installer->getConnection()->newTable(
                $installer->getTable('barefoot_product_contributor_values')
            )
            ->addColumn(
                'cav',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                [
                    'identity' => true,
                    'nullable' => false,
                    'primary'  => true,
                    'unsigned' => true,
                ],
                'Cav'
            )
            ->addColumn(
                'store_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['nullable => false'],
                'Store Id'
            )
            ->addColumn(
                'entity_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                0,
                ['nullable => false'],
                'Product Id'
            )
            ->addColumn(
                'contributor_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                0,
                ['nullable => false'],
                'Contributor Id'
            )
            ->addColumn(
                'contributor_type_handle',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                100,
                ['nullable => false'],
                'Contributor Type Handle'
            )->addIndex(  
                      $setup->getIdxName(  
                           $setup->getTable('barefoot_product_contributor_values'),  
                           ['entity_id', 'contributor_id', 'contributor_type_handle', 'store_id'],  
                           \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_INDEX  
                      ),  
                      ['entity_id', 'contributor_id', 'contributor_type_handle', 'store_id'],
                      ['type' => \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_INDEX]
            )->setComment('Barefoot Product Contributor Values');

            $installer->getConnection()->createTable($table);
        }
        $installer->endSetup();
    }
}
