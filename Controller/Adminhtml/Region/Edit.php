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
 * Edit controller
 */
class Edit extends Action
{
    /**
     * Init active menu and set breadcrumb
     *
     * @return $this
     */
    protected function initAction()
    {
        $this->_view->loadLayout();
        $this->_setActiveMenu(
            'Eriocnemis_Directory::directory_region'
        )->_addBreadcrumb(
            __('Regions'),
            __('Regions')
        );
        return $this;
    }

    /**
     * Edit model
     *
     * @return ResponseInterface
     */
    public function execute()
    {
        try {
            $region = $this->initRegion();
        } catch (LocalizedException $e) {
            $this->messageManager->addError($e->getMessage());
            return $this->_redirect('*/*/*');
        } catch (\Exception $e) {
            $this->logger->critical($e);
            return $this->_redirect('*/*/');
        }

        // set entered data if was error when we do save
        $data = $this->_session->getRegionData(true);
        if (!empty($data)) {
            $region->addData($data);
        }

        $this->initAction();
        $this->_view->getPage()->getConfig()->getTitle()->prepend(__('Regions'));
        $this->_view->getPage()->getConfig()->getTitle()->prepend(
            $region->getId() ? $region->getDefaultName() : __('New Region')
        );

        $this->_addBreadcrumb(
            $region->getId() ? __('Edit Region') : __('New Region'),
            $region->getId() ? __('Edit Region') : __('New Region')
        );

        $this->_view->renderLayout();
    }
}
