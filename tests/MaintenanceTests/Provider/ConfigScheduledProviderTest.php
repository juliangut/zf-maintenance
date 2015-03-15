<?php
/**
 * Juliangut Zend Framework Maintenance Module Module (https://github.com/juliangut/zf-maintenance)
 *
 * @link https://github.com/juliangut/zf-maintenance for the canonical source repository
 * @license https://raw.githubusercontent.com/juliangut/zf-maintenance/master/LICENSE
 */

namespace Jgut\Zf\MaintenanceTests\Exclusion;

use PHPUnit_Framework_TestCase;
use Jgut\Zf\Maintenance\Provider\ConfigScheduledProvider;

/**
 * @covers Jgut\Zf\Maintenance\Provider\ConfigScheduledProvider
 */
class ConfigScheduledProviderTest extends PHPUnit_Framework_TestCase
{
    /**
     * @covers Jgut\Zf\Maintenance\Provider\AbstractProvider::attach
     * @covers Jgut\Zf\Maintenance\Provider\AbstractProvider::detach
     */
    public function testAttachDetach()
    {
        $eventManager = $this->getMock('Zend\\EventManager\\EventManagerInterface');
        $callbackMock = $this->getMock('Zend\\Stdlib\\CallbackHandler', array(), array(), '', false);

        $provider = new ConfigScheduledProvider();

        $eventManager
            ->expects($this->once())
            ->method('attach')
            ->with()
            ->will($this->returnValue($callbackMock));
        $provider->attach($eventManager);

        $eventManager
            ->expects($this->once())
            ->method('detach')
            ->with($callbackMock)
            ->will($this->returnValue(true));
        $provider->detach($eventManager);
    }

    /**
     * @covers Jgut\Zf\Maintenance\Provider\ConfigScheduledProvider::isActive
     * @covers Jgut\Zf\Maintenance\Provider\ConfigScheduledProvider::isScheduled
     * @covers Jgut\Zf\Maintenance\Provider\ConfigScheduledProvider::getScheduleTimes
     * @covers Jgut\Zf\Maintenance\Provider\ConfigScheduledProvider::onRoute
     */
    public function testDefaults()
    {
        $provider = new ConfigScheduledProvider();

        $event = $this->getMock('Zend\\Mvc\\MvcEvent', array(), array(), '', false);

        $this->assertFalse($provider->isActive());
        $this->assertFalse($provider->isScheduled());
        $this->assertEquals(array(), $provider->getScheduleTimes());
        $this->assertNull($provider->onRoute($event));
    }

