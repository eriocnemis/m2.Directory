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
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Validation\ValidationException;
use Eriocnemis\Directory\Api\Data\RegionInterface;
use Eriocnemis\Directory\Api\Region\ResolveInterface;
use Eriocnemis\Directory\Api\Region\ValidateInterface;

/**
 * Region validate
 */
class Validate extends Action implements HttpPostActionInterface
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
     * Validate command
     *
     * @var ValidateInterface
     */
    private $commandValidate;

    /**
     * Result json factory
     *
     * @var JsonFactory
     */
    private $resultJsonFactory;

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
     * @param JsonFactory $resultJsonFactory
     * @param ResolveInterface $commandResolve
     * @param ValidateInterface $commandValidate
     * @param LoggerInterface $logger
     */
    public function __construct(
        Context $context,
        JsonFactory $resultJsonFactory,
        ResolveInterface $commandResolve,
        ValidateInterface $commandValidate,
        LoggerInterface $logger
    ) {
        $this->commandResolve = $commandResolve;
        $this->commandValidate = $commandValidate;
        $this->resultJsonFactory = $resultJsonFactory;
        $this->logger = $logger;

        parent::__construct(
            $context
        );
    }

    /**
     * Validate region
     *
     * @return ResultInterface
     */
    public function execute(): ResultInterface
    {
        $response = ['error' => true];
        $data = $this->getRequest()->getPost('region');
        $regionId = $data[RegionInterface::REGION_ID] ?? null;

        try {
            $region = $this->commandResolve->execute($regionId, $data);
            $this->commandValidate->execute($region);
            $response = ['error' => false];
        } catch (ValidationException $e) {
            $response['messages'] = [];
            foreach ($e->getErrors() as $error) {
                $response['messages'][] = $error->getMessage();
            }
        } catch (LocalizedException $e) {
            $response['message'] = $e->getMessage();
        } catch (\Exception $e) {
            $this->logger->critical($e->getMessage());
            $response['message'] = __('We can\'t save the region right now. Please review the log and try again.');
        }
        return $this->resultJsonFactory->create()->setData($response);
    }
}
