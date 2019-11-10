<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Eriocnemis\Directory\Model\Region\Validator;

use Magento\Directory\Model\AllowedCountries;
use Eriocnemis\Directory\Model\Region\ValidatorInterface;
use Eriocnemis\Directory\Model\Region;

/**
 * Country validator
 */
class Country implements ValidatorInterface
{
    /**
     * Allowed countries list
     *
     * @var AllowedCountries
     */
    protected $countries;

    /**
     * Initialize validator
     *
     * @param AllowedCountries $countries
     */
    public function __construct(
        AllowedCountries $countries
    ) {
        $this->countries = $countries;
    }

    /**
     * Validate region attribute values
     *
     * @return array
     */
    public function validate(Region $region)
    {
        $errors = [];
        $countryId = $region->getCountryId();

        if (!\Zend_Validate::is($countryId, 'NotEmpty')) {
            $errors[] = __(
                'Country field is required. Enter and try again.'
            );
        } elseif (!in_array($countryId, $this->countries->getAllowedCountries(), true)) {
            $errors[] = __(
                'Invalid value of %1 provided for the Country field.',
                $countryId
            );
        }

        return $errors;
    }
}
