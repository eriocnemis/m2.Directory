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
        $back = $this->getRequest()->getParam('back', false);
        $data = $this->getRequest()->getPost('region');
        if ($data) {
            try {
                $region = $this->initRegion();
                $region->addData($data);

                $this->_session->setRegionData($data);
                /* validate region */
                $result = $region->validate();
                if (true !== $result && is_array($result)) {
                    foreach ($result as $errorMessage) {
                        $this->messageManager->addError($errorMessage);
                    }
                } else {
                    /* save region */
                    $region->save();
                    $this->_session->setRegionData(false);
                    $this->messageManager->addSuccess(
                        __('You saved the region.')
                    );
                }
            } catch (LocalizedException $e) {
                $this->_session->setRegionData($data);
                $this->messageManager->addError(
                    $e->getMessage()
                );
                $back = true;
            } catch (\Exception $e) {
                $this->logger->critical($e);
                $this->messageManager->addError(
                    __('We can\'t save the region right now.')
                );
            }
        }

        if ($back && $region->getId()) {
            return $this->_redirect('*/*/edit', ['region_id' => $region->getId(), '_current' => true]);
        }
        return $this->_redirect('*/*/');
    }
}
