<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Eriocnemis\Directory\Model\Region;

use Eriocnemis\Directory\Model\Region;

/**
 * Region validator interface
 */
interface ValidatorInterface
{
    /**
     * Validate region attribute values
     *
     * @return array
     */
    public function validate(Region $region);
}
