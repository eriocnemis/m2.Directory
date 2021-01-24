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
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Ui\Component\MassAction\Filter;
use Eriocnemis\Directory\Model\ResourceModel\Region\CollectionFactory;

/**
 * Mass delete controller
 */
class MassDelete extends Action implements HttpPostActionInterface
{
    /**
     * Authorization level of a basic admin session
     */
    const ADMIN_RESOURCE = 'Eriocnemis_Directory::region_delete';

    /**
     * Mass action filter
     *
     * @var Filter
     */
    private $filter;

    /**
     * Collection factory
     *
     * @var CollectionFactory
     */
    private $collectionFactory;

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
     * @param CollectionFactory $collectionFactory
     * @param Filter $filter
     * @param LoggerInterface $logger
     */
    public function __construct(
        Context $context,
        CollectionFactory $collectionFactory,
        Filter $filter,
        LoggerInterface $logger
    ) {
        $this->collectionFactory = $collectionFactory;
        $this->filter = $filter;
        $this->logger = $logger;

        parent::__construct(
            $context
        );
    }

    /**
     * Delete specified export jobs
     *
     * @return ResultInterface
     */
    public function execute(): ResultInterface
    {
        if (true !== $this->getRequest()->isPost()) {
            $this->messageManager->addErrorMessage(
                (string)__('Wrong request.')
            );
            return $this->resultRedirectFactory->create()->setPath('*/*');
        }

        try {
            $collection = $this->filter->getCollection(
                $this->collectionFactory->create()
            );

            $size = $collection->getSize();
            if (!$size) {
                $this->messageManager->addError(
                    (string)__('Please correct the regions you requested.')
                );
                return $this->resultRedirectFactory->create()->setPath('*/*');
            }

            $collection->walk('delete');

            $this->messageManager->addSuccess(
                (string)__('You deleted a total of %1 records.', $size)
            );
        } catch (LocalizedException $e) {
            $this->messageManager->addError($e->getMessage());
        } catch (\Exception $e) {
            $this->messageManager->addError(
                (string)__('We can\'t delete these regions right now. Please review the log and try again.')
            );
            $this->logger->critical($e->getMessage());
        }
        return $this->resultRedirectFactory->create()->setPath('*/*');
    }
}
