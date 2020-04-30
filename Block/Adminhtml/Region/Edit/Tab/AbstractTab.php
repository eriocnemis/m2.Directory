<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Eriocnemis\Directory\Block\Adminhtml\Region\Edit\Tab;

use Magento\Framework\Registry;
use Magento\Framework\Data\FormFactory;
use Magento\Backend\Block\Template\Context;
use Magento\Backend\Block\Widget\Form\Element\ElementCreator;
use Magento\Backend\Block\Widget\Form;
use Eriocnemis\Directory\Model\Constant;

/**
 * Abstract tab
 */
abstract class AbstractTab extends Form
{
    /**
     * Form factory
     *
     * @var FormFactory
     */
    protected $formFactory;

    /**
     * Core registry
     *
     * @var Registry
     */
    protected $coreRegistry;

    /**
     * Current region
     *
     * @var \Eriocnemis\Directory\Model\Region
     */
    protected $region;

    /**
     * Intialize tab
     *
     * @param Context $context
     * @param Registry $registry
     * @param FormFactory $formFactory
     * @param array $data
     * @param ElementCreator $creator
     */
    public function __construct(
        Context $context,
        Registry $registry,
        FormFactory $formFactory,
        array $data = [],
        ElementCreator $creator
    ) {
        $this->coreRegistry = $registry;
        $this->formFactory = $formFactory;

        parent::__construct(
            $context,
            $data,
            $creator
        );
    }

    /**
     * Prepare schedule properties form
     *
     * @return $this
     */
    protected function _prepareForm()
    {
        $this->setForm(
            $this->formFactory->create()
        );

        $this->region = $this->coreRegistry->registry(
            Constant::CURRENT_REGION
        );

        return parent::_prepareForm();
    }

    /**
     * Initialize form fields values
     *
     * @return $this
     */
    protected function _initFormValues()
    {
        $this->getForm()->addValues(
            $this->region->getData()
        )->setFieldNameSuffix('region');

        return parent::_initFormValues();
    }

    /**
     * Retrieve event manager
     *
     * @return \Magento\Framework\Event\ManagerInterface
     */
    protected function getEventManager()
    {
        return $this->_eventManager;
    }
}
