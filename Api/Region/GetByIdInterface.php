<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\Directory\Api\Region;

use Magento\Framework\Exception\NoSuchEntityException;
use Eriocnemis\Directory\Api\Data\RegionInterface;

/**
 * Get region by id command interface
 *
 * @api
 */
interface GetByIdInterface
{
    /**
     * Retrieve region by id
     *
     * @param int $regionId
     * @return RegionInterface
     * @throws NoSuchEntityException
     */
    public function execute($regionId);
}
