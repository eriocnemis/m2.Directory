<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Eriocnemis\Directory\Block\Adminhtml\Region;

use Magento\Framework\Registry;
use Magento\Backend\Block\Widget\Context;
use Magento\Backend\Block\Widget\Form\Container;
use Eriocnemis\Directory\Model\Constant;

/**
 * Edit form
 *
 * @api
 */
class Edit extends Container
{
    /**
     * Core registry
     *
     * @var Registry
     */
    protected $coreRegistry;

    /**
     * Initialize form
     *
     * @param Context $context
     * @param Registry $registry
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        array $data = []
    ) {
        $this->coreRegistry = $registry;

        parent::__construct(
            $context,
            $data
        );
    }

    /**
     * Initialize form
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_objectId = 'region_id';
        $this->_controller = 'adminhtml_region';
        $this->_blockGroup = 'Eriocnemis_Directory';

        parent::_construct();

        $this->buttonList->add(
            'save_and_continue_edit',
            [
                'class' => 'save',
                'label' => __('Save and Continue Edit'),
                'data_attribute' => [
                    'mage-init' => ['button' => ['event' => 'saveAndContinueEdit', 'target' => '#edit_form']],
                ]
            ],
            3
        );
    }

    /**
     * Retrieve header text
     *
     * @return string
     */
    public function getHeaderText()
    {
        $region = $this->coreRegistry->registry(
            Constant::CURRENT_REGION
        );
        return ($region->getId())
            ? __("Edit Region '%1'", $this->escapeHtml($region->getDefaultName()))
            : __('New Region');
    }

    /**
     * Return save url for edit form
     *
     * @return string
     */
    public function getSaveUrl()
    {
        return $this->getUrl('*/*/save', ['_current' => true, 'back' => null]);
    }

    /**
     * Return save and continue url for edit form
     *
     * @return string
     */
    public function getSaveAndContinueUrl()
    {
        return $this->getUrl('*/*/save', ['_current' => true, 'back' => 'edit']);
    }
}
