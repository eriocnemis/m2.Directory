<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Eriocnemis\Directory\Controller\Adminhtml;

use Magento\Framework\Registry;
use Magento\Framework\Exception\LocalizedException;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use Psr\Log\LoggerInterface;
use Eriocnemis\Directory\Model\ResourceModel\Region\CollectionFactory as RegionCollectionFactory;
use Eriocnemis\Directory\Model\RegionFactory;
use Eriocnemis\Directory\Model\Constant;

/**
 * Region abstract controller
 */
abstract class Region extends Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Magento_Backend::directory_region';

    /**
     * Core registry
     *
     * @var Registry
     */
    protected $coreRegistry;

    /**
     * Region collection factory
     *
     * @var RegionCollectionFactory
     */
    protected $collectionFactory;

    /**
     * Logger
     *
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * Mass action filter
     *
     * @var Filter
     */
    protected $filter;

    /**
     * Model factory
     *
     * @var RegionFactory
     */
    protected $regionFactory;

    /**
     * Initialize controller
     *
     * @param Context $context
     * @param Registry $coreRegistry
     * @param LoggerInterface $logger
     * @param RegionCollectionFactory $collectionFactory
     * @param RegionFactory $regionFactory
     * @param Filter $filter
     */
    public function __construct(
        Context $context,
        Registry $coreRegistry,
        LoggerInterface $logger,
        RegionCollectionFactory $collectionFactory,
        RegionFactory $regionFactory,
        Filter $filter
    ) {
        $this->logger = $logger;
        $this->coreRegistry = $coreRegistry;
        $this->collectionFactory = $collectionFactory;
        $this->regionFactory = $regionFactory;
        $this->filter = $filter;

        parent::__construct(
            $context
        );
    }

    /**
     * Initialize proper region
     *
     * @return \Eriocnemis\Directory\Model\Region
     * @throws LocalizedException
     */
    protected function initRegion()
    {
        $regionId = $this->getRequest()->getParam('region_id', null);
        $region = $this->regionFactory->create();

        if ($regionId) {
            $region->load($regionId);
            if (!$region->getId()) {
                throw new LocalizedException(
                    __('Please correct the region you requested.')
                );
            }
        }

        /* register current region */
        $this->coreRegistry->register(
            Constant::CURRENT_REGION,
            $region
        );

        /* register current region id */
        $this->coreRegistry->register(
            Constant::CURRENT_REGION_ID,
            $region->getId()
        );

        return $region;
    }
}
