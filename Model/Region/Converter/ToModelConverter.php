<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\Directory\Model\Region\Converter;

use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Reflection\DataObjectProcessor;
use Eriocnemis\Directory\Api\Data\RegionInterface;
use Eriocnemis\Directory\Model\ResourceModel\Region as RegionResource;
use Eriocnemis\Directory\Model\RegionFactory;

/**
 * Convert data to model
 */
class ToModelConverter
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
     * Data object processor
     *
     * @var DataObjectProcessor
     */
    private $dataObjectProcessor;

    /**
     * Initialize converter
     *
     * @param RegionResource $resource
     * @param DataObjectProcessor $dataObjectProcessor
     * @param RegionFactory $factory
     */
    public function __construct(
        RegionResource $resource,
        DataObjectProcessor $dataObjectProcessor,
        RegionFactory $factory
    ) {
        $this->resource = $resource;
        $this->dataObjectProcessor = $dataObjectProcessor;
        $this->factory = $factory;
    }

    /**
     * Convert to model
     *
     * @param RegionInterface $region
     * @return AbstractModel
     */
    public function convert(RegionInterface $region): AbstractModel
    {
        /** @var \Eriocnemis\Directory\Model\Region $model */
        $model = $this->factory->create();
        if ($region->getId()) {
            $this->resource->load($model, $region->getId(), RegionInterface::REGION_ID);
        }

        $data = $this->dataObjectProcessor->buildOutputDataArray($region, RegionInterface::class);
        $model->addData($data);
        /* translate labels into arrays */
        $labels = [];
        foreach ($region->getLabels() as $label) {
            $labels[$label->getLocale()] = $label->getName();
        }
        $model->setLabels($labels);

        return $model;
    }
}
