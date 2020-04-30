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
 * Region mass delete controller
 */
class MassDelete extends Action
{
    /**
     * Delete specific regions
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
                return $this->_redirect('*/*/*');
            }

            $collection->walk('delete');

            $this->messageManager->addSuccess(
                __('You deleted a total of %1 records.', $size)
            );
        } catch (LocalizedException $e) {
            $this->messageManager->addError($e->getMessage());
        } catch (\Exception $e) {
            $this->messageManager->addError(
                __('We can\'t delete these regions right now. Please review the log and try again.')
            );
            $this->logger->critical($e);
        }
        return $this->_redirect('*/*/index', ['_current' => true]);
    }
}
