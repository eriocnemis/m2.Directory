<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\Directory\Model\Region\Validator;

use Magento\Framework\Validation\ValidationResult;
use Magento\Framework\Validation\ValidationResultFactory;
use Eriocnemis\Directory\Api\Data\RegionInterface;
use Eriocnemis\Directory\Api\Region\ValidatorInterface;

/**
 * Check that default name is valid
 */
class DefaultNameValidator implements ValidatorInterface
{
    /**
     * Validation result factory
     *
     * @var ValidationResultFactory
     */
    private $validationResultFactory;

    /**
     * Initialize validator
     *
     * @param ValidationResultFactory $validationResultFactory
     */
    public function __construct(
        ValidationResultFactory $validationResultFactory
    ) {
        $this->validationResultFactory = $validationResultFactory;
    }

    /**
     * Validate default name
     *
     * @param RegionInterface $region
     * @return ValidationResult
     */
    public function validate(RegionInterface $region): ValidationResult
    {
        $errors = [];
        $name = trim($region->getDefaultName());
        if ('' === $name) {
            $errors[] = __('Default Name field is required. Enter and try again.');
        }
        return $this->validationResultFactory->create(['errors' => $errors]);
    }
}
