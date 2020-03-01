<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Eriocnemis\Directory\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;

/**
 * Status source
 */
class Status implements ArrayInterface
{
    /**
     * Retrieve options as array
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => 0, 'label' => __('Inactive')],
            ['value' => 1, 'label' => __('Active')]
        ];
    }

    /**
     * Retrieve options in key-value format
     *
     * @return array
     */
    public function toArray()
    {
        return [
            0 => __('Inactive'),
            1 => __('Active')
        ];
    }
}
