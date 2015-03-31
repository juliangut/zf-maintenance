<?php
/**
 * Juliangut Zend Framework Maintenance Module Module (https://github.com/juliangut/zf-maintenance)
 *
 * @link https://github.com/juliangut/zf-maintenance for the canonical source repository
 * @license https://github.com/juliangut/zf-maintenance/blob/master/LICENSE
 */

namespace Jgut\Zf\MaintenanceTests\Service;

use PHPUnit_Framework_TestCase;
use Jgut\Zf\Maintenance\Service\MaintenanceStrategyServiceFactory;
use Jgut\Zf\Maintenance\View\MaintenanceStrategy;

/**
 * @covers Jgut\Zf\Maintenance\Service\MaintenanceStrategyServiceFactory
 */
class MaintenanceStrategyServiceFactoryTest extends PHPUnit_Framework_TestCase
{
    /**
     * @covers Jgut\Zf\Maintenance\Service\MaintenanceStrategyServiceFactory::createService
     * @covers Jgut\Zf\Maintenance\View\MaintenanceStrategy::__construct
     */
    public function testCreation()
    {
        $options = $this->getMock('Jgut\\Zf\\Maintenance\\Options\\ModuleOptions', array(), array(), '', false);
        $options->expects($this->once())->method('getTemplate')->will($this->returnValue('maintenance'));

        $serviceManager = $this->getMock('Zend\\ServiceManager\\ServiceManager', array(), array(), '', false);
        $serviceManager->expects($this->once())->method('get')->will($this->returnValue($options));

        $factory = new MaintenanceStrategyServiceFactory();
        $maintenanceStrategy = $factory->createService($serviceManager);

        $this->assertTrue($maintenanceStrategy instanceof MaintenanceStrategy);
    }
}
