<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Eriocnemis\Directory\Plugin\Directory\Model\ResourceModel\Region;

use Magento\Directory\Model\ResourceModel\Region\Collection as Subject;

/**
 * Region collection plugin
 */
class CollectionPlugin
{
    /**
     * Load data with filter in place
     *
     * @param Subject $subject
     * @param bool $printQuery
     * @param bool $logQuery
     * @return bool[]
     */
    public function beforeLoadWithFilter(Subject $subject, $printQuery = false, $logQuery = false)
    {
        $subject->getSelect()->where(
            'main_table.status = ?',
            '1'
        );
        return [$printQuery, $logQuery];
    }
}
