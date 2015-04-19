<?php
/**
 * Juliangut Zend Framework Maintenance Module Module (https://github.com/juliangut/zf-maintenance)
 *
 * @link https://github.com/juliangut/zf-maintenance for the canonical source repository
 * @license https://github.com/juliangut/zf-maintenance/blob/master/LICENSE
 */

namespace Jgut\Zf\MaintenanceTests\View\Helper;

use PHPUnit_Framework_TestCase;
use Jgut\Zf\Maintenance\View\Helper\MaintenanceMessage;

/**
 * @covers Jgut\Zf\Maintenance\View\Helper\MaintenanceMessage
 */
class MaintenanceMessageTests extends PHPUnit_Framework_TestCase
{
    /**
     * @covers Jgut\Zf\Maintenance\View\Helper\MaintenanceMessage::__invoke
     */
    public function testDefault()
    {
        $helper = new MaintenanceMessage();

        $this->assertEquals('', $helper->__invoke());
    }

    public function testReturnEmpty()
    {
        $provider = $this->getMock('Jgut\\Zf\\Maintenance\\Provider\\ConfigProvider');
        $provider->expects($this->any())->method('isActive')->will($this->returnValue(false));

        $serviceManager = $this->getMock('Zend\\ServiceManager\\ServiceManager', array(), array(), '', false);
        $serviceManager->expects($this->any())->method('has')->will($this->returnValue(true));
        $serviceManager->expects($this->any())->method('get')->will($this->returnValue($provider));

        $helperManager = $this->getMock('Zend\\View\\HelperPluginManager', array(), array(), '', false);
        $helperManager->expects($this->once())->method('getServiceLocator')->will($this->returnValue($serviceManager));

        $providers = array('ZfMaintenanceConfigProvider' => '');

        $helper = new MaintenanceMessage($providers);
        $helper->setServiceLocator($helperManager);

        $this->assertEquals($helperManager, $helper->getServiceLocator());

        $this->assertEquals('', $helper->__invoke());
    }

    /**
     * @covers Jgut\Zf\Maintenance\View\Helper\MaintenanceMessage::setServiceLocator
     * @covers Jgut\Zf\Maintenance\View\Helper\MaintenanceMessage::getServiceLocator
     * @covers Jgut\Zf\Maintenance\View\Helper\MaintenanceMessage::__invoke
     */
    public function testReturnSchedule()
    {
        $message = 'custom maintenance message';

        $provider = $this->getMock('Jgut\\Zf\\Maintenance\\Provider\\ConfigProvider');
        $provider->expects($this->any())->method('isActive')->will($this->returnValue(true));
        $provider->expects($this->any())->method('getMessage')->will($this->returnValue($message));

        $serviceManager = $this->getMock('Zend\\ServiceManager\\ServiceManager', array(), array(), '', false);
        $serviceManager->expects($this->any())->method('has')->will($this->returnValue(true));
        $serviceManager->expects($this->any())->method('get')->will($this->returnValue($provider));

        $helperManager = $this->getMock('Zend\\View\\HelperPluginManager', array(), array(), '', false);
        $helperManager->expects($this->once())->method('getServiceLocator')->will($this->returnValue($serviceManager));

        $providers = array('ZfMaintenanceConfigProvider' => '');

        $helper = new MaintenanceMessage($providers);
        $helper->setServiceLocator($helperManager);

        $this->assertEquals($helperManager, $helper->getServiceLocator());

        $this->assertEquals($message, $helper->__invoke());
    }
}
