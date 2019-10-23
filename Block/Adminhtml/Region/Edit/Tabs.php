<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Eriocnemis\Directory\Block\Adminhtml\Region\Edit;

use Magento\Backend\Block\Widget\Tabs as AbstractTabs;

/**
 * Region tabs
 *
 * @api
 *
 * @method Tabs setId(string $id)
 * @method Tabs setTitle(string $title)
 */
class Tabs extends AbstractTabs
{
    /**
     * Intialize tab
     *
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();

        $this->setId('eriocnemis_directory_region_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(
            __('Region Information')
        );
    }
}
