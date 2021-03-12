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
use Eriocnemis\Directory\Api\Data\RegionExtensionFactory;

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
     * Region extension factory
     *
     * @var RegionExtensionFactory
     */
    private $extensionFactory;

    /**
     * Initialize converter
     *
     * @param RegionInterfaceFactory $regionDataFactory
     * @param LabelInterfaceFactory $labelDataFactory
     * @param RegionExtensionFactory $extensionFactory
     */
    public function __construct(
        RegionInterfaceFactory $regionDataFactory,
        LabelInterfaceFactory $labelDataFactory,
        RegionExtensionFactory $extensionFactory
    ) {
        $this->regionDataFactory = $regionDataFactory;
        $this->labelDataFactory = $labelDataFactory;
        $this->extensionFactory = $extensionFactory;
    }

    /**
     * Convert to data
     *
     * @param AbstractModel $model
     * @return RegionInterface
     */
    public function convert(AbstractModel $model): RegionInterface
    {
        $data = $this->convertExtensionAttributesToObject($model->getData());
        $region = $this->regionDataFactory->create(['data' => $data]);
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

    /**
     * Convert extension attributes of model to object if it is an array
     *
     * @param array $data
     * @return array
     */
    private function convertExtensionAttributesToObject(array $data)
    {
        if (isset($data['extension_attributes']) && is_array($data['extension_attributes'])) {
            /** @var RegionExtensionFactory $attributes */
            $data['extension_attributes'] = $this->extensionFactory->create(['data' => $data['extension_attributes']]);
        }
        return $data;
    }
}
