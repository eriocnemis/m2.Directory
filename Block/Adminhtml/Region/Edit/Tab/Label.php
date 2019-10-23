<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Eriocnemis\Directory\Block\Adminhtml\Region\Edit\Tab;

use Magento\Backend\Block\Widget\Tab\TabInterface;
use Eriocnemis\Directory\Block\Adminhtml\Region\Edit\Tab\Label\Renderer as LabelRenderer;

/**
 * Label tab
 *
 * @api
 */
class Label extends AbstractTab implements TabInterface
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
        parent::_prepareForm();

        $fieldset = $this->getForm()->addFieldset(
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

        /** @var \Magento\Framework\Data\Form\Element\AbstractElement $element */
        $element = $this->getForm()->getElement('labels');
        /** @var \Magento\Framework\Data\Form\Element\Renderer\RendererInterface $renderer */
        $renderer = $this->getLayout()->createBlock(
            LabelRenderer::class
        );
        $element->setRenderer($renderer);

        return $this;
    }

    /**
     * Initialize form fields values
     *
     * @return $this
     */
    protected function _initFormValues()
    {
        $this->_eventManager->dispatch(
            'eriocnemis_directory_region_edit_tab_label_prepare_form',
            ['form' => $this->getForm()]
        );

        return parent::_initFormValues();
    }
}
