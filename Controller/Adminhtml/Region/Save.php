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
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Validation\ValidationException;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\App\Request\DataPersistorInterface;
use Eriocnemis\Directory\Api\Data\RegionInterface;
use Eriocnemis\Directory\Api\Data\RegionInterfaceFactory;
use Eriocnemis\Directory\Api\Region\GetByIdInterface;
use Eriocnemis\Directory\Api\Region\SaveInterface;

/**
 * Save controller
 */
class Save extends Action implements HttpPostActionInterface
{
    /**
     * Authorization level of a basic admin session
     */
    const ADMIN_RESOURCE = 'Eriocnemis_Directory::region_edit';

    /**
     * Region factory
     *
     * @var RegionInterfaceFactory
     */
    private $factory;

    /**
     * Get by id command
     *
     * @var GetByIdInterface
     */
    private $commandGetById;

    /**
     * Save command
     *
     * @var SaveInterface
     */
    private $commandSave;

    /**
     * Data object helper
     *
     * @var DataObjectHelper
     */
    private $dataObjectHelper;

    /**
     * Data persistor
     *
     * @var DataPersistorInterface
     */
    private $dataPersistor;

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
     * @param RegionInterfaceFactory $factory
     * @param GetByIdInterface $commandGetById
     * @param SaveInterface $commandSave
     * @param DataObjectHelper $dataObjectHelper
     * @param DataPersistorInterface $dataPersistor
     * @param LoggerInterface $logger
     */
    public function __construct(
        Context $context,
        RegionInterfaceFactory $factory,
        GetByIdInterface $commandGetById,
        SaveInterface $commandSave,
        DataObjectHelper $dataObjectHelper,
        DataPersistorInterface $dataPersistor,
        LoggerInterface $logger
    ) {
        $this->factory = $factory;
        $this->commandGetById = $commandGetById;
        $this->commandSave = $commandSave;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataPersistor = $dataPersistor;
        $this->logger = $logger;

        parent::__construct(
            $context
        );
    }

    /**
     * Save region
     *
     * @return ResultInterface
     */
    public function execute(): ResultInterface
    {
        $data = $this->getRequest()->getPost('region');
        /** @var ResultInterface $result */
        $result = $this->resultRedirectFactory->create();

        if (!$this->getRequest()->isPost() || empty($data)) {
            $this->messageManager->addErrorMessage(
                (string)__('Wrong request.')
            );
            $this->redirectAfterFailure($result);
            return $result;
        }

        $regionId = $data[RegionInterface::REGION_ID] ?? null;
        try {
            $region = $this->initRegion($regionId);
            $this->processSave($region, $data);
            $this->messageManager->addSuccessMessage(
                (string)__('The Region has been saved.')
            );
            $this->redirectAfterSuccess($result, (int)$region->getId());
        } catch (ValidationException $e) {
            foreach ($e->getErrors() as $error) {
                $this->messageManager->addErrorMessage(
                    $error->getMessage()
                );
            }
            $this->redirectAfterFailure($result, $regionId);
        } catch (LocalizedException $e) {
            $this->messageManager->addErrorMessage(
                $e->getMessage()
            );
            $this->redirectAfterFailure($result, $regionId);
        } catch (\Exception $e) {
            $this->logger->critical($e->getMessage());
            $this->messageManager->addErrorMessage(
                (string)__('We can\'t save the region right now. Please review the log and try again.')
            );
            $this->redirectAfterFailure($result, $regionId);
        }
        return $result;
    }

    /**
     * Initialize region
     *
     * @param int|null $regionId
     * @return RegionInterface
     * @throws NoSuchEntityException
     */
    private function initRegion($regionId): RegionInterface
    {
        return null !== $regionId
            ? $this->commandGetById->execute((int)$regionId)
            : $this->factory->create();
    }

    /**
     * Hydrate data from request and save region
     *
     * @param RegionInterface $region
     * @param mixed[] $data
     * @return void
     * @throws CouldNotSaveException
     * @throws ValidationException
     */
    private function processSave(RegionInterface $region, array $data): void
    {
        $this->dataPersistor->set('eriocnemis_region', $data);
        $this->dataObjectHelper->populateWithArray($region, $data, RegionInterface::class);
        $this->commandSave->execute($region);
    }

    /**
     * Retrieve redirect url after save
     *
     * @param ResultInterface $result
     * @param int $regionId
     * @return void
     */
    private function redirectAfterSuccess(ResultInterface $result, $regionId): void
    {
        $path = '*/*/';
        $params = [];
        if ($this->getRequest()->getParam('back')) {
            $path = '*/*/edit';
            $params = ['_current' => true, RegionInterface::REGION_ID => $regionId];
        } elseif ($this->getRequest()->getParam('redirect_to_new')) {
            $path = '*/*/new';
            $params = ['_current' => true];
        }
        $result->setPath($path, $params);
    }

    /**
     * Retrieve redirect url after unsuccessful save
     *
     * @param ResultInterface $result
     * @param int|null $regionId
     * @return void
     */
    private function redirectAfterFailure(ResultInterface $result, $regionId = null): void
    {
        if (null === $regionId) {
            $result->setPath('*/*/new');
        } else {
            $result->setPath(
                '*/*/edit',
                [RegionInterface::REGION_ID => $regionId, '_current' => true]
            );
        }
    }
}
