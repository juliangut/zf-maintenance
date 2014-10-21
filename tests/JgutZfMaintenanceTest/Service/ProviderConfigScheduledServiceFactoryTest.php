<?php
/**
 * JgutZfMaintenance Module (https://github.com/juliangut/zf-maintenance)
 *
 * @link https://github.com/juliangut/zf-maintenance for the canonical source repository
 * @license https://raw.githubusercontent.com/juliangut/zf-maintenance/master/LICENSE
 */

namespace JgutZfMaintenanceTest\Service;

use PHPUnit_Framework_TestCase;
use JgutZfMaintenance\Service\ProviderConfigScheduledServiceFactory;
use JgutZfMaintenance\Provider\ConfigScheduledProvider;

/**
 * @covers JgutZfMaintenance\Service\ProviderConfigScheduledServiceFactory
 */
class ProviderConfigScheduledServiceFactoryTest extends PHPUnit_Framework_TestCase
{
    /**
     * @covers JgutZfMaintenance\Service\ProviderConfigScheduledServiceFactory::createService
     * @expectedException InvalidArgumentException
     */
    public function testNoCreation()
    {
        $options = $this->getMock('JgutZfMaintenance\\Options\\ModuleOptions', array(), array(), '', false);
        $options->expects($this->any())->method('getProviders')->will($this->returnValue(array()));

        $serviceManager = $this->getMock('Zend\\ServiceManager\\ServiceManager', array(), array(), '', false);
        $serviceManager->expects($this->once())->method('get')->will($this->returnValue($options));

        $factory = new ProviderConfigScheduledServiceFactory();
        $factory->createService($serviceManager);
    }

    /**
     * @covers JgutZfMaintenance\Service\ProviderConfigScheduledServiceFactory::createService
     * @covers JgutZfMaintenance\Provider\ConfigScheduledProvider::setStart
     * @covers JgutZfMaintenance\Provider\ConfigScheduledProvider::setEnd
     */
    public function testCreation()
    {
        $providers = array(
            'JgutZfMaintenance\Provider\ConfigScheduledProvider' => array(
                'start' => 'now',
                'end'   => 'now',
            ),
        );

        $options = $this->getMock('JgutZfMaintenance\\Options\\ModuleOptions', array(), array(), '', false);
        $options->expects($this->any())->method('getProviders')->will($this->returnValue($providers));

        $serviceManager = $this->getMock('Zend\\ServiceManager\\ServiceManager', array(), array(), '', false);
        $serviceManager->expects($this->once())->method('get')->will($this->returnValue($options));

        $factory = new ProviderConfigScheduledServiceFactory();
        $scheduledProvider = $factory->createService($serviceManager);

        $this->assertTrue($scheduledProvider instanceof ConfigScheduledProvider);
    }
}
