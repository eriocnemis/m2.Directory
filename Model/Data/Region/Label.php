<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\Directory\Model\Data\Region;

use Magento\Framework\Api\AbstractSimpleObject;
use Eriocnemis\Directory\Api\Data\Region\LabelInterface;

/**
 * Region label data model
 *
 * @api
 */
class Label extends AbstractSimpleObject implements LabelInterface
{
    /**
     * Retrieve name
     *
     * @return string
     */
    public function getName()
    {
        return $this->_get(self::NAME);
    }

    /**
     * Set name
     *
     * @param string $name
     * @return void
     */
    public function setName($name)
    {
        $this->setData(self::NAME, $name);
    }

    /**
     * Retrieve locale
     *
     * @return string
     */
    public function getLocale()
    {
        return $this->_get(self::LOCALE);
    }

    /**
     * Set locale
     *
     * @param string $locale
     * @return void
     */
    public function setLocale($locale)
    {
        $this->setData(self::LOCALE, $locale);
    }
}
