<?php
/**
 * JgutZfMaintenance Module (https://github.com/juliangut/zf-maintenance)
 *
 * @link https://github.com/juliangut/zf-maintenance for the canonical source repository
 * @license https://raw.githubusercontent.com/juliangut/zf-maintenance/master/LICENSE
 */

namespace JgutZfMaintenanceTest\Service;

use PHPUnit_Framework_TestCase;
use JgutZfMaintenance\Service\ExclusionIpServiceFactory;
use JgutZfMaintenance\Exclusion\IpExclusion;

/**
 * @covers JgutZfMaintenance\Service\ExclusionIpServiceFactory
 */
class ExclusionIpServiceFactoryTest extends PHPUnit_Framework_TestCase
{
    /**
     * @covers JgutZfMaintenance\Service\ExclusionIpServiceFactory::createService
     * @expectedException InvalidArgumentException
     */
    public function testNoCreation()
    {
        $exclusions = array();

        $options = $this->getMock('JgutZfMaintenance\\Options\\ModuleOptions', array(), array(), '', false);
        $options->expects($this->any())->method('getExclusions')->will($this->returnValue($exclusions));

        $serviceManager = $this->getMock('Zend\\ServiceManager\\ServiceManager', array(), array(), '', false);
        $serviceManager->expects($this->once())->method('get')->will($this->returnValue($options));

        $factory = new ExclusionIpServiceFactory();
        $ipExclusion = $factory->createService($serviceManager);
    }

    /**
     * @covers JgutZfMaintenance\Service\ExclusionIpServiceFactory::createService
     * @covers JgutZfMaintenance\Exclusion\IpExclusion::__construct
     */
    public function testCreation()
    {
        $exclusions = array(
            'JgutZfMaintenance\Exclusion\IpExclusion' => array(),
        );

        $options = $this->getMock('JgutZfMaintenance\\Options\\ModuleOptions', array(), array(), '', false);
        $options->expects($this->any())->method('getExclusions')->will($this->returnValue($exclusions));

        $serviceManager = $this->getMock('Zend\\ServiceManager\\ServiceManager', array(), array(), '', false);
        $serviceManager->expects($this->once())->method('get')->will($this->returnValue($options));

        $factory = new ExclusionIpServiceFactory();
        $ipExclusion = $factory->createService($serviceManager);

        $this->assertTrue($ipExclusion instanceof IpExclusion);
    }
}
