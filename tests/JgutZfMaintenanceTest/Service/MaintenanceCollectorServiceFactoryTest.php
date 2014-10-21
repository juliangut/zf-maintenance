<?php
/**
 * JgutZfMaintenance Module (https://github.com/juliangut/zf-maintenance)
 *
 * @link https://github.com/juliangut/zf-maintenance for the canonical source repository
 * @license https://raw.githubusercontent.com/juliangut/zf-maintenance/master/LICENSE
 */

namespace JgutZfMaintenanceTest\Service;

use PHPUnit_Framework_TestCase;
use JgutZfMaintenance\Service\MaintenanceCollectorServiceFactory;
use JgutZfMaintenance\Collector\MaintenanceCollector;

/**
 * @covers JgutZfMaintenance\Service\MaintenanceCollectorServiceFactory
 */
class MaintenanceCollectorServiceFactoryTest extends PHPUnit_Framework_TestCase
{
    /**
     * @covers JgutZfMaintenance\Service\MaintenanceCollectorServiceFactory::createService
     * @covers JgutZfMaintenance\Collector\MaintenanceCollector::__construct
     */
    public function testCreation()
    {
        $options = $this->getMock('JgutZfMaintenance\\Options\\ModuleOptions', array(), array(), '', false);
        $options->expects($this->any())->method('getProviders')->will($this->returnValue(array()));

        $serviceManager = $this->getMock('Zend\\ServiceManager\\ServiceManager', array(), array(), '', false);
        $serviceManager->expects($this->once())->method('get')->will($this->returnValue($options));

        $factory = new MaintenanceCollectorServiceFactory();
        $maintenanceCollector = $factory->createService($serviceManager);

        $this->assertTrue($maintenanceCollector instanceof MaintenanceCollector);
    }
}
