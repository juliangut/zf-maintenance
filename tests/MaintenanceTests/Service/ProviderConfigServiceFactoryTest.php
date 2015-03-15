<?php
/**
 * Juliangut Zend Framework Maintenance Module Module (https://github.com/juliangut/zf-maintenance)
 *
 * @link https://github.com/juliangut/zf-maintenance for the canonical source repository
 * @license https://raw.githubusercontent.com/juliangut/zf-maintenance/master/LICENSE
 */

namespace Jgut\Zf\MaintenanceTests\Service;

use PHPUnit_Framework_TestCase;
use Jgut\Zf\Maintenance\Service\ProviderConfigServiceFactory;
use Jgut\Zf\Maintenance\Provider\ConfigProvider;

/**
 * @covers Jgut\Zf\Maintenance\Service\ProviderConfigServiceFactory
 */
class ProviderConfigServiceFactoryTest extends PHPUnit_Framework_TestCase
{
    /**
     * @covers Jgut\Zf\Maintenance\Service\ProviderConfigServiceFactory::createService
     * @expectedException InvalidArgumentException
     */
    public function testNoCreation()
    {
        $options = $this->getMock('Jgut\\Zf\\Maintenance\\Options\\ModuleOptions', array(), array(), '', false);
        $options->expects($this->any())->method('getProviders')->will($this->returnValue(array()));

        $serviceManager = $this->getMock('Zend\\ServiceManager\\ServiceManager', array(), array(), '', false);
        $serviceManager->expects($this->once())->method('get')->will($this->returnValue($options));

        $factory = new ProviderConfigServiceFactory();
        $configProvider = $factory->createService($serviceManager);
    }

    /**
     * @covers Jgut\Zf\Maintenance\Service\ProviderConfigServiceFactory::createService
     * @covers Jgut\Zf\Maintenance\Provider\ConfigProvider::setActive
     */
    public function testCreation()
    {
        $providers = array(
            'Jgut\Zf\Maintenance\Provider\ConfigProvider' => array('active' => 'true'),
        );

        $options = $this->getMock('Jgut\\Zf\\Maintenance\\Options\\ModuleOptions', array(), array(), '', false);
        $options->expects($this->any())->method('getProviders')->will($this->returnValue($providers));

        $serviceManager = $this->getMock('Zend\\ServiceManager\\ServiceManager', array(), array(), '', false);
        $serviceManager->expects($this->once())->method('get')->will($this->returnValue($options));

        $factory = new ProviderConfigServiceFactory();
        $configProvider = $factory->createService($serviceManager);

        $this->assertTrue($configProvider instanceof ConfigProvider);
    }
}
