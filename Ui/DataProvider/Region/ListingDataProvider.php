<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\Directory\Ui\DataProvider\Region;

use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\Search\ReportingInterface;
use Magento\Framework\Api\Search\SearchCriteriaBuilder;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\View\Element\UiComponent\DataProvider\DataProvider;
use Magento\Ui\DataProvider\Modifier\PoolInterface;
use Magento\Ui\DataProvider\Modifier\ModifierInterface;

/**
 * Data provider for admin grid
 *
 * @api
 */
class ListingDataProvider extends DataProvider
{
    /**
     * Modifier pool
     *
     * @var PoolInterface
     */
    private $modifierPool;

    /**
     * Initialize provider
     *
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param ReportingInterface $reporting
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param RequestInterface $request
     * @param FilterBuilder $filterBuilder
     * @param PoolInterface $modifierPool
     * @param mixed[] $meta
     * @param mixed[] $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        ReportingInterface $reporting,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        RequestInterface $request,
        FilterBuilder $filterBuilder,
        PoolInterface $modifierPool,
        array $meta = [],
        array $data = []
    ) {
        $this->modifierPool = $modifierPool;

        parent::__construct(
            $name,
            $primaryFieldName,
            $requestFieldName,
            $reporting,
            $searchCriteriaBuilder,
            $request,
            $filterBuilder,
            $meta,
            $data
        );
    }

    /**
     * Retrieve data
     *
     * @return mixed[]
     */
    public function getData()
    {
        $data = parent::getData();
        /** @var ModifierInterface $modifier */
        foreach ($this->modifierPool->getModifiersInstances() as $modifier) {
            $data = $modifier->modifyData($data);
        }
        return $data;
    }

    /**
     * Retrieve meta data
     *
     * @return mixed[]
     */
    public function getMeta()
    {
        $meta = parent::getMeta();
        /** @var ModifierInterface $modifier */
        foreach ($this->modifierPool->getModifiersInstances() as $modifier) {
            $meta = $modifier->modifyMeta($meta);
        }
        return $meta;
    }
}
