<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Eriocnemis\Directory\Controller\Adminhtml\Region;

use \Magento\Framework\App\ResponseInterface;
use \Eriocnemis\Directory\Controller\Adminhtml\Region as Action;

/**
 * Region index controller
 */
class Index extends Action
{
    /**
     * Schedules list
     *
     * @return ResponseInterface
     */
    public function execute()
    {
        $this->_view->loadLayout();
        $this->_setActiveMenu(
            'Eriocnemis_Directory::directory_region'
        );
        $this->_view->getPage()->getConfig()->getTitle()->prepend(
            __('Regions')
        );
        $this->_view->renderLayout();
    }
}
