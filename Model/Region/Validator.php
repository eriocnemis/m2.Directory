<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\Directory\Model\Region;

use Magento\Framework\Validation\ValidationResult;
use Magento\Framework\Validation\ValidationResultFactory;
use Magento\Framework\Exception\LocalizedException;
use Eriocnemis\Directory\Api\Data\RegionInterface;

/**
 * Region composite validator
 */
class Validator implements ValidatorInterface
{
    /**
     * Validation result factory
     *
     * @var ValidationResultFactory
     */
    private $validationResultFactory;

    /**
     * Region validators
     *
     * @var ValidatorInterface[]
     */
    protected $validators;

    /**
     * Initialize validator
     *
     * @param ValidationResultFactory $validationResultFactory
     * @param ValidatorInterface[] $validators
     */
    public function __construct(
        ValidationResultFactory $validationResultFactory,
        array $validators = []
    ) {
        foreach ($validators as $validator) {
            if (!$validator instanceof ValidatorInterface) {
                throw new LocalizedException(
                    __('Region validator must implement %1.', ValidatorInterface::class)
                );
            }
        }

        $this->validationResultFactory = $validationResultFactory;
        $this->validators = $validators;
    }

    /**
     * Validate region attribute values
     *
     * @param RegionInterface $region
     * @return ValidationResult
     */
    public function validate(RegionInterface $region): ValidationResult
    {
        $errors = [];
        foreach ($this->validators as $validator) {
            $result = $validator->validate($region);
            if (!$result->isValid()) {
                array_push($errors, ...$result->getErrors());
            }
        }
        return $this->validationResultFactory->create(['errors' => $errors]);
    }
}
