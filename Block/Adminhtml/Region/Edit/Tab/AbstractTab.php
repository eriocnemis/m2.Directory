<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Eriocnemis\Directory\Block\Adminhtml\Region\Edit\Tab;

use Magento\Backend\Block\Widget\Form\Generic;
use Eriocnemis\Directory\Model\Constant;

/**
 * Abstract tab
 */
abstract class AbstractTab extends Generic
{
    /**
     * Current region
     *
     * @var \Eriocnemis\Directory\Model\Region
     */
    protected $region;

    /**
     * Prepare schedule properties form
     *
     * @return $this
     */
    protected function _prepareForm()
    {
        $this->setForm(
            $this->_formFactory->create()
        );

        $this->region = $this->_coreRegistry->registry(
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
        )->setData('field_name_suffix', 'region');

        return parent::_initFormValues();
    }
}
