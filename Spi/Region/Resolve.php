<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\Directory\Spi\Region;

use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Exception\NoSuchEntityException;
use Eriocnemis\Directory\Api\Data\RegionInterface;
use Eriocnemis\Directory\Api\Data\RegionInterfaceFactory;
use Eriocnemis\Directory\Api\Region\GetByIdInterface;
use Eriocnemis\Directory\Api\Region\ResolveInterface;

/**
 * Resolve data command
 *
 * @api
 */
class Resolve implements ResolveInterface
{
    /**
     * Region factory
     *
     * @var RegionInterfaceFactory
     */
    private $factory;

    /**
     * Get region by id command
     *
     * @var GetByIdInterface
     */
    private $commandGetById;

    /**
     * Data object helper
     *
     * @var DataObjectHelper
     */
    private $dataObjectHelper;

    /**
     * Initialize command
     *
     * @param RegionInterfaceFactory $factory
     * @param GetByIdInterface $commandGetById
     * @param DataObjectHelper $dataObjectHelper
     */
    public function __construct(
        RegionInterfaceFactory $factory,
        GetByIdInterface $commandGetById,
        DataObjectHelper $dataObjectHelper
    ) {
        $this->factory = $factory;
        $this->commandGetById = $commandGetById;
        $this->dataObjectHelper = $dataObjectHelper;
    }

    /**
     * Resolve region
     *
     * @param int|null $regionId
     * @param mixed[] $data
     * @return RegionInterface
     * @throws NoSuchEntityException
     */
    public function execute($regionId, array $data): RegionInterface
    {
        /** @var RegionInterface $region */
        $region = null !== $regionId
            ? $this->commandGetById->execute((int)$regionId)
            : $this->factory->create();

        $this->dataObjectHelper->populateWithArray($region, $data, RegionInterface::class);

        return $region;
    }
}
