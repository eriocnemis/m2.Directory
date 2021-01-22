<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\Directory\Spi\Region;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Eriocnemis\Directory\Api\Data\RegionSearchResultInterface;
use Eriocnemis\Directory\Api\Data\RegionSearchResultInterfaceFactory;
use Eriocnemis\Directory\Api\Region\GetListInterface;
use Eriocnemis\Directory\Model\ResourceModel\Region\Collection;
use Eriocnemis\Directory\Model\ResourceModel\Region\CollectionFactory;

/**
 * Find regions by search criteria command
 *
 * @api
 */
class GetList implements GetListInterface
{
    /**
     * Collection processor
     *
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;

    /**
     * Collection factory
     *
     * @var CollectionFactory
     */
    private $collectionFactory;

    /**
     * Region search result
     *
     * @var RegionSearchResultInterfaceFactory
     */
    private $searchResultsFactory;

    /**
     * Search criteria builder
     *
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

    /**
     * Initialize command
     *
     * @param CollectionFactory $collectionFactory
     * @param CollectionProcessorInterface $collectionProcessor
     * @param RegionSearchResultInterfaceFactory $searchResultsFactory
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     */
    public function __construct(
        CollectionFactory $collectionFactory,
        CollectionProcessorInterface $collectionProcessor,
        RegionSearchResultInterfaceFactory $searchResultsFactory,
        SearchCriteriaBuilder $searchCriteriaBuilder
    ) {
        $this->collectionFactory = $collectionFactory;
        $this->collectionProcessor = $collectionProcessor;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    /**
     * Retrieve list of regions
     *
     * @param SearchCriteriaInterface|null $searchCriteria
     * @return RegionSearchResultInterface
     */
    public function execute(SearchCriteriaInterface $searchCriteria = null)
    {
        /** @var Collection $collection */
        $collection = $this->collectionFactory->create();

        if (null === $searchCriteria) {
            $searchCriteria = $this->searchCriteriaBuilder->create();
        } else {
            $this->collectionProcessor->process($searchCriteria, $collection);
        }

        /** @var RegionSearchResultInterface $searchResult */
        $searchResult = $this->searchResultsFactory->create();
        $searchResult->setItems($collection->getItems());
        $searchResult->setTotalCount($collection->getSize());
        $searchResult->setSearchCriteria($searchCriteria);

        return $searchResult;
    }
}
