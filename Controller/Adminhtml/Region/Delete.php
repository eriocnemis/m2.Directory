<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Eriocnemis\Directory\Controller\Adminhtml\Region;

use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Exception\LocalizedException;
use Eriocnemis\Directory\Controller\Adminhtml\Region as Action;

/**
 * Delete controller
 */
class Delete extends Action
{
    /**
     * Delete action
     *
     * @return ResponseInterface
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        try {
            /** @var \Eriocnemis\Directory\Model\Region $region */
            $region = $this->initRegion();
            $region->delete();

            $this->messageManager->addSuccess(
                __('You deleted the region.')
            );
            return $this->_redirect('*/*/index');
        } catch (LocalizedException $e) {
            $this->messageManager->addError($e->getMessage());
        } catch (\Exception $e) {
            $this->messageManager->addError(
                __('We can\'t delete the region right now. Please review the log and try again.')
            );
            $this->logger->critical($e);
        }
        $this->_redirect('*/*/*', ['id' => $id, '_current' => true]);
    }
}
