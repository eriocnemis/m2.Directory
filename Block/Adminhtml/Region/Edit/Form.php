<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Eriocnemis\Directory\Block\Adminhtml\Region\Edit;

use Magento\Backend\Block\Widget\Form\Generic;

/**
 * Region form
 *
 * @method Form setId($id)
 * @method string getId()
 * @method Form setTitle($title)
 * @method string getTitle()
 */
class Form extends Generic
{
    /**
     * Intialize form
     *
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();

        $this->setId('eriocnemis_directory_region_form');
        $this->setTitle(
            __('Region Information')
        );
    }

    /**
     * Prepare edit form
     *
     * @return $this
     */
    protected function _prepareForm()
    {
        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create(
            ['data' => [
                'id' => 'edit_form',
                'action' => $this->getData('action'),
                'method' => 'post'
            ]]
        );
        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}
