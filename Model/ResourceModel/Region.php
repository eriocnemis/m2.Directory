<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Eriocnemis\Directory\Model\ResourceModel;

use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\Model\AbstractModel;
use Magento\Directory\Model\ResourceModel\Region as AbstractRegion;

/**
 * Region resource
 */
class Region extends AbstractRegion
{
    /**
     * Retrieve labels data
     *
     * @param string $regionId
     * @return array
     */
    public function getLabels($regionId)
    {
        /** @var AdapterInterface $connection */
        $connection = $this->getConnection();
        $select = $connection->select()->from(
            $this->_regionNameTable,
            ['locale', 'name']
        )->where('region_id = ?', $regionId);

        return $connection->fetchPairs($select);
    }

    /**
     * Save locale relations
     *
     * @param int $regionId
     * @param array $labels
     * @return void
     */
    public function saveLabels($regionId, array $labels)
    {
        $data = [];
        $toDelete = [];

        foreach ($labels as $code => $label) {
            if (!empty($label['delete'])) {
                $toDelete[] = $label['locale'];
                continue;
            }

            $data[] = [
                'region_id' => $regionId,
                'locale' => $label['locale'],
                'name' => $label['name']
            ];
        }

        $this->updateLocale($data);
        $this->deleteLocale($regionId, $toDelete);
    }

    /**
     * Update locales
     *
     * @param array $data
     * @return void
     */
    protected function updateLocale($data)
    {
        if (0 < count($data)) {
            /** @var AdapterInterface $connection */
            $connection = $this->getConnection();
            $connection->insertOnDuplicate($this->_regionNameTable, $data);
        }
    }

    /**
     * Delete locales
     *
     * @param int $regionId
     * @param string[] $locales
     * @return void
     */
    protected function deleteLocale($regionId, array $locales)
    {
        if (0 < count($locales)) {
            /** @var AdapterInterface $connection */
            $connection = $this->getConnection();
            $where = ['region_id = ?' => $regionId, 'locale IN (?)' => $locales];
            $connection->delete($this->_regionNameTable, $where);
        }
    }
}
