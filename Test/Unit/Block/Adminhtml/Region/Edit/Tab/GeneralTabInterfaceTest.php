<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\Directory\Test\Unit\Block\Adminhtml\Region\Edit\Tab;

use PHPUnit\Framework\TestCase;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use Magento\Backend\Block\Widget\Tab\TabInterface;
use Eriocnemis\Directory\Block\Adminhtml\Region\Edit\Tab\General as Tab;

/**
 * Test general tab
 */
class GeneralTabInterfaceTest extends TestCase
{
    /**
     * Tab block
     *
     * @var TabInterface
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
        /** @var TabInterface $tab */
        $tab = $objectManager->getObject(Tab::class);
        if ($tab instanceof TabInterface) {
            $this->tab = $tab;
        }
    }

    /**
     * Check Tab label
     *
     * @return void
     * @test
     */
    public function testGetTabLabel()
    {
        $this->assertEquals('General Information', $this->tab->getTabLabel());
    }

    /**
     * Check Tab title
     *
     * @return void
     * @test
     */
    public function testGetTabTitle()
    {
        $this->assertEquals('General Information', $this->tab->getTabTitle());
    }

    /**
     * Check Tab visibility
     *
     * @return void
     * @test
     */
    public function testCanShowTab()
    {
        $this->assertTrue($this->tab->canShowTab());
    }

    /**
     * Check Tab hiding
     *
     * @return void
     * @test
     */
    public function testIsHidden()
    {
        $this->assertFalse($this->tab->isHidden());
    }
}
