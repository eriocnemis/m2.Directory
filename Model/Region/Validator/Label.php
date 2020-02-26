<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Eriocnemis\Directory\Model\Region\Validator;

use Eriocnemis\Directory\Model\Region\ValidatorInterface;
use Eriocnemis\Directory\Model\Region;

/**
 * Labels validator
 */
class Label implements ValidatorInterface
{
    /**
     * Validate region attribute values
     *
     * @return array
     */
    public function validate(Region $region)
    {
        $count = 0;
        $errors = [];
        $labels = $region->getLabels();

        if (is_array($labels)) {
            $count = count($labels);
            foreach ($labels as $label) {
                if (!empty($label['delete'])) {
                    $count--;
                    continue;
                }

                if (!\Zend_Validate::is($label['locale'] ?? '', 'NotEmpty')) {
                    $errors[] = __(
                        'Language of Label is required. Enter and try again.'
                    );
                }

                if (!\Zend_Validate::is($label['name'] ?? '', 'NotEmpty')) {
                    $errors[] = __(
                        'Region Name of Label is required. Enter and try again.'
                    );
                }
            }
        }

        if ($count < 1) {
            $errors[] = __(
                'Labels is required. Please specify at least one label.'
            );
        }

        return $errors;
    }
}
