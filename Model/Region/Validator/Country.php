<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Eriocnemis\Directory\Model\Region\Validator;

use Magento\Directory\Api\CountryInformationAcquirerInterface;
use Eriocnemis\Directory\Model\Region\ValidatorInterface;
use Eriocnemis\Directory\Model\Region;

/**
 * Country validator
 */
class Country implements ValidatorInterface
{
    /**
     * Country repository
     *
     * @var CountryInformationAcquirerInterface
     */
    protected $repository;

    /**
     * Initialize validator
     *
     * @param CountryInformationAcquirerInterface $repository
     */
    public function __construct(
        CountryInformationAcquirerInterface $repository
    ) {
        $this->repository = $repository;
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
        } else {
            try {
                $this->repository->getCountryInfo($countryId);
            } catch (\Exception $e) {
                $errors[] = __(
                    'Invalid value of %1 provided for the Country field.',
                    $countryId
                );
            }
        }
        return $errors;
    }
}
