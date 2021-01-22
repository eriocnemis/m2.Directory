<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\Directory\Model\Region\Converter;

use Magento\Framework\Model\AbstractModel;
use Eriocnemis\Directory\Api\Data\RegionInterface;
use Eriocnemis\Directory\Api\Data\RegionInterfaceFactory;
use Eriocnemis\Directory\Api\Data\Region\LabelInterface;
use Eriocnemis\Directory\Api\Data\Region\LabelInterfaceFactory;

/**
 * Convert model to data
 */
class ToDataConverter
{
    /**
     * Region data factory
     *
     * @var RegionInterfaceFactory
     */
    private $regionDataFactory;

    /**
     * Label data factory
     *
     * @var LabelInterfaceFactory
     */
    private $labelDataFactory;

    /**
     * Initialize converter
     *
     * @param RegionInterfaceFactory $regionDataFactory
     * @param LabelInterfaceFactory $labelDataFactory
     */
    public function __construct(
        RegionInterfaceFactory $regionDataFactory,
        LabelInterfaceFactory $labelDataFactory
    ) {
        $this->regionDataFactory = $regionDataFactory;
        $this->labelDataFactory = $labelDataFactory;
    }

    /**
     * Convert to data
     *
     * @param AbstractModel $model
     * @return RegionInterface
     */
    public function convert(AbstractModel $model): RegionInterface
    {
        $region = $this->regionDataFactory->create(['data' => $model->getData()]);
        /* translate labels into objects */
        if ($region->getLabels()) {
            $labels = [];
            foreach ($region->getLabels() as $locale => $name) {
                $data = [LabelInterface::LOCALE => $locale, LabelInterface::NAME => $name];
                $labels[] = $this->labelDataFactory->create(['data' => $data]);
            }
            $region->setLabels($labels);
        }
        return $region;
    }
}
