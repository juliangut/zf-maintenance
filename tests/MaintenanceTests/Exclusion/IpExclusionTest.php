<?php
/**
 * Juliangut Zend Framework Maintenance Module Module (https://github.com/juliangut/zf-maintenance)
 *
 * @link https://github.com/juliangut/zf-maintenance for the canonical source repository
 * @license https://raw.githubusercontent.com/juliangut/zf-maintenance/master/LICENSE
 */

namespace Jgut\Zf\MaintenanceTests\Exclusion;

use PHPUnit_Framework_TestCase;
use Jgut\Zf\Maintenance\Exclusion\IpExclusion;

/**
 * @covers Jgut\Zf\Maintenance\Exclusion\IpExclusion
 */
class IpExclusionTest extends PHPUnit_Framework_TestCase
{
    protected $excludedIps = array(
        '98.139.183.24',
        '74.125.230.5',
        '204.79.197.200',
    );

    /**
     * @covers Jgut\Zf\Maintenance\Exclusion\IpExclusion::isExcluded
     */
    public function testIsExcluded()
    {
        $ipProvider = $this->getMock('Zend\\Http\\PhpEnvironment\\RemoteAddress');
        $ipProvider->expects($this->once())->method('getIpAddress')->will($this->returnValue('98.139.183.24'));

        $exclusion = new IpExclusion($this->excludedIps, $ipProvider);

        $this->assertTrue($exclusion->isExcluded());
    }

    /**
     * @covers Jgut\Zf\Maintenance\Exclusion\IpExclusion::isExcluded
     */
    public function testNotIsExcluded()
    {
        $ipProvider = $this->getMock('Zend\\Http\\PhpEnvironment\\RemoteAddress');
        $ipProvider->expects($this->once())->method('getIpAddress')->will($this->returnValue('127.0.0.1'));

        $exclusion = new IpExclusion($this->excludedIps, $ipProvider);

        $this->assertFalse($exclusion->isExcluded());
    }
}
