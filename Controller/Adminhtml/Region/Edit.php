<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\Directory\Controller\Adminhtml\Region;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Eriocnemis\Directory\Api\Data\RegionInterface;
use Eriocnemis\Directory\Api\Region\GetByIdInterface;

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
     * Get region by id command
     *
     * @var GetByIdInterface
     */
    private $commandGetById;

    /**
     * Initialize controller
     *
     * @param Context $context
     * @param GetByIdInterface $commandGetById
     */
    public function __construct(
        Context $context,
        GetByIdInterface $commandGetById
    ) {
        $this->commandGetById = $commandGetById;

        parent::__construct(
            $context
        );
    }

    /**
     * Edit model
     *
     * @return ResultInterface
     */
    public function execute(): ResultInterface
    {
        $regionId = (int)$this->getRequest()->getParam(RegionInterface::REGION_ID);
        /** @var \Magento\Backend\Model\View\Result\Page $result */
        $result = $this->resultFactory->create(ResultFactory::TYPE_PAGE);

        try {
            $label = (string)__('New Region');
            $title = (string)__('New Region');
            if ($regionId) {
                $region = $this->commandGetById->execute($regionId);
                $label = (string)__('Edit Region');
                $title = (string)__('Edit Region %1', $region->getDefaultName());
            }

            $result->setActiveMenu('Magento_Backend::directory');
            $result->addBreadcrumb($label, $title);
            $result->getConfig()->getTitle()->prepend($title);
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
