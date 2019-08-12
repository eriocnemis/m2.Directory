<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Eriocnemis\Directory\Controller\Adminhtml\Region;

use \Magento\Framework\App\ResponseInterface;
use \Magento\Framework\Exception\LocalizedException;
use \Eriocnemis\Directory\Controller\Adminhtml\Region as Action;

/**
 * Save controller
 */
class Save extends Action
{
    /**
     * Save action
     *
     * @return ResponseInterface
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('region_id');
        $data = $this->getRequest()->getPostValue('region');
        if ($data) {
            try {
                $back = $this->getRequest()->getParam('back', false);

                $region = $this->initRegion('region_id');
                $region->addData($data);

                $this->_session->setRegionData($region->getData());
                $region->save();

                $this->messageManager->addSuccess(__('You saved the region.'));
                $this->_session->setRegionData(false);

                if ($back) {
                    return $this->_redirect('*/*/edit', ['id' => $region->getId(), '_current' => true]);
                }
            } catch (LocalizedException $e) {
                $this->_session->setRegionData($data);
                $this->messageManager->addError(
                    $e->getMessage()
                );
                return $this->_redirect('*/*/edit', ['id' => $id, '_current' => true]);
            } catch (\Exception $e) {
                $this->logger->critical($e);
                $this->messageManager->addError(
                    __('We can\'t save the region right now.')
                );
                return $this->_redirect('*/*/edit', ['id' => $id, '_current' => true]);
            }
        }
        return $this->_redirect('*/*/');
    }
}
