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
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\View\Element\UiComponent\DataProvider\DataProvider;
use Magento\Ui\DataProvider\Modifier\PoolInterface;
use Magento\Ui\DataProvider\Modifier\ModifierInterface;
use Eriocnemis\Directory\Api\Region\GetByIdInterface;

/**
 * Data provider for admin export job form
 *
 * @api
 */
class FormDataProvider extends DataProvider
{
    /**
     * Get region by id command
     *
     * @var GetByIdInterface
     */
    private $commandGetById;

    /**
     * Modifier pool
     *
     * @var PoolInterface
     */
    private $modifierPool;

    /**
     * Data persistor
     *
     * @var DataPersistorInterface
     */
    private $dataPersistor;

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
     * @param GetByIdInterface $commandGetById
     * @param DataPersistorInterface $dataPersistor
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
        GetByIdInterface $commandGetById,
        DataPersistorInterface $dataPersistor,
        PoolInterface $modifierPool,
        array $meta = [],
        array $data = []
    ) {
        $this->commandGetById = $commandGetById;
        $this->dataPersistor = $dataPersistor;
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
        $regionId = $this->getRegionId();
        if (!isset($this->data[$regionId])) {
            $this->data[$regionId]['region'] = $this->modifyData($this->loadData($regionId));
        }
        return $this->data;
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

    /**
     * Retrieve region id
     *
     * @return int
     */
    private function getRegionId(): int
    {
        return (int)$this->request->getParam($this->getRequestFieldName());
    }

    /**
     * Retrieve region data
     *
     * @param int $regionId
     * @return mixed[]
     */
    private function loadData($regionId): array
    {
        $data = [];
        if ($regionId) {
            $data = $this->dataPersistor->get('eriocnemis_region');
            if (empty($data['region_id']) || $data['region_id'] != $regionId) {
                $data = $this->commandGetById->execute($regionId)->__toArray();
                $this->dataPersistor->set('eriocnemis_region', $data);
            }
        }
        return $data;
    }

    /**
     * Retrieve modifier data
     *
     * @param  mixed[] $data
     * @return mixed[]
     */
    private function modifyData(array $data): array
    {
        /** @var ModifierInterface $modifier */
        foreach ($this->modifierPool->getModifiersInstances() as $modifier) {
            $data = $modifier->modifyData($data);
        }
        return $data;
    }
}
