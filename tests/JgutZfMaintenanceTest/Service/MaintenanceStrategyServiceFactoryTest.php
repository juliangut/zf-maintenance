<?php
/**
 * JgutZfMaintenance Module (https://github.com/juliangut/zf-maintenance)
 *
 * @link https://github.com/juliangut/zf-maintenance for the canonical source repository
 * @license https://raw.githubusercontent.com/juliangut/zf-maintenance/master/LICENSE
 */

namespace JgutZfMaintenanceTest\Service;

use PHPUnit_Framework_TestCase;
use JgutZfMaintenance\Service\MaintenanceStrategyServiceFactory;
use JgutZfMaintenance\View\MaintenanceStrategy;

/**
 * @covers JgutZfMaintenance\Service\MaintenanceStrategyServiceFactory
 */
class MaintenanceStrategyServiceFactoryTest extends PHPUnit_Framework_TestCase
{
    /**
     * @covers JgutZfMaintenance\Service\MaintenanceStrategyServiceFactory::createService
     * @covers JgutZfMaintenance\View\MaintenanceStrategy::__construct
     */
    public function testCreation()
    {
        $options = $this->getMock('JgutZfMaintenance\\Options\\ModuleOptions', array(), array(), '', false);
        $options->expects($this->once())->method('getTemplate')->will($this->returnValue('maintenance'));

        $serviceManager = $this->getMock('Zend\\ServiceManager\\ServiceManager', array(), array(), '', false);
        $serviceManager->expects($this->once())->method('get')->will($this->returnValue($options));

        $factory = new MaintenanceStrategyServiceFactory();
        $maintenanceStrategy = $factory->createService($serviceManager);

        $this->assertTrue($maintenanceStrategy instanceof MaintenanceStrategy);
    }
}
