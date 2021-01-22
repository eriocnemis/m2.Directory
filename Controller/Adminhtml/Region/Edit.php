<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\Directory\Controller\Adminhtml\Region;

use Magento\Backend\App\Action;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Eriocnemis\Directory\Api\Data\RegionInterface;

/**
 * Edit controller
 */
class Edit extends Action implements HttpGetActionInterface
{
    /**
     * Authorization level of a basic admin session
     */
    const ADMIN_RESOURCE = 'Eriocnemis_Directory::region_edit';

    /**
     * Edit model
     *
     * @return ResultInterface
     */
    public function execute(): ResultInterface
    {
        $regionId = (int)$this->getRequest()->getParam(RegionInterface::REGION_ID);
        try {
            /** @var \Magento\Backend\Model\View\Result\Page $result */
            $result = $this->resultFactory->create(
                ResultFactory::TYPE_PAGE
            );
            $result->setActiveMenu('Magento_Backend::directory');
            $result->addBreadcrumb(
                (string)__('Directory'),
                (string)__('Edit Region')
            );
            $result->getConfig()->getTitle()->prepend(
                (string)__('Edit Region %1', 'test' /*$job->getName()*/)
            );
        } catch (NoSuchEntityException $e) {
            /** @var \Magento\Framework\Controller\Result\Redirect $result */
            $result = $this->resultRedirectFactory->create();
            $this->messageManager->addErrorMessage(
                (string)__('The Region with id "%1" does not exist.', $regionId)
            );
            $result->setPath('*/*');
        }

        return $result;
    }
}
