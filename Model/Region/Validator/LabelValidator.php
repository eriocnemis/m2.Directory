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
 * Check that labels is valid
 */
class LabelValidator implements ValidatorInterface
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
     * Validate region labels
     *
     * @param RegionInterface $region
     * @return ValidationResult
     */
    public function validate(RegionInterface $region): ValidationResult
    {
        $count = 0;
        $errors = [];
        $labels = $region->getLabels();
        if (is_array($labels)) {
            $count = count($labels);
            foreach ($labels as $label) {
                if ('' === trim($label->getLocale())) {
                    $errors[] = __('Language of Label is required. Enter and try again.');
                }

                if ('' === trim($label->getName())) {
                    $errors[] = __('Region Name of Label is required. Enter and try again.');
                }
            }
        }

        if ($count < 1) {
            $errors[] = __('Labels is required. Please specify at least one label.');
        }
        return $this->validationResultFactory->create(['errors' => $errors]);
    }
}
