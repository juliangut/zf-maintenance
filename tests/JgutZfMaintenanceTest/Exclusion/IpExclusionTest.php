<?php
/**
 * JgutZfMaintenance Module (https://github.com/juliangut/zf-maintenance)
 *
 * @link https://github.com/juliangut/zf-maintenance for the canonical source repository
 * @license https://raw.githubusercontent.com/juliangut/zf-maintenance/master/LICENSE
 */

namespace JgutZfMaintenanceTest\Exclusion;

use PHPUnit_Framework_TestCase;
use JgutZfMaintenance\Exclusion\IpExclusion;

/**
 * @covers JgutZfMaintenance\Exclusion\IpExclusion
 */
class IpExclusionTest extends PHPUnit_Framework_TestCase
{
    protected $excludedIps = array(
        '98.139.183.24',
        '74.125.230.5',
        '204.79.197.200',
    );

    /**
     * @covers JgutZfMaintenance\Exclusion\IpExclusion::isExcluded
     */
    public function testIsExcluded()
    {
        $ipProvider = $this->getMock('Zend\\Http\\PhpEnvironment\\RemoteAddress');
        $ipProvider->expects($this->once())->method('getIpAddress')->will($this->returnValue('98.139.183.24'));

        $exclusion = new IpExclusion($this->excludedIps, $ipProvider);

        $this->assertTrue($exclusion->isExcluded());
    }

    /**
     * @covers JgutZfMaintenance\Exclusion\IpExclusion::isExcluded
     */
    public function testNotIsExcluded()
    {
        $ipProvider = $this->getMock('Zend\\Http\\PhpEnvironment\\RemoteAddress');
        $ipProvider->expects($this->once())->method('getIpAddress')->will($this->returnValue('127.0.0.1'));

        $exclusion = new IpExclusion($this->excludedIps, $ipProvider);

        $this->assertFalse($exclusion->isExcluded());
    }
}
