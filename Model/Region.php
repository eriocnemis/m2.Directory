<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Eriocnemis\Directory\Model;

use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Registry;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\Context;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Eriocnemis\Directory\Model\Region\CompositeValidator;
use Eriocnemis\Directory\Model\ResourceModel\Region as RegionResource;

/**
 * Region model
 *
 * @method Region setDefaultName(string $name)
 * @method string getDefaultName()
 * @method Region setCountryId(string $countryId)
 * @method string getCountryId()
 * @method Region setCode(string $code)
 * @method string getCode()
 * @method Region setLabels(array $labels)
 * @method array[] getLabels()
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
     * Region composite validator
     *
     * @var CompositeValidator
     */
    protected $compositeValidator;

    /**
     * Initialize model
     *
     * @param Context $context
     * @param Registry $registry
     * @param CompositeValidator $compositeValidator
     * @param AbstractResource $resource
     * @param AbstractDb $resourceCollection
     * @param string[] $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        CompositeValidator $compositeValidator,
        AbstractResource $resource = null,
        AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        $this->compositeValidator = $compositeValidator;

        parent::__construct(
            $context,
            $registry,
            $resource,
            $resourceCollection,
            $data
        );
    }

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
     * Validate region attribute values
     *
     * @return string[]|bool
     */
    public function validate()
    {
        $errors = $this->compositeValidator->validate($this);
        return empty($errors) ? true : $errors;
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
