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
use Magento\Framework\Validation\ValidationException;
use Magento\Framework\App\Request\DataPersistorInterface;
use Eriocnemis\Directory\Api\Data\RegionInterface;
use Eriocnemis\Directory\Api\Region\ResolveInterface;
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
     * Resolve command
     *
     * @var ResolveInterface
     */
    private $commandResolve;

    /**
     * Save command
     *
     * @var SaveInterface
     */
    private $commandSave;

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
     * @param ResolveInterface $commandResolve
     * @param SaveInterface $commandSave
     * @param DataPersistorInterface $dataPersistor
     * @param LoggerInterface $logger
     */
    public function __construct(
        Context $context,
        ResolveInterface $commandResolve,
        SaveInterface $commandSave,
        DataPersistorInterface $dataPersistor,
        LoggerInterface $logger
    ) {
        $this->commandResolve = $commandResolve;
        $this->commandSave = $commandSave;
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
        $regionId = $data[RegionInterface::REGION_ID] ?? null;

        /** @var ResultInterface $result */
        $result = $this->resultRedirectFactory->create();
        if (!$this->getRequest()->isPost() || empty($data)) {
            $this->messageManager->addErrorMessage(
                (string)__('Wrong request.')
            );
            $this->redirectAfterFailure($result);
            return $result;
        }

        try {
            $this->dataPersistor->set('eriocnemis_region', $data);
            $region = $this->commandResolve->execute($regionId, $data);
            $this->commandSave->execute($region);
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
