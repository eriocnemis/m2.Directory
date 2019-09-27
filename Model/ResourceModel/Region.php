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
     * Perform actions after object save
     *
     * @param AbstractModel $object
     * @return $this
     */
    protected function _afterSave(AbstractModel $object)
    {
        if ($object->hasLabels() && is_array($object->getLabels())) {
            $this->saveLabels($object);
        }
        return parent::_afterSave($object);
    }

    /**
     * Save locale relations
     *
     * @param AbstractModel $object
     * @return void
     */
    protected function saveLabels(AbstractModel $object)
    {
        $regionId = $object->getId();
        foreach ($object->getLabels() as $code => $data) {
            $isNew = !(false === strpos($code, 'option_'));
            if (!empty($data['delete'])) {
                $this->deleteLocale($regionId, $data['locale'], $isNew);
                continue;
            }
            $this->updateLocale($regionId, $data['locale'], $data['name'], $isNew);
        }
    }

    /**
     * Update locale
     *
     * @param string $regionId
     * @param string $locale
     * @param string $name
     * @param boolean $isNew
     * @return void
     */
    protected function updateLocale($regionId, $locale, $name, $isNew = true)
    {
        $data = ['name' => $name];
        /** @var AdapterInterface $connection */
        $connection = $this->getConnection();
        if ($isNew) {
            $data = array_merge($data, ['region_id' => $regionId, 'locale' => $locale]);
            $connection->insert($this->_regionNameTable, $data);
        } else {
            $where = ['region_id = ?' => $regionId, 'locale = ?' => $locale];
            $connection->update($this->_regionNameTable, $data, $where);
        }
    }

    /**
     * Delete locale
     *
     * @param string $regionId
     * @param string $locale
     * @param boolean $isNew
     * @return void
     */
    protected function deleteLocale($regionId, $locale, $isNew = true)
    {
        if (!$isNew) {
            /** @var AdapterInterface $connection */
            $connection = $this->getConnection();
            $where = ['region_id = ?' => $regionId, 'locale = ?' => $locale];
            $connection->delete($this->_regionNameTable, $where);
        }
    }
}
