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
 * Mass status controller
 */
class MassStatus extends Action
{
    /**
     * Update status from specified regions
     *
     * @return ResponseInterface
     */
    public function execute()
    {
        try {
            $collection = $this->filter->getCollection(
                $this->collectionFactory->create()
            );

            $size = $collection->getSize();
            if (!$size) {
                $this->messageManager->addError(
                    __('Please correct the regions you requested.')
                );
                return $this->_redirect('*/*/index');
            }

            $status = (int)$this->getRequest()->getParam('status');
            $collection->setDataToAll('status', $status);
            $collection->walk('save');

            $this->messageManager->addSuccess(
                __('A total of %1 record(s) have been modified.', $size)
            );
        } catch (LocalizedException $e) {
            $this->messageManager->addError(
                $e->getMessage()
            );
        } catch (\Exception $e) {
            $this->messageManager->addError(
                __('We can\'t change status these regions right now. Please review the log and try again.')
            );
            $this->logger->critical($e);
        }
        return $this->_redirect('*/*/index');
    }
}
