<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\Directory\Api\Region;

use Magento\Framework\Api\SearchCriteriaInterface;
use Eriocnemis\Directory\Api\Data\Region\SearchResultInterface;

/**
 * Find regions by search criteria command interface
 *
 * @api
 */
interface GetListInterface
{
    /**
     * Retrieve list of regions
     *
     * @param SearchCriteriaInterface|null $searchCriteria
     * @return SearchResultInterface
     */
    public function execute(SearchCriteriaInterface $searchCriteria = null): SearchResultInterface;
}
