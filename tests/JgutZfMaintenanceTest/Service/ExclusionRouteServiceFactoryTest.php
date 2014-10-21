<?php
/**
 * JgutZfMaintenance Module (https://github.com/juliangut/zf-maintenance)
 *
 * @link https://github.com/juliangut/zf-maintenance for the canonical source repository
 * @license https://raw.githubusercontent.com/juliangut/zf-maintenance/master/LICENSE
 */

namespace JgutZfMaintenanceTest\Service;

use PHPUnit_Framework_TestCase;
use JgutZfMaintenance\Service\ExclusionRouteServiceFactory;
use JgutZfMaintenance\Exclusion\RouteExclusion;

/**
 * @covers JgutZfMaintenance\Service\ExclusionRouteServiceFactory
 */
class ExclusionRouteServiceFactoryTest extends PHPUnit_Framework_TestCase
{
    /**
     * @covers JgutZfMaintenance\Service\ExclusionRouteServiceFactory::createService
     * @expectedException InvalidArgumentException
     */
    public function testNoCreation()
    {
        $options = $this->getMock('JgutZfMaintenance\\Options\\ModuleOptions', array(), array(), '', false);
        $options->expects($this->any())->method('getExclusions')->will($this->returnValue(array()));

        $serviceManager = $this->getMock('Zend\\ServiceManager\\ServiceManager', array(), array(), '', false);
        $serviceManager->expects($this->once())->method('get')->will($this->returnValue($options));

        $factory = new ExclusionRouteServiceFactory();
        $routeExclusion = $factory->createService($serviceManager);
    }

    /**
     * @covers JgutZfMaintenance\Service\ExclusionRouteServiceFactory::createService
     * @covers JgutZfMaintenance\Exclusion\RouteExclusion::__construct
     */
    public function testCreation()
    {
        $exclusions = array(
            'JgutZfMaintenance\Exclusion\RouteExclusion' => array(),
        );

        $options = $this->getMock('JgutZfMaintenance\\Options\\ModuleOptions', array(), array(), '', false);
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
                        'Application'            => $application,
                        'zf-maintenance-options' => $options,
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
