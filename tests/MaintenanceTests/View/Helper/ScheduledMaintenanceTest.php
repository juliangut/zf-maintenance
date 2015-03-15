<?php
/**
 * Juliangut Zend Framework Maintenance Module Module (https://github.com/juliangut/zf-maintenance)
 *
 * @link https://github.com/juliangut/zf-maintenance for the canonical source repository
 * @license https://raw.githubusercontent.com/juliangut/zf-maintenance/master/LICENSE
 */

namespace Jgut\Zf\MaintenanceTests\View\Helper;

use PHPUnit_Framework_TestCase;
use Jgut\Zf\Maintenance\View\Helper\ScheduledMaintenance;

/**
 * @covers Jgut\Zf\Maintenance\View\Helper\ScheduledMaintenance
 */
class ScheduledMaintenanceTests extends PHPUnit_Framework_TestCase
{
    /**
     * @covers Jgut\Zf\Maintenance\View\Helper\ScheduledMaintenance::__invoke
     */
    public function testDefault()
    {
        $helper = new ScheduledMaintenance();

        $this->assertFalse($helper->__invoke());
    }

    public function testReturnFalse()
    {
        $provider = $this->getMock('Jgut\\Zf\\Maintenance\\Provider\\ScheduledProviderInterface');
        $provider->expects($this->any())->method('isScheduled')->will($this->returnValue(false));

        $serviceManager = $this->getMock('Zend\\ServiceManager\\ServiceManager', array(), array(), '', false);
        $serviceManager->expects($this->any())->method('has')->will($this->returnValue(true));
        $serviceManager->expects($this->any())->method('get')->will($this->returnValue($provider));

        $helperManager = $this->getMock('Zend\\View\\HelperPluginManager', array(), array(), '', false);
        $helperManager->expects($this->once())->method('getServiceLocator')->will($this->returnValue($serviceManager));

        $providers = array('Jgut\\Zf\\Maintenance\\Provider\\ConfigScheduledProvider' => '');

        $helper = new ScheduledMaintenance($providers);
        $helper->setServiceLocator($helperManager);

        $this->assertEquals($helperManager, $helper->getServiceLocator());

        $this->assertFalse($helper->__invoke());
    }

    /**
     * @covers Jgut\Zf\Maintenance\View\Helper\ScheduledMaintenance::setServiceLocator
     * @covers Jgut\Zf\Maintenance\View\Helper\ScheduledMaintenance::getServiceLocator
     * @covers Jgut\Zf\Maintenance\View\Helper\ScheduledMaintenance::__invoke
     */
    public function testReturnSchedule()
    {
        $scheduleTimes = array('start' => new \DateTime('now'), 'end' => null);

        $provider = $this->getMock('Jgut\\Zf\\Maintenance\\Provider\\ScheduledProviderInterface');
        $provider->expects($this->any())->method('isScheduled')->will($this->returnValue(true));
        $provider->expects($this->any())->method('getScheduleTimes')->will(
            $this->returnValue($scheduleTimes)
        );

        $serviceManager = $this->getMock('Zend\\ServiceManager\\ServiceManager', array(), array(), '', false);
        $serviceManager->expects($this->any())->method('has')->will($this->returnValue(true));
        $serviceManager->expects($this->any())->method('get')->will($this->returnValue($provider));

        $helperManager = $this->getMock('Zend\\View\\HelperPluginManager', array(), array(), '', false);
        $helperManager->expects($this->once())->method('getServiceLocator')->will($this->returnValue($serviceManager));

        $providers = array('Jgut\\Zf\\Maintenance\\Provider\\ConfigScheduledProvider' => '');

        $helper = new ScheduledMaintenance($providers);
        $helper->setServiceLocator($helperManager);

        $this->assertEquals($helperManager, $helper->getServiceLocator());

        $this->assertEquals($scheduleTimes, $helper->__invoke());
    }
}
