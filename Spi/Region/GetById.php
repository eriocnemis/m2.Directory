<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\Directory\Spi\Region;

use Magento\Framework\Exception\NoSuchEntityException;
use Eriocnemis\Directory\Api\Region\GetByIdInterface;
use Eriocnemis\Directory\Api\Data\RegionInterface;
use Eriocnemis\Directory\Model\Region\Converter\ToDataConverter;
use Eriocnemis\Directory\Model\ResourceModel\Region as RegionResource;
use Eriocnemis\Directory\Model\RegionFactory;

/**
 * Get region by id command
 *
 * @api
 */
class GetById implements GetByIdInterface
{
    /**
     * Region resource
     *
     * @var RegionResource
     */
    private $resource;

    /**
     * Region factory
     *
     * @var RegionFactory
     */
    private $factory;

    /**
     * Region model converter
     *
     * @var ToDataConverter
     */
    private $toDataConverter;

    /**
     * Initialize command
     *
     * @param RegionResource $resource
     * @param ToDataConverter $toDataConverter
     * @param RegionFactory $factory
     */
    public function __construct(
        RegionResource $resource,
        ToDataConverter $toDataConverter,
        RegionFactory $factory
    ) {
        $this->resource = $resource;
        $this->toDataConverter = $toDataConverter;
        $this->factory = $factory;
    }

    /**
     * Retrieve region by id
     *
     * @param int $regionId
     * @return RegionInterface
     * @throws NoSuchEntityException
     */
    public function execute($regionId): RegionInterface
    {
        /** @var \Magento\Framework\Model\AbstractModel $region */
        $region = $this->factory->create();
        $this->resource->load($region, $regionId, RegionInterface::REGION_ID);

        if (!$region->getId()) {
            throw new NoSuchEntityException(
                __('Region with id "%1" does not exist.', $regionId)
            );
        }
        return $this->toDataConverter->convert($region);
    }
}
