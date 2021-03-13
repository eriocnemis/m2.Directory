<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\Directory\Spi\Region;

use Magento\Framework\Validation\ValidationException;
use Magento\Framework\Validation\ValidationResult;
use Eriocnemis\Directory\Api\Data\RegionInterface;
use Eriocnemis\Directory\Api\Region\ValidateInterface;
use Eriocnemis\Directory\Model\Region\ValidatorInterface;

/**
 * Validate data command
 *
 * @api
 */
class Validate implements ValidateInterface
{
    /**
     * Region validator
     *
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * Initialize command
     *
     * @param ValidatorInterface $validator
     */
    public function __construct(
        ValidatorInterface $validator
    ) {
        $this->validator = $validator;
    }

    /**
     * Save region
     *
     * @param RegionInterface $region
     * @return bool
     * @throws ValidationException
     */
    public function execute(RegionInterface $region): bool
    {
        /** @var ValidationResult $result */
        $result = $this->validator->validate($region);
        if (!$result->isValid()) {
            throw new ValidationException(__('Validation Failed'), null, 0, $result);
        }
        return true;
    }
}
