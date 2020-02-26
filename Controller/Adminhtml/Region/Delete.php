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
        try {
            /** @var \Eriocnemis\Directory\Model\Region $region */
            $region = $this->initRegion();
            $region->delete();

            $this->messageManager->addSuccess(
                __('You deleted the region %1.', $region->getDefaultName())
            );
            return $this->_redirect('*/*/');
        } catch (LocalizedException $e) {
            $this->messageManager->addError(
                $e->getMessage()
            );
        } catch (\Exception $e) {
            $this->logger->critical($e);
            $this->messageManager->addError(
                __('We can\'t delete the region right now. Please review the log and try again.')
            );
        }
        $this->_redirect('*/*/edit', ['_current' => true]);
    }
}
