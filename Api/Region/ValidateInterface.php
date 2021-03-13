<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\Directory\Api\Region;

use Magento\Framework\Validation\ValidationException;
use Eriocnemis\Directory\Api\Data\RegionInterface;

/**
 * Validate region data command interface
 *
 * @api
 */
interface ValidateInterface
{
    /**
     * Validate region
     *
     * @param RegionInterface $region
     * @return bool
     * @throws ValidationException
     */
    public function execute(RegionInterface $region): bool;
}
