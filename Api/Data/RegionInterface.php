<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\Directory\Api\Data;

/**
 * Basic interface with data needed for region
 *
 * @api
 */
interface RegionInterface
{
    /**
     * Field region id
     */
    const REGION_ID = 'region_id';

    /**
     * Field country id
     */
    const COUNTRY_ID = 'country_id';

    /**
     * Field code
     */
    const CODE = 'code';

    /**
     * Field default name
     */
    const DEFAULT_NAME = 'default_name';

    /**
     * Field labels
     */
    const LABELS = 'labels';

    /**
     * Field Status
     */
    const STATUS = 'status';

    /**
     * Retrieve region id
     *
     * @return int|null
     */
    public function getId();

    /**
     * Set region id
     *
     * @param int $regionId
     * @return void
     */
    public function setId($regionId): void;

    /**
     * Retrieve country id
     *
     * @return string
     */
    public function getCountryId(): string;

    /**
     * Set country id
     *
     * @param string $countryId
     * @return void
     */
    public function setCountryId($countryId): void;

    /**
     * Retrieve the region code
     *
     * @return string
     */
    public function getCode(): string;

    /**
     * Set the region code
     *
     * @param string $code
     * @return void
     */
    public function setCode($code): void;

    /**
     * Retrieve region default name
     *
     * @return string
     */
    public function getDefaultName(): string;

    /**
     * Set region default name
     *
     * @param string $name
     * @return void
     */
    public function setDefaultName($name): void;

    /**
     * Retrieve the region labels
     *
     * @return \Eriocnemis\Directory\Api\Data\Region\LabelInterface[]
     */
    public function getLabels(): array;

    /**
     * Set the region labels
     *
     * @param \Eriocnemis\Directory\Api\Data\Region\LabelInterface[] $labels
     * @return void
     */
    public function setLabels($labels): void;

    /**
     * Retrieve the region status
     *
     * @return int
     */
    public function getStatus(): int;

    /**
     * Set the region status
     *
     * @param int $status
     * @return void
     */
    public function setStatus($status): void;
}
