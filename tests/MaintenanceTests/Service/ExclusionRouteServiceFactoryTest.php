<?php
/**
 * Juliangut Zend Framework Maintenance Module Module (https://github.com/juliangut/zf-maintenance)
 *
 * @link https://github.com/juliangut/zf-maintenance for the canonical source repository
 * @license https://github.com/juliangut/zf-maintenance/blob/master/LICENSE
 */

namespace Jgut\Zf\MaintenanceTests\Service;

use PHPUnit_Framework_TestCase;
use Jgut\Zf\Maintenance\Service\ExclusionRouteServiceFactory;
use Jgut\Zf\Maintenance\Exclusion\RouteExclusion;

/**
 * @covers Jgut\Zf\Maintenance\Service\ExclusionRouteServiceFactory
 */
class ExclusionRouteServiceFactoryTest extends PHPUnit_Framework_TestCase
{
    /**
     * @covers Jgut\Zf\Maintenance\Service\ExclusionRouteServiceFactory::createService
     * @expectedException InvalidArgumentException
     */
    public function testNoCreation()
    {
        $exclusions = array();

        $options = $this->getMock('Jgut\\Zf\\Maintenance\\Options\\ModuleOptions', array(), array(), '', false);
        $options->expects($this->any())->method('getExclusions')->will($this->returnValue($exclusions));

        $serviceManager = $this->getMock('Zend\\ServiceManager\\ServiceManager', array(), array(), '', false);
        $serviceManager->expects($this->once())->method('get')->will($this->returnValue($options));

        $factory = new ExclusionRouteServiceFactory();
        $factory->createService($serviceManager);
    }

    /**
     * @covers Jgut\Zf\Maintenance\Service\ExclusionRouteServiceFactory::createService
     * @covers Jgut\Zf\Maintenance\Exclusion\RouteExclusion::__construct
     */
    public function testCreation()
    {
        $exclusions = array(
            'ZfMaintenanceRouteExclusion' => array(),
        );

        $options = $this->getMock('Jgut\\Zf\\Maintenance\\Options\\ModuleOptions', array(), array(), '', false);
        $options->expects($this->any())->method('getExclusions')->will($this->returnValue($exclusions));

        $routeMatch = $this->getMock('Zend\\Mvc\\Router\\RouteMatch', array(), array(), '', false);

        $event = $this->getMock('Zend\\Mvc\\MvcEvent', array(), array(), '', false);
        $event->expects($this->once())->method('getRouteMatch')->will($this->returnValue($routeMatch));

        $application = $this->getMock('Zend\\Mvc\\Application', array(), array(), '', false);
        $application->expects($this->once())->method('getMvcEvent')->will($this->returnValue($event));

        $serviceManager = $this->getMock('Zend\\ServiceManager\\ServiceManager', array(), array(), '', false);
        $serviceManager->expects($this->any())->method('get')->will(
            $this->returnCallback(
                function () use ($options, $application) {
                    $args = array(
                        'Application'          => $application,
                        'ZfMaintenanceOptions' => $options,
                    );
                    return $args[func_get_arg(0)];
                }
            )
        );

        $factory = new ExclusionRouteServiceFactory();
        $routeExclusion = $factory->createService($serviceManager);

        $this->assertTrue($routeExclusion instanceof RouteExclusion);
    }
}
