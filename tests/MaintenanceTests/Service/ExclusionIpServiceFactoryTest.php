<?php
/**
 * Juliangut Zend Framework Maintenance Module Module (https://github.com/juliangut/zf-maintenance)
 *
 * @link https://github.com/juliangut/zf-maintenance for the canonical source repository
 * @license https://raw.githubusercontent.com/juliangut/zf-maintenance/master/LICENSE
 */

namespace Jgut\Zf\MaintenanceTests\Service;

use PHPUnit_Framework_TestCase;
use Jgut\Zf\Maintenance\Service\ExclusionIpServiceFactory;
use Jgut\Zf\Maintenance\Exclusion\IpExclusion;

/**
 * @covers Jgut\Zf\Maintenance\Service\ExclusionIpServiceFactory
 */
class ExclusionIpServiceFactoryTest extends PHPUnit_Framework_TestCase
{
    /**
     * @covers Jgut\Zf\Maintenance\Service\ExclusionIpServiceFactory::createService
     * @expectedException InvalidArgumentException
     */
    public function testNoCreation()
    {
        $exclusions = array();

        $options = $this->getMock('Jgut\\Zf\\Maintenance\\Options\\ModuleOptions', array(), array(), '', false);
        $options->expects($this->any())->method('getExclusions')->will($this->returnValue($exclusions));

        $serviceManager = $this->getMock('Zend\\ServiceManager\\ServiceManager', array(), array(), '', false);
        $serviceManager->expects($this->once())->method('get')->will($this->returnValue($options));

        $factory = new ExclusionIpServiceFactory();
        $ipExclusion = $factory->createService($serviceManager);
    }

    /**
     * @covers Jgut\Zf\Maintenance\Service\ExclusionIpServiceFactory::createService
     * @covers Jgut\Zf\Maintenance\Exclusion\IpExclusion::__construct
     */
    public function testCreation()
    {
        $exclusions = array(
            'Jgut\Zf\Maintenance\Exclusion\IpExclusion' => array(),
        );

        $options = $this->getMock('Jgut\\Zf\\Maintenance\\Options\\ModuleOptions', array(), array(), '', false);
        $options->expects($this->any())->method('getExclusions')->will($this->returnValue($exclusions));

        $serviceManager = $this->getMock('Zend\\ServiceManager\\ServiceManager', array(), array(), '', false);
        $serviceManager->expects($this->once())->method('get')->will($this->returnValue($options));

        $factory = new ExclusionIpServiceFactory();
        $ipExclusion = $factory->createService($serviceManager);

        $this->assertTrue($ipExclusion instanceof IpExclusion);
    }
}
