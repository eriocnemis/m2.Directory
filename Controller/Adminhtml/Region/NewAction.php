<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Eriocnemis\Directory\Controller\Adminhtml\Region;

use Magento\Framework\App\ResponseInterface;
use Eriocnemis\Directory\Controller\Adminhtml\Region as Action;

/**
 * NewAction controller
 */
class NewAction extends Action
{
    /**
     * New draw action
     *
     * @return ResponseInterface
     */
    public function execute()
    {
        $this->_forward('edit');
    }
}
