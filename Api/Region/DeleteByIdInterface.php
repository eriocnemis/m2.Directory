<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\Directory\Api\Region;

use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Delete region by id command interface
 *
 * @api
 */
interface DeleteByIdInterface
{
    /**
     * Delete region by id
     *
     * @param int $regionId
     * @return bool true on success
     * @throws NoSuchEntityException
     * @throws CouldNotDeleteException
     */
    public function execute($regionId): bool;
}
