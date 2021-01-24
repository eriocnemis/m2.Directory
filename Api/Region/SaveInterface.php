<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\Directory\Api\Region;

use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Validation\ValidationException;
use Eriocnemis\Directory\Api\Data\RegionInterface;

/**
 * Save region data command interface
 *
 * @api
 */
interface SaveInterface
{
    /**
     * Save region
     *
     * @param RegionInterface $region
     * @return RegionInterface
     * @throws CouldNotSaveException
     * @throws ValidationException
     */
    public function execute(RegionInterface $region): RegionInterface;
}
