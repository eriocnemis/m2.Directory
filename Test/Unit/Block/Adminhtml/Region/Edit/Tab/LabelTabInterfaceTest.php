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
use Eriocnemis\Directory\Block\Adminhtml\Region\Edit\Tab\Label as Tab;

/**
 * Test label tab
 */
class LabelTabInterfaceTest extends TestCase
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
     * Test label of tab
     *
     * @return void
     * @test
     */
    public function testGetTabLabel()
    {
        $this->assertEquals('Labels', $this->tab->getTabLabel());
    }

    /**
     * Test title of tab
     *
     * @return void
     * @test
     */
    public function testGetTabTitle()
    {
        $this->assertEquals('Labels', $this->tab->getTabTitle());
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
