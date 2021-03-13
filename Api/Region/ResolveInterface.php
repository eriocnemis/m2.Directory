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
 * Resolve data command interface
 *
 * @api
 */
interface ResolveInterface
{
    /**
     * Resolve region
     *
     * @param int|null $regionId
     * @param mixed[] $data
     * @return RegionInterface
     * @throws NoSuchEntityException
     */
    public function execute($regionId, array $data): RegionInterface;
}
