<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Eriocnemis\Directory\Model\Region\Validator;

use Eriocnemis\Directory\Model\Region\ValidatorInterface;
use Eriocnemis\Directory\Model\Region;

/**
 * General validator
 */
class General implements ValidatorInterface
{
    /**
     * Validate region attribute values
     *
     * @return string[]
     */
    public function validate(Region $region)
    {
        $errors = [];
        if (!\Zend_Validate::is($region->getDefaultName(), 'NotEmpty')) {
            $errors[] = __(
                'Default Name field is required. Enter and try again.'
            );
        }

        if (!\Zend_Validate::is($region->getCode(), 'NotEmpty')) {
            $errors[] = __(
                'Region Code field is required. Enter and try again.'
            );
        }

        return $errors;
    }
}
