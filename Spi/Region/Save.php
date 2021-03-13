<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\Directory\Spi\Region;

use Psr\Log\LoggerInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Validation\ValidationException;
use Eriocnemis\Directory\Api\Data\RegionInterface;
use Eriocnemis\Directory\Api\Region\SaveInterface;
use Eriocnemis\Directory\Api\Region\ValidateInterface;
use Eriocnemis\Directory\Model\Region\Converter\ToDataConverter;
use Eriocnemis\Directory\Model\Region\Converter\ToModelConverter;
use Eriocnemis\Directory\Model\ResourceModel\Region as RegionResource;

/**
 * Save region data command
 *
 * @api
 */
class Save implements SaveInterface
{
    /**
     * Region resource
     *
     * @var RegionResource
     */
    private $resource;

    /**
     * Validate command
     *
     * @var ValidateInterface
     */
    private $commandValidate;

    /**
     * Region data converter
     *
     * @var ToModelConverter
     */
    private $toModelConverter;

    /**
     * Region model converter
     *
     * @var ToDataConverter
     */
    private $toDataConverter;

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
     * @param ValidateInterface $commandValidate
     * @param ToModelConverter $toModelConverter
     * @param ToDataConverter $toDataConverter
     * @param LoggerInterface $logger
     */
    public function __construct(
        RegionResource $resource,
        ValidateInterface $commandValidate,
        ToModelConverter $toModelConverter,
        ToDataConverter $toDataConverter,
        LoggerInterface $logger
    ) {
        $this->resource = $resource;
        $this->commandValidate = $commandValidate;
        $this->toModelConverter = $toModelConverter;
        $this->toDataConverter = $toDataConverter;
        $this->logger = $logger;
    }

    /**
     * Save region
     *
     * @param RegionInterface $region
     * @return RegionInterface
     * @throws CouldNotSaveException
     * @throws ValidationException
     */
    public function execute(RegionInterface $region): RegionInterface
    {
        $this->commandValidate->execute($region);
        /** @var \Eriocnemis\Directory\Model\Region $model */
        $model = $this->toModelConverter->convert($region);
        try {
            $this->resource->save($model);
        } catch (\Exception $e) {
            $this->logger->critical($e->getMessage());
            throw new CouldNotSaveException(
                __('Could not save the region with id: %1', $region->getId())
            );
        }
        return $this->toDataConverter->convert($model);
    }
}
