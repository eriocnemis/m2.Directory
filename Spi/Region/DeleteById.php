<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\Directory\Spi\Region;

use Psr\Log\LoggerInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\NoSuchEntityException;
use Eriocnemis\Directory\Api\Data\RegionInterface;
use Eriocnemis\Directory\Api\Region\DeleteByIdInterface;
use Eriocnemis\Directory\Model\ResourceModel\Region as RegionResource;
use Eriocnemis\Directory\Model\RegionFactory;

/**
 * Delete region by id command
 *
 * @api
 */
class DeleteById implements DeleteByIdInterface
{
    /**
     * Region factory
     *
     * @var RegionFactory
     */
    private $factory;

    /**
     * Region resource
     *
     * @var RegionResource
     */
    private $resource;

    /**
     * System logger
     *
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * Initialize command
     *
     * @param RegionResource $resource
     * @param RegionFactory $factory
     * @param LoggerInterface $logger
     */
    public function __construct(
        RegionResource $resource,
        RegionFactory $factory,
        LoggerInterface $logger
    ) {
        $this->resource = $resource;
        $this->factory = $factory;
        $this->logger = $logger;
    }

    /**
     * Delete region by id
     *
     * @param int $regionId
     * @return bool true on success
     * @throws NoSuchEntityException
     * @throws CouldNotDeleteException
     */
    public function execute($regionId)
    {
        /** @var \Magento\Framework\Model\AbstractModel $region */
        $region = $this->factory->create();
        $this->resource->load($region, $regionId, RegionInterface::REGION_ID);

        if (!$region->getId()) {
            throw new NoSuchEntityException(
                __('Region with id "%1" does not exist.', $regionId)
            );
        }

        try {
            $this->resource->delete($region);
        } catch (\Exception $e) {
            $this->logger->critical($e->getMessage());
            throw new CouldNotDeleteException(
                __('Could not delete the region with id: %1', $regionId)
            );
        }
        return true;
    }
}
