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
use Eriocnemis\Directory\Api\Data\Region\SearchResultInterface;
use Eriocnemis\Directory\Api\Data\Region\SearchResultInterfaceFactory;
use Eriocnemis\Directory\Api\Region\GetListInterface;
use Eriocnemis\Directory\Model\Region\Converter\ToDataConverter;
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
     * @var SearchResultInterfaceFactory
     */
    private $searchResultsFactory;

    /**
     * Search criteria builder
     *
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

    /**
     * Region model converter
     *
     * @var ToDataConverter
     */
    private $toDataConverter;

    /**
     * Initialize command
     *
     * @param CollectionFactory $collectionFactory
     * @param CollectionProcessorInterface $collectionProcessor
     * @param SearchResultInterfaceFactory $searchResultsFactory
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param ToDataConverter $toDataConverter
     */
    public function __construct(
        CollectionFactory $collectionFactory,
        CollectionProcessorInterface $collectionProcessor,
        SearchResultInterfaceFactory $searchResultsFactory,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        ToDataConverter $toDataConverter
    ) {
        $this->collectionFactory = $collectionFactory;
        $this->collectionProcessor = $collectionProcessor;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->toDataConverter = $toDataConverter;
    }

    /**
     * Retrieve list of regions
     *
     * @param SearchCriteriaInterface|null $searchCriteria
     * @return SearchResultInterface
     */
    public function execute(SearchCriteriaInterface $searchCriteria = null): SearchResultInterface
    {
        $collection = $this->collectionFactory->create();
        if (null === $searchCriteria) {
            $searchCriteria = $this->searchCriteriaBuilder->create();
        } else {
            $this->collectionProcessor->process($searchCriteria, $collection);
        }

        $items = [];
        /** @var \Eriocnemis\Directory\Model\Region $model */
        foreach ($collection->getItems() as $model) {
            $model->afterLoad();
            $items[] = $this->toDataConverter->convert($model);
        }

        /** @var SearchResultInterface $searchResult */
        $searchResult = $this->searchResultsFactory->create();
        $searchResult->setItems($items);
        $searchResult->setTotalCount($collection->getSize());
        $searchResult->setSearchCriteria($searchCriteria);

        return $searchResult;
    }
}
