<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Eriocnemis\Directory\Block\Adminhtml\Region\Edit\Tab;

use Magento\Framework\Data\Form;
use Magento\Framework\Data\Form\Element\AbstractElement;
use Magento\Framework\Data\Form\Element\Renderer\RendererInterface;
use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Backend\Block\Widget\Tab\TabInterface;
use Eriocnemis\Directory\Block\Adminhtml\Region\Edit\Tab\Label\Renderer as LabelRenderer;
use Eriocnemis\Directory\Model\Constant;

/**
 * Label tab
 *
 * @api
 */
class Label extends Generic implements TabInterface
{
    /**
     * Retrieve Tab label
     *
     * @return string
     */
    public function getTabLabel()
    {
        return __('Labels');
    }

    /**
     * Retrieve Tab title
     *
     * @return string
     */
    public function getTabTitle()
    {
        return __('Labels');
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
            'label_fieldset',
            [
                'legend' => __('Labels')
            ]
        );

        $fieldset->addField(
            'labels',
            'text',
            [
                'name' => 'labels',
                'label' => __('Labels'),
                'title' => __('Labels')
            ]
        );

        /** @var AbstractElement $element */
        $element = $form->getElement('labels');
        /** @var RendererInterface $renderer */
        $renderer = $this->getLayout()->createBlock(LabelRenderer::class);
        $element->setRenderer($renderer);

        $form->setFieldNameSuffix('region');
        $form->setValues($region->getData());
        $this->setForm($form);

        $this->_eventManager->dispatch(
            'eriocnemis_directory_region_edit_tab_label_prepare_form',
            ['form' => $form]
        );

        return parent::_prepareForm();
    }
}
