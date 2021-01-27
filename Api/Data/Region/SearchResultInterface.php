<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\Directory\Api\Data\Region;

use Magento\Framework\Api\SearchResultsInterface as AbstractSearchResultsInterface;

/**
 * Region search results interface
 *
 * @api
 */
interface SearchResultInterface extends AbstractSearchResultsInterface
{
    /**
     * Retrieve regions
     *
     * @return \Eriocnemis\Directory\Api\Data\RegionInterface[]
     */
    public function getItems();

    /**
     * Set regions
     *
     * @param \Eriocnemis\Directory\Api\Data\RegionInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
