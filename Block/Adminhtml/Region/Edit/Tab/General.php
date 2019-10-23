<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Eriocnemis\Directory\Block\Adminhtml\Region\Edit\Tab;

use Magento\Framework\Registry;
use Magento\Framework\Data\Form;
use Magento\Framework\Data\FormFactory;
use Magento\Backend\Block\Template\Context;
use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Backend\Block\Widget\Tab\TabInterface;
use Magento\Config\Model\Config\Source\Locale\Country as CountrySource;
use Eriocnemis\Directory\Model\Constant;

/**
 * General tab
 *
 * @api
 */
class General extends Generic implements TabInterface
{
    /**
     * Country source
     *
     * @var CountrySource
     */
    protected $countrySource;

    /**
     * Intialize tab
     *
     * @param Context $context
     * @param Registry $registry
     * @param FormFactory $formFactory
     * @param CountrySource $countrySource
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        FormFactory $formFactory,
        CountrySource $countrySource,
        array $data = []
    ) {
        $this->countrySource = $countrySource;

        parent::__construct(
            $context,
            $registry,
            $formFactory,
            $data
        );
    }

    /**
     * Retrieve Tab label
     *
     * @return string
     */
    public function getTabLabel()
    {
        return __('General Information');
    }

    /**
     * Retrieve Tab title
     *
     * @return string
     */
    public function getTabTitle()
    {
        return __('General Information');
    }

    /**
     * Can show tab in tabs
     *
     * @return boolean
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * Tab is hidden
     *
     * @return boolean
     */
    public function isHidden()
    {
        return false;
    }

    /**
     * Prepare general properties form
     *
     * @return $this
     */
    protected function _prepareForm()
    {
        $region = $this->_coreRegistry->registry(
            Constant::CURRENT_REGION
        );

        /** @var Form $form */
        $form = $this->_formFactory->create();
        $form->setHtmlIdPrefix('region_');

        $fieldset = $form->addFieldset(
            'general_fieldset',
            [
                'legend' => __('General Information')
            ]
        );

        if ($region->getId()) {
            $fieldset->addField(
                'region_id',
                'hidden',
                [
                    'name' => 'region_id'
                ]
            );
        }

        $fieldset->addField(
            'code',
            'text',
            [
                'name' => 'code',
                'label' => __('Region Code'),
                'title' => __('Region Code'),
                'required' => true
            ]
        );

        $fieldset->addField(
            'default_name',
            'text',
            [
                'name' => 'default_name',
                'label' => __('Default Name'),
                'title' => __('Default Name'),
                'required' => true
            ]
        );

        $fieldset->addField(
            'country_id',
            'select',
            [
                'label' => __('Country'),
                'name' => 'country_id',
                'values' => $this->countrySource->toOptionArray(),
                'required' => true
            ]
        );

        $form->setFieldNameSuffix('region');
        $form->setValues($region->getData());
        $this->setForm($form);

        $this->_eventManager->dispatch(
            'eriocnemis_directory_region_edit_tab_general_prepare_form',
            ['form' => $form]
        );

        return parent::_prepareForm();
    }
}
