<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Eriocnemis\Directory\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

/**
 * DB install schema
 */
class InstallSchema implements InstallSchemaInterface
{
    /**
     * Installs DB schema
     *
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        $this->addColumn($setup);
        $this->addIndex($setup);

        $setup->endSetup();
    }

    /**
     * Add column
     *
     * @param SchemaSetupInterface $setup
     * @return void
     */
    protected function addColumn(SchemaSetupInterface $setup)
    {
        $setup->getConnection()->addColumn(
            $setup->getTable('directory_country_region'),
            'status',
            [
                'type' => Table::TYPE_SMALLINT,
                'unsigned' => true,
                'nullable' => false,
                'default' => 1,
                'comment' => 'Region Status'
            ]
        );
    }

    /**
     * Add index
     *
     * @param SchemaSetupInterface $setup
     * @return void
     */
    protected function addIndex(SchemaSetupInterface $setup)
    {
        $setup->getConnection()->addIndex(
            $setup->getTable('directory_country_region'),
            $setup->getIdxName('directory_country_region', ['status']),
            ['status']
        );
    }
}
