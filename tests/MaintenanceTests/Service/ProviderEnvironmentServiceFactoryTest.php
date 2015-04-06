<?php
/**
 * Juliangut Zend Framework Maintenance Module Module (https://github.com/juliangut/zf-maintenance)
 *
 * @link https://github.com/juliangut/zf-maintenance for the canonical source repository
 * @license https://github.com/juliangut/zf-maintenance/blob/master/LICENSE
 */

namespace Jgut\Zf\MaintenanceTests\Service;

use PHPUnit_Framework_TestCase;
use Jgut\Zf\Maintenance\Service\ProviderEnvironmentServiceFactory;
use Jgut\Zf\Maintenance\Provider\EnvironmentProvider;

/**
 * @covers Jgut\Zf\Maintenance\Service\ProviderEnvironmentServiceFactory
 */
class ProviderEnvironmentServiceFactoryTest extends PHPUnit_Framework_TestCase
{
    /**
     * @covers Jgut\Zf\Maintenance\Service\ProviderEnvironmentServiceFactory::createService
     * @expectedException InvalidArgumentException
     */
    public function testNoCreation()
    {
        $options = $this->getMock('Jgut\\Zf\\Maintenance\\Options\\ModuleOptions', array(), array(), '', false);
        $options->expects($this->any())->method('getProviders')->will($this->returnValue(array()));

        $serviceManager = $this->getMock('Zend\\ServiceManager\\ServiceManager', array(), array(), '', false);
        $serviceManager->expects($this->once())->method('get')->will($this->returnValue($options));

        $factory = new ProviderEnvironmentServiceFactory();
        $factory->createService($serviceManager);
    }

    /**
     * @covers Jgut\Zf\Maintenance\Service\ProviderEnvironmentServiceFactory::createService
     * @expectedException InvalidArgumentException
     */
    public function testNoVarCreation()
    {
        $providers = array(
            'ZfMaintenanceEnvironmentProvider' => array(),
        );

        $options = $this->getMock('Jgut\\Zf\\Maintenance\\Options\\ModuleOptions', array(), array(), '', false);
        $options->expects($this->any())->method('getProviders')->will($this->returnValue($providers));

        $serviceManager = $this->getMock('Zend\\ServiceManager\\ServiceManager', array(), array(), '', false);
        $serviceManager->expects($this->once())->method('get')->will($this->returnValue($options));

        $factory = new ProviderEnvironmentServiceFactory();
        $factory->createService($serviceManager);
    }

    /**
     * @covers Jgut\Zf\Maintenance\Service\ProviderEnvironmentServiceFactory::createService
     * @covers Jgut\Zf\Maintenance\Provider\FileProvider::setFile
     */
    public function testCreation()
    {
        $providers = array(
            'ZfMaintenanceEnvironmentProvider' => array(
                'variable' => 'zf-maintenance',
                'value'    => 'On',
                'message'  => 'custom message',
            ),
        );

        $options = $this->getMock('Jgut\\Zf\\Maintenance\\Options\\ModuleOptions', array(), array(), '', false);
        $options->expects($this->any())->method('getProviders')->will($this->returnValue($providers));

        $serviceManager = $this->getMock('Zend\\ServiceManager\\ServiceManager', array(), array(), '', false);
        $serviceManager->expects($this->once())->method('get')->will($this->returnValue($options));

        $factory = new ProviderEnvironmentServiceFactory();
        $environmentProvider = $factory->createService($serviceManager);

        $this->assertTrue($environmentProvider instanceof EnvironmentProvider);
    }
}
