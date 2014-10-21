<?php
/**
 * JgutZfMaintenance Module (https://github.com/juliangut/zf-maintenance)
 *
 * @link https://github.com/juliangut/zf-maintenance for the canonical source repository
 * @license https://raw.githubusercontent.com/juliangut/zf-maintenance/master/LICENSE
 */

namespace JgutZfMaintenanceTest\Service;

use PHPUnit_Framework_TestCase;
use JgutZfMaintenance\Service\ViewScheduledMaintenanceServiceFactory;
use JgutZfMaintenance\View\Helper\ScheduledMaintenance;

/**
 * @covers JgutZfMaintenance\Service\ViewScheduledMaintenanceServiceFactory
 */
class ViewScheduledMaintenanceServiceFactoryTest extends PHPUnit_Framework_TestCase
{
    /**
     * @covers JgutZfMaintenance\Service\ViewScheduledMaintenanceServiceFactory::createService
     * @covers JgutZfMaintenance\View\Helper\ScheduledMaintenance::__construct
     */
    public function testCreation()
    {
        $options = $this->getMock('JgutZfMaintenance\\Options\\ModuleOptions', array(), array(), '', false);
        $options->expects($this->any())->method('getProviders')->will($this->returnValue(array()));

        $serviceManager = $this->getMock('Zend\\ServiceManager\\ServiceManager', array(), array(), '', false);
        $serviceManager->expects($this->any())->method('get')->will($this->returnValue($options));

        $helperManager = $this->getMock('Zend\\View\\HelperPluginManager', array(), array(), '', false);
        $helperManager->expects($this->once())->method('getServiceLocator')->will($this->returnValue($serviceManager));

        $factory = new ViewScheduledMaintenanceServiceFactory();
        $helper = $factory->createService($helperManager);

        $this->assertTrue($helper instanceof ScheduledMaintenance);
    }
}
