<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\Directory\Model\ResourceModel;

use Magento\Framework\Api\ObjectFactory;
use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\Locale\ResolverInterface;
use Magento\Framework\Model\ResourceModel\Db\Context;
use Magento\Directory\Model\ResourceModel\Region as AbstractRegion;

/**
 * Region resource
 */
class Region extends AbstractRegion
{
    /**
     * @var ObjectFactory
     */
    protected $objectFactory;

    /**
     * Initialize resource
     *
     * @param Context $context
     * @param ResolverInterface $localeResolver
     * @param ObjectFactory $objectFactory
     * @param string $connectionName
     */
    public function __construct(
        Context $context,
        ResolverInterface $localeResolver,
        ObjectFactory $objectFactory,
        $connectionName = null
    ) {
        $this->objectFactory = $objectFactory;

        parent::__construct(
            $context,
            $localeResolver,
            $connectionName
        );
    }

    /**
     * Retrieve labels data
     *
     * @param int $regionId
     * @return mixed[]
     */
    public function getLabels($regionId): array
    {
        /** @var AdapterInterface $connection */
        $connection = $this->getConnection();
        $select = $connection->select()->from(
            $this->_regionNameTable,
            ['locale', 'name']
        )->where('region_id = ?', (string)$regionId);

        return $connection->fetchPairs($select);
    }

    /**
     * Save label relations
     *
     * @param int $regionId
     * @param mixed[] $labels
     * @return void
     */
    public function saveLabels($regionId, array $labels): void
    {
        $toUpdate = [];
        $toDelete = $this->getLabels($regionId);

        foreach ($labels as $locale => $name) {
            unset($toDelete[$locale]);
            $toUpdate[] = [
                'region_id' => $regionId,
                'locale' => $locale,
                'name' => $name
            ];
        }

        $this->updateLocales($toUpdate);
        $this->deleteLocales($regionId, array_keys($toDelete));
    }

    /**
     * Update labels
     *
     * @param mixed[] $data
     * @return void
     */
    private function updateLocales($data): void
    {
        if (0 < count($data)) {
            /** @var AdapterInterface $connection */
            $connection = $this->getConnection();
            $connection->insertOnDuplicate($this->_regionNameTable, $data);
        }
    }

    /**
     * Delete labels
     *
     * @param int $regionId
     * @param string[] $locales
     * @return void
     */
    private function deleteLocales($regionId, array $locales): void
    {
        if (0 < count($locales)) {
            /** @var AdapterInterface $connection */
            $connection = $this->getConnection();
            $where = ['region_id = ?' => $regionId, 'locale IN (?)' => $locales];
            $connection->delete($this->_regionNameTable, $where);
        }
    }
}
