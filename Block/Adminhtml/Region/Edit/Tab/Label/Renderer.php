<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Eriocnemis\Directory\Block\Adminhtml\Region\Edit\Tab\Label;

use \Magento\Framework\Registry;
use \Magento\Framework\Data\Form\Element\Renderer\RendererInterface;
use \Magento\Framework\Data\Form\Element\AbstractElement;
use \Magento\Framework\View\Element\Html\Select;
use \Magento\Backend\Block\Template\Context;
use \Magento\Backend\Block\Widget;
use \Magento\Config\Model\Config\Source\Locale as LocaleSource;
use \Eriocnemis\Directory\Model\RegionFactory;
use \Eriocnemis\Directory\Model\RegistryConstant;

/**
 * Region tab label renderer
 *
 * @method Renderer setElement(AbstractElement $elemant)
 * @method AbstractElement getElement()
 */
class Renderer extends Widget implements RendererInterface
{
    /**
     * Path to template file in theme
     *
     * @var string
     */
    protected $_template = 'region/label.phtml';

    /**
     * Core registry
     *
     * @var Registry
     */
    protected $coreRegistry;

    /**
     * Region factory
     *
     * @var RegionFactory
     */
    protected $regionFactory;

    /**
     * Locale source
     *
     * @var LocaleSource
     */
    protected $localeSource;

    /**
     * Initialize renderer
     *
     * @param Context $context
     * @param Registry $registry
     * @param RegionFactory $regionFactory
     * @param LocaleSource $localeSource
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        RegionFactory $regionFactory,
        LocaleSource $localeSource,
        array $data = []
    ) {
        $this->coreRegistry = $registry;
        $this->regionFactory = $regionFactory;
        $this->localeSource = $localeSource;

        parent::__construct(
            $context,
            $data
        );
    }

    /**
     * Render form element as HTML
     *
     * @param AbstractElement $element
     * @return string
     */
    public function render(AbstractElement $element)
    {
        $this->setElement($element);
        return $this->toHtml();
    }

    /**
     * Retrieve labels data
     *
     * @return array
     */
    public function getLabels()
    {
        /** @var \Eriocnemis\Directory\Model\ResourceModel\Region $resource */
        $resource = $this->regionFactory->create()->getResource();
        return $resource->getLabels(
            $this->coreRegistry->registry(
                RegistryConstant::CURRENT_REGION_ID
            )
        );
    }

    /**
     * Retrieve options field name prefix
     *
     * @return string
     */
    public function getFieldName()
    {
        return 'region[labels]';
    }

    /**
     * Retrieve options field id prefix
     *
     * @return string
     */
    public function getFieldId()
    {
        return 'region';
    }

    /**
     * Retrieve locales select html
     *
     * @param string $locale
     * @return string
     */
    public function getLocaleSelectHtml($locale = null)
    {
        /** @var Select $select */
        $select = $this->getLayout()->createBlock(Select::class);
        $select->setData(
            $this->getLocaleSelectData()
        )->setName(
            $this->getFieldName() . ($locale ? '[' . $locale . '][locale]' : '[<%- data.id %>][locale]')
        )->setOptions(
            $this->localeSource->toOptionArray()
        )->setValue(
            $locale
        );
        return $select->getHtml();
    }

    /**
     * Retrieve locales select data
     *
     * @return array
     */
    protected function getLocaleSelectData()
    {
        return [
            'id' => $this->getFieldId() . '_<%- data.id %>_locale',
            'class' => 'select required-option-select',
            'extra_params' => 'data-value="<%- data.locale %>"'
        ];
    }
}
