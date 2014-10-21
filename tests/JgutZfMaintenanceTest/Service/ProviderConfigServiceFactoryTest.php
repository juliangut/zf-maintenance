<?php
/**
 * JgutZfMaintenance Module (https://github.com/juliangut/zf-maintenance)
 *
 * @link https://github.com/juliangut/zf-maintenance for the canonical source repository
 * @license https://raw.githubusercontent.com/juliangut/zf-maintenance/master/LICENSE
 */

namespace JgutZfMaintenanceTest\Service;

use PHPUnit_Framework_TestCase;
use JgutZfMaintenance\Service\ProviderConfigServiceFactory;
use JgutZfMaintenance\Provider\ConfigProvider;

/**
 * @covers JgutZfMaintenance\Service\ProviderConfigServiceFactory
 */
class ProviderConfigServiceFactoryTest extends PHPUnit_Framework_TestCase
{
    /**
     * @covers JgutZfMaintenance\Service\ProviderConfigServiceFactory::createService
     * @expectedException InvalidArgumentException
     */
    public function testNoCreation()
    {
        $options = $this->getMock('JgutZfMaintenance\\Options\\ModuleOptions', array(), array(), '', false);
        $options->expects($this->any())->method('getProviders')->will($this->returnValue(array()));

        $serviceManager = $this->getMock('Zend\\ServiceManager\\ServiceManager', array(), array(), '', false);
        $serviceManager->expects($this->once())->method('get')->will($this->returnValue($options));

        $factory = new ProviderConfigServiceFactory();
        $configProvider = $factory->createService($serviceManager);
    }

    /**
     * @covers JgutZfMaintenance\Service\ProviderConfigServiceFactory::createService
     * @covers JgutZfMaintenance\Provider\ConfigProvider::setActive
     */
    public function testCreation()
    {
        $providers = array(
            'JgutZfMaintenance\Provider\ConfigProvider' => array('active' => 'true'),
        );

        $options = $this->getMock('JgutZfMaintenance\\Options\\ModuleOptions', array(), array(), '', false);
        $options->expects($this->any())->method('getProviders')->will($this->returnValue($providers));

        $serviceManager = $this->getMock('Zend\\ServiceManager\\ServiceManager', array(), array(), '', false);
        $serviceManager->expects($this->once())->method('get')->will($this->returnValue($options));

        $factory = new ProviderConfigServiceFactory();
        $configProvider = $factory->createService($serviceManager);

        $this->assertTrue($configProvider instanceof ConfigProvider);
    }
}
