<?php
/**
 * JgutZfMaintenance Module (https://github.com/juliangut/zf-maintenance)
 *
 * @link https://github.com/juliangut/zf-maintenance for the canonical source repository
 * @license https://raw.githubusercontent.com/juliangut/zf-maintenance/master/LICENSE
 */

namespace JgutZfMaintenanceTest\View;

use PHPUnit_Framework_TestCase;
use JgutZfMaintenance\View\MaintenanceStrategy;

/**
 * @covers JgutZfMaintenance\View\MaintenanceStrategy
 */
class MaintenanceStrategyTest extends PHPUnit_Framework_TestCase
{
    protected $strategy;

    public function setUp()
    {
        $this->strategy = new maintenanceStrategy('zf-maintenance/maintenance');
    }

    /**
     * @covers JgutZfMaintenance\View\MaintenanceStrategy::setTemplate
     * @covers JgutZfMaintenance\View\MaintenanceStrategy::getTemplate
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

    public function testNoRoute()
    {
        $event = $this->getMock('Zend\\Mvc\\MvcEvent', array(), array(), '', false);
        $event->expects($this->any())->method('getRouteMatch')->will($this->returnValue(false));

        $this->assertNull($this->strategy->onRoute($event));
    }

    public function testOnRoute()
    {
        $serviceManager = $this->getMock('Zend\\serviceManager\\ServiceLocatorInterface');

        $application = $this->getMock('«end\\Mvc\\ApplicationInterface');
        $application->expects($this->any())->method('getServiceManager')->will($this->returnValue($serviceManager));

        $routeMatch = $this->getMock('Zend\\Mvc\\Router\\RouteMatch', array(), array(), '', false);

        $event = $this->getMock('Zend\\Mvc\\MvcEvent', array(), array(), '', false);
        $event->expects($this->any())->method('getRouteMatch')->will($this->returnValue($routeMatch));
        $event->expects($this->any())->method('getApplication')->will($this->returnValue($application));
    }
}
