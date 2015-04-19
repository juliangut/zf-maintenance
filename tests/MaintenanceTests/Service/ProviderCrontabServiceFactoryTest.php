<?php
/**
 * Juliangut Zend Framework Maintenance Module Module (https://github.com/juliangut/zf-maintenance)
 *
 * @link https://github.com/juliangut/zf-maintenance for the canonical source repository
 * @license https://github.com/juliangut/zf-maintenance/blob/master/LICENSE
 */

namespace Jgut\Zf\MaintenanceTests\Service;

use PHPUnit_Framework_TestCase;
use Jgut\Zf\Maintenance\Service\ProviderCrontabServiceFactory;
use Jgut\Zf\Maintenance\Provider\CrontabProvider;

/**
 * @covers Jgut\Zf\Maintenance\Service\ProviderCrontabServiceFactory
 */
class ProviderCrontabServiceFactoryTest extends PHPUnit_Framework_TestCase
{
    /**
     * @covers Jgut\Zf\Maintenance\Service\ProviderCrontabServiceFactory::createService
     * @expectedException InvalidArgumentException
     */
    public function testNoCreation()
    {
        $options = $this->getMock('Jgut\\Zf\\Maintenance\\Options\\ModuleOptions', array(), array(), '', false);
        $options->expects($this->any())->method('getProviders')->will($this->returnValue(array()));

        $serviceManager = $this->getMock('Zend\\ServiceManager\\ServiceManager', array(), array(), '', false);
        $serviceManager->expects($this->once())->method('get')->will($this->returnValue($options));

        $factory = new ProviderCrontabServiceFactory();
        $factory->createService($serviceManager);
    }

    /**
     * @covers Jgut\Zf\Maintenance\Service\ProviderCrontabServiceFactory::createService
     * @expectedException InvalidArgumentException
     */
    public function testMissingExpression()
    {
        $providers = array(
            'ZfMaintenanceCrontabProvider' => array(),
        );

        $options = $this->getMock('Jgut\\Zf\\Maintenance\\Options\\ModuleOptions', array(), array(), '', false);
        $options->expects($this->any())->method('getProviders')->will($this->returnValue($providers));

        $serviceManager = $this->getMock('Zend\\ServiceManager\\ServiceManager', array(), array(), '', false);
        $serviceManager->expects($this->once())->method('get')->will($this->returnValue($options));

        $factory = new ProviderCrontabServiceFactory();
        $factory->createService($serviceManager);
    }

    /**
     * @covers Jgut\Zf\Maintenance\Service\ProviderCrontabServiceFactory::createService
     * @expectedException InvalidArgumentException
     */
    public function testMissingInterval()
    {
        $providers = array(
            'ZfMaintenanceCrontabProvider' => array(
                'expression' => '@monthly',
            ),
        );

        $options = $this->getMock('Jgut\\Zf\\Maintenance\\Options\\ModuleOptions', array(), array(), '', false);
        $options->expects($this->any())->method('getProviders')->will($this->returnValue($providers));

        $serviceManager = $this->getMock('Zend\\ServiceManager\\ServiceManager', array(), array(), '', false);
        $serviceManager->expects($this->once())->method('get')->will($this->returnValue($options));

        $factory = new ProviderCrontabServiceFactory();
        $factory->createService($serviceManager);
    }

    /**
     * @covers Jgut\Zf\Maintenance\Service\ProviderCrontabServiceFactory::createService
     */
    public function testCreation()
    {
        $providers = array(
            'ZfMaintenanceCrontabProvider' => array(
                'expression' => '@monthly',
                'interval'   => 'P1D',
                'message'    => 'custom message',
            ),
        );

        $options = $this->getMock('Jgut\\Zf\\Maintenance\\Options\\ModuleOptions', array(), array(), '', false);
        $options->expects($this->any())->method('getProviders')->will($this->returnValue($providers));

        $serviceManager = $this->getMock('Zend\\ServiceManager\\ServiceManager', array(), array(), '', false);
        $serviceManager->expects($this->once())->method('get')->will($this->returnValue($options));

        $factory = new ProviderCrontabServiceFactory();
        $scheduledProvider = $factory->createService($serviceManager);

        $this->assertTrue($scheduledProvider instanceof CrontabProvider);
    }
}
