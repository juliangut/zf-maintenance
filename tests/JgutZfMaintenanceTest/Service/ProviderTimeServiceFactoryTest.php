<?php
/**
 * JgutZfMaintenance Module (https://github.com/juliangut/zf-maintenance)
 *
 * @link https://github.com/juliangut/zf-maintenance for the canonical source repository
 * @license https://raw.githubusercontent.com/juliangut/zf-maintenance/master/LICENSE
 */

namespace JgutZfMaintenanceTest\Service;

use PHPUnit_Framework_TestCase;
use JgutZfMaintenance\Service\ProviderTimeServiceFactory;
use JgutZfMaintenance\Provider\TimeProvider;

/**
 * @covers JgutZfMaintenance\Service\ProviderTimeServiceFactory
 */
class ProviderTimeServiceFactoryTest extends PHPUnit_Framework_TestCase
{
    /**
     * @covers JgutZfMaintenance\Service\ProviderTimeServiceFactory::createService
     * @expectedException InvalidArgumentException
     */
    public function testNoCreation()
    {
        $options = $this->getMock('JgutZfMaintenance\\Options\\ModuleOptions', array(), array(), '', false);
        $options->expects($this->any())->method('getProviders')->will($this->returnValue(array()));

        $serviceManager = $this->getMock('Zend\\ServiceManager\\ServiceManager', array(), array(), '', false);
        $serviceManager->expects($this->once())->method('get')->will($this->returnValue($options));

        $factory = new ProviderTimeServiceFactory();
        $timeProvider = $factory->createService($serviceManager);
    }

    /**
     * @covers JgutZfMaintenance\Service\ProviderTimeServiceFactory::createService
     * @covers JgutZfMaintenance\Provider\TimeProvider::setStart
     * @covers JgutZfMaintenance\Provider\TimeProvider::setEnd
     */
    public function testCreation()
    {
        $providers = array(
            'JgutZfMaintenance\Provider\TimeProvider' => array(
                'start' => 'now',
                'end'   => 'now',
            ),
        );

        $options = $this->getMock('JgutZfMaintenance\\Options\\ModuleOptions', array(), array(), '', false);
        $options->expects($this->any())->method('getProviders')->will($this->returnValue($providers));

        $serviceManager = $this->getMock('Zend\\ServiceManager\\ServiceManager', array(), array(), '', false);
        $serviceManager->expects($this->once())->method('get')->will($this->returnValue($options));

        $factory = new ProviderTimeServiceFactory();
        $timeProvider = $factory->createService($serviceManager);

        $this->assertTrue($timeProvider instanceof TimeProvider);
    }
}
