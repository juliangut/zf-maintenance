<?php
/**
 * JgutZfMaintenance Module (https://github.com/juliangut/zf-maintenance)
 *
 * @link https://github.com/juliangut/zf-maintenance for the canonical source repository
 * @license https://raw.githubusercontent.com/juliangut/zf-maintenance/master/LICENSE
 */

namespace JgutZfMaintenanceTest\View;

use PHPUnit_Framework_TestCase;
use JgutZfMaintenance\Options\ModuleOptions;
use JgutZfMaintenance\View\MaintenanceStrategy;

/**
 * @covers JgutZfMaintenance\View\MaintenanceStrategy
 */
class MaintenanceStrategyTest extends PHPUnit_Framework_TestCase
{
    protected $strategy;

    public function setUp()
    {
        parent::setUpBeforeClass();

        $options  = new ModuleOptions(array());
        $this->strategy = new maintenanceStrategy($options->getTemplate());
    }

    /**
     * @covers JgutZfMaintenance\View\MaintenanceStrategy::setTemplate
     * @covers JgutZfMaintenance\View\MaintenanceStrategy::getTemplate
     * @uses JgutZfMaintenance\Options\ModuleOptions
     */
    public function testTemplate()
    {
        $this->assertEquals('zf-maintenance/maintenance', $this->strategy->getTemplate());

        $this->strategy->setTemplate('myTemplate');
        $this->assertEquals('myTemplate', $this->strategy->getTemplate());
    }

    /**
     * @covers JgutZfMaintenance\View\MaintenanceStrategy::attach
     * @covers JgutZfMaintenance\View\MaintenanceStrategy::detach
     * @uses JgutZfMaintenance\Options\ModuleOptions
     */
    public function testAttachDetach()
    {
        $eventManager = $this->getMock('Zend\\EventManager\\EventManagerInterface');
        $callbackMock = $this->getMock('Zend\\Stdlib\\CallbackHandler', array(), array(), '', false);

        $eventManager
            ->expects($this->once())
            ->method('attach')
            ->with()
            ->will($this->returnValue($callbackMock));
        $this->strategy->attach($eventManager);

        $eventManager
            ->expects($this->once())
            ->method('detach')
            ->with($callbackMock)
            ->will($this->returnValue(true));
        $this->strategy->detach($eventManager);
    }
}
