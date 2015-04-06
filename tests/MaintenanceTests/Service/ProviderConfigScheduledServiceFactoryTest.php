<?php
/**
 * Juliangut Zend Framework Maintenance Module Module (https://github.com/juliangut/zf-maintenance)
 *
 * @link https://github.com/juliangut/zf-maintenance for the canonical source repository
 * @license https://github.com/juliangut/zf-maintenance/blob/master/LICENSE
 */

namespace Jgut\Zf\MaintenanceTests\Service;

use PHPUnit_Framework_TestCase;
use Jgut\Zf\Maintenance\Service\ProviderConfigScheduledServiceFactory;
use Jgut\Zf\Maintenance\Provider\ConfigScheduledProvider;

/**
 * @covers Jgut\Zf\Maintenance\Service\ProviderConfigScheduledServiceFactory
 */
class ProviderConfigScheduledServiceFactoryTest extends PHPUnit_Framework_TestCase
{
    /**
     * @covers Jgut\Zf\Maintenance\Service\ProviderConfigScheduledServiceFactory::createService
     * @expectedException InvalidArgumentException
     */
    public function testNoCreation()
    {
        $options = $this->getMock('Jgut\\Zf\\Maintenance\\Options\\ModuleOptions', array(), array(), '', false);
        $options->expects($this->any())->method('getProviders')->will($this->returnValue(array()));

        $serviceManager = $this->getMock('Zend\\ServiceManager\\ServiceManager', array(), array(), '', false);
        $serviceManager->expects($this->once())->method('get')->will($this->returnValue($options));

        $factory = new ProviderConfigScheduledServiceFactory();
        $factory->createService($serviceManager);
    }

    /**
     * @covers Jgut\Zf\Maintenance\Service\ProviderConfigScheduledServiceFactory::createService
     * @covers Jgut\Zf\Maintenance\Provider\ConfigScheduledProvider::setStart
     * @covers Jgut\Zf\Maintenance\Provider\ConfigScheduledProvider::setEnd
     */
    public function testCreation()
    {
        $providers = array(
            'ZfMaintenanceConfigScheduledProvider' => array(
                'start'   => 'now',
                'end'     => 'now',
                'message' => 'custom message',
            ),
        );

        $options = $this->getMock('Jgut\\Zf\\Maintenance\\Options\\ModuleOptions', array(), array(), '', false);
        $options->expects($this->any())->method('getProviders')->will($this->returnValue($providers));

        $serviceManager = $this->getMock('Zend\\ServiceManager\\ServiceManager', array(), array(), '', false);
        $serviceManager->expects($this->once())->method('get')->will($this->returnValue($options));

        $factory = new ProviderConfigScheduledServiceFactory();
        $scheduledProvider = $factory->createService($serviceManager);

        $this->assertTrue($scheduledProvider instanceof ConfigScheduledProvider);
    }
}
