<?php
/**
 * Juliangut Zend Framework Maintenance Module Module (https://github.com/juliangut/zf-maintenance)
 *
 * @link https://github.com/juliangut/zf-maintenance for the canonical source repository
 * @license https://github.com/juliangut/zf-maintenance/blob/master/LICENSE
 */

namespace Jgut\Zf\MaintenanceTests\Service;

use PHPUnit_Framework_TestCase;
use Jgut\Zf\Maintenance\Service\MaintenanceCollectorServiceFactory;
use Jgut\Zf\Maintenance\Collector\MaintenanceCollector;

/**
 * @covers Jgut\Zf\Maintenance\Service\MaintenanceCollectorServiceFactory
 */
class MaintenanceCollectorServiceFactoryTest extends PHPUnit_Framework_TestCase
{
    /**
     * @covers Jgut\Zf\Maintenance\Service\MaintenanceCollectorServiceFactory::createService
     * @covers Jgut\Zf\Maintenance\Collector\MaintenanceCollector::__construct
     */
    public function testCreation()
    {
        $options = $this->getMock('Jgut\\Zf\\Maintenance\\Options\\ModuleOptions', array(), array(), '', false);
        $options->expects($this->any())->method('getProviders')->will($this->returnValue(array()));

        $serviceManager = $this->getMock('Zend\\ServiceManager\\ServiceManager', array(), array(), '', false);
        $serviceManager->expects($this->once())->method('get')->will($this->returnValue($options));

        $factory = new MaintenanceCollectorServiceFactory();
        $maintenanceCollector = $factory->createService($serviceManager);

        $this->assertTrue($maintenanceCollector instanceof MaintenanceCollector);
    }
}
