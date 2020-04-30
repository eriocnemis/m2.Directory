<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\Directory\Test\Unit\Model\Config\Source\Address;

use PHPUnit\Framework\TestCase;
use Eriocnemis\Directory\Model\Config\Source\Status as Source;

/**
 * Test status source
 */
class StatusTest extends TestCase
{
    /**
     * Source model
     *
     * @var Source
     */
    protected $source;

    /**
     * Source options
     *
     * @var array
     */
    protected $options = [
        '0' => 'Inactive',
        '1' => 'Active'
    ];

    /**
     * Prepare test
     *
     * @return void
     */
    protected function setUp(): void
    {
        $this->source = new Source;
    }

    /**
     * Test options in key-value format
     *
     * @return void
     * @test
     */
    public function testToArray()
    {
        $this->assertEquals($this->options, $this->source->toArray());
    }

    /**
     * Test options
     *
     * @return void
     * @test
     */
    public function testToOptionArray()
    {
        $expected = [];
        foreach ($this->options as $value => $label) {
            $expected[] = ['value' => $value, 'label' => $label];
        }
        $this->assertEquals($expected, $this->source->toOptionArray());
    }
}
