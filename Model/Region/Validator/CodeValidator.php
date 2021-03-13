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
use Eriocnemis\Directory\Model\Region\ValidatorInterface;

/**
 * Check that code is valid
 */
class CodeValidator implements ValidatorInterface
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
     * Validate code
     *
     * @param RegionInterface $region
     * @return ValidationResult
     */
    public function validate(RegionInterface $region): ValidationResult
    {
        $errors = [];
        $code = trim($region->getCode());
        if ('' === $code) {
            $errors[] = __('Region Code field is required. Enter and try again.');
        }
        return $this->validationResultFactory->create(['errors' => $errors]);
    }
}
