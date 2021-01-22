<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\Directory\Controller\Adminhtml\Region;

use Psr\Log\LoggerInterface;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Eriocnemis\Directory\Api\Data\RegionInterface;
use Eriocnemis\TransferApi\Api\Export\Job\DeleteByIdInterface;

/**
 * Delete controller
 */
class Delete extends Action implements HttpPostActionInterface
{
    /**
     * Authorization level of a basic admin session
     */
    const ADMIN_RESOURCE = 'Eriocnemis_Directory::region_delete';

    /**
     * Delete command
     *
     * @var DeleteByIdInterface
     */
    private $commandDeleteById;

    /**
     * Logger
     *
     * @var LoggerInterface
     */
    private $logger;

    /**
     * Initialize controller
     *
     * @param Context $context
     * @param DeleteByIdInterface $commandDeleteById
     * @param LoggerInterface $logger
     */
    public function __construct(
        Context $context,
        DeleteByIdInterface $commandDeleteById,
        LoggerInterface $logger
    ) {
        $this->commandDeleteById = $commandDeleteById;
        $this->logger = $logger;

        parent::__construct(
            $context
        );
    }

    /**
     * Delete specified region
     *
     * @return ResultInterface
     */
    public function execute(): ResultInterface
    {
        /** @var \Magento\Framework\Controller\Result\Redirect $result */
        $result = $this->resultRedirectFactory->create();

        $regionId = (int)$this->getRequest()->getPost(RegionInterface::REGION_ID);
        if (!$regionId) {
            $this->messageManager->addErrorMessage(
                (string)__('Wrong request.')
            );
            return $result->setPath('*/*');
        }

        try {
            $this->commandDeleteById->execute($regionId);
            $this->messageManager->addSuccessMessage(
                (string)__('The Region has been deleted.')
            );
            $result->setPath('*/*/index');
        } catch (LocalizedException $e) {
            $this->messageManager->addErrorMessage(
                $e->getMessage()
            );
            $result->setPath('*/*/edit', [
                RegionInterface::REGION_ID => $regionId,
                '_current' => true,
            ]);
        } catch (\Exception $e) {
            $this->logger->critical($e->getMessage());
            $this->messageManager->addErrorMessage(
                (string)__('We can\'t delete the region right now. Please review the log and try again.')
            );
            $result->setPath('*/*/edit', [
                RegionInterface::REGION_ID => $regionId,
                '_current' => true,
            ]);
        }
        return $result;
    }
}
