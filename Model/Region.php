<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Eriocnemis\Directory\Model;

use Magento\Framework\Model\AbstractModel;
use Eriocnemis\Directory\Model\ResourceModel\Region as RegionResource;

/**
 * Region
 *
 * @method Region setDefaultName(string $name)
 * @method string getDefaultName()
 * @method Region setCountryId(string $countryId)
 * @method string getCountryId()
 * @method Region setCode(string $code)
 * @method string getCode()
 * @method Region setLabels(array $labels)
 * @method array getLabels()
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
