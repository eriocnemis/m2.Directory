<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\Directory\Test\Unit\Block\Adminhtml\Region\Edit\Tab;

use PHPUnit\Framework\TestCase;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use Eriocnemis\Directory\Block\Adminhtml\Region\Edit\Tab\General as Tab;

/**
 * Test general tab
 */
class GeneralTest extends TestCase
{
    /**
     * Tab block
     *
     * @var Tab
     */
    protected $tab;

    /**
     * Prepare test
     *
     * @return void
     */
    protected function setUp(): void
    {
        $objectManager = new ObjectManager($this);
        $this->tab = $objectManager->getObject(Tab::class);
    }

    /**
     * Test label of tab
     *
     * @return void
     * @test
     */
    public function testGetTabLabel()
    {
        $this->assertEquals('General Information', $this->tab->getTabLabel());
    }

    /**
     * Test title of tab
     *
     * @return void
     * @test
     */
    public function testGetTabTitle()
    {
        $this->assertEquals('General Information', $this->tab->getTabTitle());
    }

    /**
     * Test visibility tab
     *
     * @return void
     * @test
     */
    public function testCanShowTab()
    {
        $this->assertTrue($this->tab->canShowTab());
    }

    /**
     * Test hiding tab
     *
     * @return void
     * @test
     */
    public function testIsHidden()
    {
        $this->assertFalse($this->tab->isHidden());
    }
}
