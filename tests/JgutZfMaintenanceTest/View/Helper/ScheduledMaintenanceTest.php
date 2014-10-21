<?php
/**
 * JgutZfMaintenance Module (https://github.com/juliangut/zf-maintenance)
 *
 * @link https://github.com/juliangut/zf-maintenance for the canonical source repository
 * @license https://raw.githubusercontent.com/juliangut/zf-maintenance/master/LICENSE
 */

namespace JgutZfMaintenanceTest\View\Helper;

use PHPUnit_Framework_TestCase;
use JgutZfMaintenance\View\Helper\ScheduledMaintenance;

/**
 * @covers JgutZfMaintenance\View\Helper\ScheduledMaintenance
 */
class ScheduledMaintenanceTest extends PHPUnit_Framework_TestCase
{
    /**
     * @covers JgutZfMaintenance\View\Helper\ScheduledMaintenance::__invoke
     */
    public function testDefault()
    {
        $helper = new ScheduledMaintenance();

        $this->assertFalse($helper->__invoke());
    }

    public function testReturnFalse()
    {
        $provider = $this->getMock('JgutZfMaintenance\\Provider\\ScheduledProviderInterface');
        $provider->expects($this->any())->method('isScheduled')->will($this->returnValue(false));

        $serviceManager = $this->getMock('Zend\\ServiceManager\\ServiceManager', array(), array(), '', false);
        $serviceManager->expects($this->any())->method('has')->will($this->returnValue(true));
        $serviceManager->expects($this->any())->method('get')->will($this->returnValue($provider));

        $helperManager = $this->getMock('Zend\\View\\HelperPluginManager', array(), array(), '', false);
        $helperManager->expects($this->once())->method('getServiceLocator')->will($this->returnValue($serviceManager));

        $providers = array('JgutZfMaintenance\\Provider\\TimeProvider' => '');

        $helper = new ScheduledMaintenance($providers);
        $helper->setServiceLocator($helperManager);

        $this->assertEquals($helperManager, $helper->getServiceLocator());

        $this->assertFalse($helper->__invoke());
    }

    /**
     * @covers JgutZfMaintenance\View\Helper\ScheduledMaintenance::setServiceLocator
     * @covers JgutZfMaintenance\View\Helper\ScheduledMaintenance::getServiceLocator
     * @covers JgutZfMaintenance\View\Helper\ScheduledMaintenance::__invoke
     */
    public function testReturnSchedule()
    {
        $scheduleTimes = array('start' => new \DateTime('now'), 'end' => null);

        $provider = $this->getMock('JgutZfMaintenance\\Provider\\ScheduledProviderInterface');
        $provider->expects($this->any())->method('isScheduled')->will($this->returnValue(true));
        $provider->expects($this->any())->method('getScheduleTimes')->will(
            $this->returnValue($scheduleTimes)
        );

        $serviceManager = $this->getMock('Zend\\ServiceManager\\ServiceManager', array(), array(), '', false);
        $serviceManager->expects($this->any())->method('has')->will($this->returnValue(true));
        $serviceManager->expects($this->any())->method('get')->will($this->returnValue($provider));

        $helperManager = $this->getMock('Zend\\View\\HelperPluginManager', array(), array(), '', false);
        $helperManager->expects($this->once())->method('getServiceLocator')->will($this->returnValue($serviceManager));

        $providers = array('JgutZfMaintenance\\Provider\\TimeProvider' => '');

        $helper = new ScheduledMaintenance($providers);
        $helper->setServiceLocator($helperManager);

        $this->assertEquals($helperManager, $helper->getServiceLocator());

        $this->assertEquals($scheduleTimes, $helper->__invoke());
    }
}
