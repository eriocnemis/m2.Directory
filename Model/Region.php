<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\Directory\Model;

use Magento\Framework\Model\AbstractModel;
use Eriocnemis\Directory\Model\ResourceModel\Region as RegionResource;

/**
 * Region model
 */
class Region extends AbstractModel
{
    /**
     * Name prefix of events that are dispatched by model
     *
     * @var string
     */
    protected $_eventPrefix = 'eriocnemis_directory_region';

    /**
     * Name of event parameter
     *
     * @var string
     */
    protected $_eventObject = 'region';

    /**
     * Model construct that should be used for object initialization
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(RegionResource::class);
    }

    /**
     * Processing object after load data
     *
     * @return $this
     */
    public function afterLoad()
    {
        if (!$this->hasData('labels')) {
            /** @var RegionResource $resource */
            $resource = $this->getResource();
            $this->setData('labels', $resource->getLabels($this->getId()));
        }
        return parent::afterLoad();
    }

    /**
     * Save labels
     *
     * @return $this
     */
    public function afterSave()
    {
        if ($this->hasData('labels')) {
            /** @var RegionResource $resource */
            $resource = $this->getResource();
            $resource->saveLabels($this->getId(), $this->getLabels() ?: []);
        }
        return parent::afterSave();
    }
}