    /**
     * @covers Jgut\Zf\Maintenance\Provider\ConfigScheduledProvider::setStart
     * @covers Jgut\Zf\Maintenance\Provider\ConfigScheduledProvider::getStart
     * @covers Jgut\Zf\Maintenance\Provider\ConfigScheduledProvider::setEnd
     * @covers Jgut\Zf\Maintenance\Provider\ConfigScheduledProvider::getEnd
     * @covers Jgut\Zf\Maintenance\Provider\ConfigScheduledProvider::isActive
     * @covers Jgut\Zf\Maintenance\Provider\ConfigScheduledProvider::isScheduled
     * @covers Jgut\Zf\Maintenance\Provider\ConfigScheduledProvider::getScheduleTimes
     */
    public function testTimes()
    {
        $provider = new ConfigScheduledProvider();

        $start = new \DateTime('now');
        $start->add(new \DateInterval('P1D'));

        $provider->setStart($start);
        $this->assertEquals($start, $provider->getStart());
        $this->assertFalse($provider->isActive());
        $this->assertTrue($provider->isScheduled());
        $this->assertEquals(array('start' => $start, 'end' => null), $provider->getScheduleTimes());

        $provider = new ConfigScheduledProvider();

        $end = new \DateTime('now');
        $end->add(new \DateInterval('P2D'));

        $provider->setEnd($end);
        $this->assertEquals($end, $provider->getEnd());
        $this->assertTrue($provider->isActive());
        $this->assertFalse($provider->isScheduled());
        $this->assertEquals(array(), $provider->getScheduleTimes());

        $provider->setStart($start);
        $this->assertFalse($provider->isActive());
        $this->assertTrue($provider->isScheduled());
        $this->assertEquals(array('start' => $start, 'end' => $end), $provider->getScheduleTimes());
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testInvalidEndDate()
    {
        $provider = new ConfigScheduledProvider();

        $start = new \DateTime('now');
        $provider->setStart($start);

        $end = new \DateTime('now');
        $end->sub(new \DateInterval('P2D'));
        $provider->setEnd($end);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testInvalidStartDate()
    {
        $provider = new ConfigScheduledProvider();

        $end = new \DateTime('now');
        $provider->setEnd($end);

        $start = new \DateTime('now');
        $start->add(new \DateInterval('P2D'));
        $provider->setStart($start);
    }

    /**
     * @covers Jgut\Zf\Maintenance\Provider\ConfigScheduledProvider::setStart
     * @covers Jgut\Zf\Maintenance\Provider\ConfigScheduledProvider::setEnd
     * @covers Jgut\Zf\Maintenance\Provider\ConfigScheduledProvider::onRoute
     */
    public function testBeforeTime()
    {
        $provider = new ConfigScheduledProvider();

        $start = new \DateTime('now');
        $start->add(new \DateInterval('P1D'));
        $provider->setStart($start);

        $event = $this->getMock('Zend\\Mvc\\MvcEvent', array(), array(), '', false);

        $this->assertNull($provider->onRoute($event));

        $end = new \DateTime('now');
        $end->add(new \DateInterval('P2D'));
        $provider->setStart($end);

        $this->assertNull($provider->onRoute($event));
    }

    /**
     * @covers Jgut\Zf\Maintenance\Provider\ConfigScheduledProvider::setStart
     * @covers Jgut\Zf\Maintenance\Provider\ConfigScheduledProvider::setEnd
     * @covers Jgut\Zf\Maintenance\Provider\ConfigScheduledProvider::onRoute
     */
    public function testAfterTime()
    {
        $provider = new ConfigScheduledProvider();

        $end = new \DateTime('now');
        $end->sub(new \DateInterval('P1D'));
        $provider->setEnd($end);

        $event = $this->getMock('Zend\\Mvc\\MvcEvent', array(), array(), '', false);

        $this->assertNull($provider->onRoute($event));

        $start = new \DateTime('now');
        $start->sub(new \DateInterval('P2D'));
        $provider->setStart($start);

        $this->assertNull($provider->onRoute($event));
    }

    /**
     * @covers Jgut\Zf\Maintenance\Provider\ConfigScheduledProvider::setStart
     * @covers Jgut\Zf\Maintenance\Provider\ConfigScheduledProvider::setEnd
     * @covers Jgut\Zf\Maintenance\Provider\ConfigScheduledProvider::onRoute
     * @covers Jgut\Zf\Maintenance\Provider\AbstractProvider::onRoute
     */
    public function testNoRouteMatch()
    {
        $provider = new ConfigScheduledProvider();

        $start = new \DateTime('now');
        $start->sub(new \DateInterval('P1D'));
        $provider->setStart($start);

        $end = new \DateTime('now');
        $end->add(new \DateInterval('P1D'));
        $provider->setEnd($end);

        $event = $this->getMock('Zend\\Mvc\\MvcEvent', array(), array(), '', false);
        $event->expects($this->any())->method('getRouteMatch')->will($this->returnValue(false));

        $event->expects($this->never())->method('setError');
        $provider->onRoute($event);
    }

    /**
     * @covers Jgut\Zf\Maintenance\Provider\ConfigProvider::setActive
     * @covers Jgut\Zf\Maintenance\Provider\ConfigProvider::onRoute
     * @covers Jgut\Zf\Maintenance\Provider\AbstractProvider::onRoute
     * @covers Jgut\Zf\Maintenance\Provider\AbstractProvider::isExcluded
     */
    public function testIsExcluded()
    {
        $exclusion = $this->getMock('Jgut\\Zf\\Maintenance\\Exclusion\\IpExclusion', array(), array(), '', false);
        $exclusion->expects($this->once())->method('isExcluded')->will($this->returnValue(true));

        $options = $this->getMock('Jgut\\Zf\\Maintenance\\Options\\ModuleOptions', array(), array(), '', false);
        $options->expects($this->once())->method('getExclusions')->will(
            $this->returnValue(array('Jgut\\Zf\\Maintenance\\Exclusion\\IpExclusion' => ''))
        );

        $serviceManager = $this->getMock('Zend\\ServiceManager\\ServiceManager', array(), array(), '', false);
        $serviceManager->expects($this->once())->method('has')->will($this->returnValue(true));
        $serviceManager->expects($this->any())->method('get')->will(
            $this->returnCallback(
                function () use ($options, $exclusion) {
                    $args = array(
                        'zf-maintenance-options'                        => $options,
                        'Jgut\\Zf\\Maintenance\\Exclusion\\IpExclusion' => $exclusion
                    );
                    return $args[func_get_arg(0)];
                }
            )
        );

        $application = $this->getMock('Zend\\Mvc\\Application', array(), array(), '', false);
        $application->expects($this->once())->method('getServiceManager')->will($this->returnValue($serviceManager));

        $routeMatch = $this->getMock('Zend\\Mvc\\Router\\RouteMatch', array(), array(), '', false);

        $event = $this->getMock('Zend\\Mvc\\MvcEvent', array(), array(), '', false);
        $event->expects($this->once())->method('getRouteMatch')->will($this->returnValue($routeMatch));
        $event->expects($this->any())->method('getApplication')->will($this->returnValue($application));

        $event->expects($this->never())->method('setError');

        $provider = new ConfigScheduledProvider();

        $start = new \DateTime('now');
        $start->sub(new \DateInterval('P1D'));
        $provider->setStart($start);

        $end = new \DateTime('now');
        $end->add(new \DateInterval('P1D'));
        $provider->setEnd($end);

        $provider->onRoute($event);
    }

    /**
     * @covers Jgut\Zf\Maintenance\Provider\ConfigProvider::setActive
     * @covers Jgut\Zf\Maintenance\Provider\ConfigProvider::onRoute
     * @covers Jgut\Zf\Maintenance\Provider\AbstractProvider::onRoute
     * @covers Jgut\Zf\Maintenance\Provider\AbstractProvider::isExcluded
     */
    public function testIsNotExcluded()
    {
        $eventManager = $this->getMock('Zend\\EventManager\\EventManagerInterface');
        $eventManager->expects($this->once())->method('trigger');

        $options = $this->getMock('Jgut\\Zf\\Maintenance\\Options\\ModuleOptions', array(), array(), '', false);
        $options->expects($this->once())->method('getExclusions')->will($this->returnValue(array()));

        $serviceManager = $this->getMock('Zend\\ServiceManager\\ServiceManager', array(), array(), '', false);
        $serviceManager->expects($this->once())->method('get')->will($this->returnValue($options));

        $application = $this->getMock('Zend\\Mvc\\Application', array(), array(), '', false);
        $application->expects($this->once())->method('getServiceManager')->will($this->returnValue($serviceManager));
        $application->expects($this->once())->method('getEventManager')->will($this->returnValue($eventManager));

        $routeMatch = $this->getMock('Zend\\Mvc\\Router\\RouteMatch', array(), array(), '', false);

        $event = $this->getMock('Zend\\Mvc\\MvcEvent', array(), array(), '', false);
        $event->expects($this->once())->method('getRouteMatch')->will($this->returnValue($routeMatch));
        $event->expects($this->any())->method('getApplication')->will($this->returnValue($application));

        $provider = new ConfigScheduledProvider();

        $start = new \DateTime('now');
        $start->sub(new \DateInterval('P1D'));
        $provider->setStart($start);

        $end = new \DateTime('now');
        $end->add(new \DateInterval('P1D'));
        $provider->setEnd($end);

        $provider->onRoute($event);
    }
}
