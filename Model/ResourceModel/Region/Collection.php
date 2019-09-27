<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Eriocnemis\Directory\Model\ResourceModel\Region;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Eriocnemis\Directory\Model\ResourceModel\Region as RegionResource;
use Eriocnemis\Directory\Model\Region;

/**
 * Region collection
 */
class Collection extends AbstractCollection
{
    /**
     * Identifier field name for collection items
     *
     * @var string
     */
    protected $_idFieldName = 'region_id';

    /**
     * Name prefix of events that are dispatched by model
     *
     * @var string
     */
    protected $_eventPrefix = 'eriocnemis_directory_region_collection';

    /**
     * Name of event parameter
     *
     * @var string
     */
    protected $_eventObject = 'collection';

    /**
     * initialize entity and resource
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(Region::class, RegionResource::class);
    }
}
