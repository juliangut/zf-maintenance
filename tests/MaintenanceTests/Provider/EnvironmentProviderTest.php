<?php
/**
 * Juliangut Zend Framework Maintenance Module Module (https://github.com/juliangut/zf-maintenance)
 *
 * @link https://github.com/juliangut/zf-maintenance for the canonical source repository
 * @license https://github.com/juliangut/zf-maintenance/blob/master/LICENSE
 */

namespace Jgut\Zf\MaintenanceTests\Provider;

use PHPUnit_Framework_TestCase;
use Jgut\Zf\Maintenance\Provider\EnvironmentProvider;

/**
 * @covers Jgut\Zf\Maintenance\Provider\EnvironmentProvider
 */
class EnvironmentProviderTest extends PHPUnit_Framework_TestCase
{
    protected $provider;

    public static function setUpBeforeClass()
    {
        putenv('zf-maintenance=On');
    }

    public static function tearDownAfterClass()
    {
        putenv('zf-maintenance');
    }

    public function setUp()
    {
        $this->provider = new EnvironmentProvider();
    }

    /**
     * @covers Jgut\Zf\Maintenance\Provider\AbstractProvider::attach
     * @covers Jgut\Zf\Maintenance\Provider\AbstractProvider::detach
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
        $this->provider->attach($eventManager);

        $eventManager
            ->expects($this->once())
            ->method('detach')
            ->with($callbackMock)
            ->will($this->returnValue(true));
        $this->provider->detach($eventManager);
    }

    /**
     * @covers Jgut\Zf\Maintenance\Provider\EnvironmentProvider::setVar
     * @covers Jgut\Zf\Maintenance\Provider\EnvironmentProvider::getVar
     * @covers Jgut\Zf\Maintenance\Provider\EnvironmentProvider::setValue
     * @covers Jgut\Zf\Maintenance\Provider\EnvironmentProvider::getValue
     */
    public function testMutatorAccessor()
    {
        $this->provider->setVar('zf-maintenance');
        $this->provider->setValue('On');

        $this->assertEquals('zf-maintenance', $this->provider->getVar());
        $this->assertEquals('On', $this->provider->getValue());
    }

    /**
     * @covers Jgut\Zf\Maintenance\Provider\EnvironmentProvider::isActive
     * @covers Jgut\Zf\Maintenance\Provider\EnvironmentProvider::onRoute
     */
    public function testNotIsActive()
    {
        $event = $this->getMock('Zend\\Mvc\\MvcEvent', array(), array(), '', false);

        $this->assertFalse($this->provider->isActive());
        $this->assertNull($this->provider->onRoute($event));

        $this->provider->setVar('ficticious-environment-variable');

        $this->assertFalse($this->provider->isActive());
        $this->assertNull($this->provider->onRoute($event));

        $this->provider->setVar('zf-maintenance');
        $this->provider->setValue('Off');

        $this->assertFalse($this->provider->isActive());
        $this->assertNull($this->provider->onRoute($event));
    }

    /**
     * @covers Jgut\Zf\Maintenance\Provider\EnvironmentProvider::setVar
     * @covers Jgut\Zf\Maintenance\Provider\EnvironmentProvider::setValue
     * @covers Jgut\Zf\Maintenance\Provider\EnvironmentProvider::isActive
     */
    public function testIsActive()
    {
        $this->provider->setVar('zf-maintenance');

        $this->assertTrue($this->provider->isActive());

        $this->provider->setValue('On');

        $this->assertTrue($this->provider->isActive());
    }

    /**
     * @covers Jgut\Zf\Maintenance\Provider\EnvironmentProvider::setVar
     * @covers Jgut\Zf\Maintenance\Provider\AbstractProvider::onRoute
     */
    public function testNoRouteMatch()
    {
        $this->provider->setVar('zf-maintenance');

        $event = $this->getMock('Zend\\Mvc\\MvcEvent', array(), array(), '', false);
        $event->expects($this->any())->method('getRouteMatch')->will($this->returnValue(false));

        $event->expects($this->never())->method('setError');
        $this->provider->onRoute($event);
    }

    /**
     * @covers Jgut\Zf\Maintenance\Provider\EnvironmentProvider::setVar
     * @covers Jgut\Zf\Maintenance\Provider\AbstractProvider::onRoute
     * @covers Jgut\Zf\Maintenance\Provider\AbstractProvider::isExcluded
     */
    public function tetIsExcluded()
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

        $this->provider->setVar('zf-maintenance');

        $this->provider->onRoute($event);
    }

    /**
     * @covers Jgut\Zf\Maintenance\Provider\EnvironmentProvider::setVar
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

        $this->provider->setVar('zf-maintenance');

        $this->provider->onRoute($event);
    }
}
