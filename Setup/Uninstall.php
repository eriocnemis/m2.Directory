<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Eriocnemis\Directory\Setup;

use Magento\Framework\Setup\UninstallInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

/**
 * Uninstall schema
 */
class Uninstall implements UninstallInterface
{
    /**
     * Uninstall DB schema
     *
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     */
    public function uninstall(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        $this->removeIndex($setup);
        $this->removeColumn($setup);

        $setup->endSetup();
    }

    /**
     * Remove column
     *
     * @param SchemaSetupInterface $setup
     * @return void
     */
    protected function removeColumn(SchemaSetupInterface $setup)
    {
        $setup->getConnection()->dropColumn(
            $setup->getTable('directory_country_region'),
            'status'
        );
    }

    /**
     * Remove index
     *
     * @param SchemaSetupInterface $setup
     * @return void
     */
    protected function removeIndex(SchemaSetupInterface $setup)
    {
        $setup->getConnection()->dropIndex(
            $setup->getTable('directory_country_region'),
            $setup->getIdxName('directory_country_region', ['status']),
        );
    }
}
