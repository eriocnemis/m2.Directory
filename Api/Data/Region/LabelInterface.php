<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\Directory\Api\Data\Region;

/**
 * Basic interface with data needed for region label
 *
 * @api
 */
interface LabelInterface
{
    /**
     * Field name
     */
    const NAME = 'name';

    /**
     * Field locale
     */
    const LOCALE = 'locale';

    /**
     * Retrieve name
     *
     * @return string
     */
    public function getName();

    /**
     * Set name
     *
     * @param string $name
     * @return void
     */
    public function setName($name);

    /**
     * Retrieve locale
     *
     * @return string
     */
    public function getLocale();

    /**
     * Set locale
     *
     * @param string $locale
     * @return void
     */
    public function setLocale($locale);
}
