<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Eriocnemis\Directory\Model\Region;

use Magento\Framework\Exception\LocalizedException;
use Eriocnemis\Directory\Model\Region;

/**
 * Region composite validator
 */
class CompositeValidator implements ValidatorInterface
{
    /**
     * Region validators
     *
     * @var ValidatorInterface[]
     */
    protected $validators;

    /**
     * Initialize validator
     *
     * @param ValidatorInterface[] $validators
     */
    public function __construct(
        array $validators = []
    ) {
        foreach ($validators as $validator) {
            if (!$validator instanceof ValidatorInterface) {
                throw new LocalizedException(
                    __('Region validator must implement %1.', ValidatorInterface::class)
                );
            }
        }
        $this->validators = $validators;
    }

    /**
     * Validate region attribute values
     *
     * @return string[]
     */
    public function validate(Region $region)
    {
        $errors = [];
        foreach ($this->validators as $validator) {
            $errors += $validator->validate($region);
        }
        return $errors;
    }
}
