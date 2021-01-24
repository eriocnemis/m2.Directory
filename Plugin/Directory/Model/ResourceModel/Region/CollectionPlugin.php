<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\Directory\Plugin\Directory\Model\ResourceModel\Region;

use Magento\Framework\App\ResourceConnection\SourceProviderInterface;

/**
 * Region collection plugin
 */
class CollectionPlugin
{
    /**
     * Load data with filter in place
     *
     * @param SourceProviderInterface $collection
     * @param bool $printQuery
     * @param bool $logQuery
     * @return mixed[]
     */
    public function beforeLoadWithFilter(SourceProviderInterface $collection, $printQuery = false, $logQuery = false)
    {
        $collection->getSelect()->where(
            'main_table.status = ?',
            '1'
        );
        return [$printQuery, $logQuery];
    }
}
