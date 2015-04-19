<?php
/**
 * Juliangut Zend Framework Maintenance Module Module (https://github.com/juliangut/zf-maintenance)
 *
 * @link https://github.com/juliangut/zf-maintenance for the canonical source repository
 * @license https://github.com/juliangut/zf-maintenance/blob/master/LICENSE
 */

namespace Jgut\Zf\MaintenanceTests\Options;

use PHPUnit_Framework_TestCase;
use Jgut\Zf\Maintenance\Options\ModuleOptions;

/**
 * @covers Jgut\Zf\Maintenance\Options\ModuleOptions
 */
class ModuleOptionsTest extends PHPUnit_Framework_TestCase
{
    protected $options = array(
        'strategy'  => 'myStrategy',
        'template'  => 'myTemplate',
        'block'     => false,
        'providers' => array(
            'ZfMaintenanceConfigProvider' => array(
                'active' => false,
            ),
        ),
        'exclusions' => array(
            'ZfMaintenanceIpExclusion' => array(
                '127.0.0.1',
            ),
            'ZfMaintenanceRouteExclusion' => array(
                'home',
            ),
        ),
    );

    /**
     * @covers Jgut\Zf\Maintenance\Options\ModuleOptions::getStrategy
     * @covers Jgut\Zf\Maintenance\Options\ModuleOptions::getTemplate
     * @covers Jgut\Zf\Maintenance\Options\ModuleOptions::getProviders
     * @covers Jgut\Zf\Maintenance\Options\ModuleOptions::getExclusions
     */
    public function testDefaultModuleOptions()
    {
        $options = new ModuleOptions(array());

        $this->assertEquals('ZfMaintenanceStrategy', $options->getStrategy());
        $this->assertEquals('zf-maintenance/maintenance', $options->getTemplate());
        $this->assertTrue($options->isBlocked());
        $this->assertInternalType('array', $options->getProviders());
        $this->assertInternalType('array', $options->getExclusions());
    }

    /**
     * @covers Jgut\Zf\Maintenance\Options\ModuleOptions::getStrategy
     * @covers Jgut\Zf\Maintenance\Options\ModuleOptions::getTemplate
     * @covers Jgut\Zf\Maintenance\Options\ModuleOptions::getProviders
     * @covers Jgut\Zf\Maintenance\Options\ModuleOptions::getExclusions
     */
    public function testCustomModuleOptions()
    {
        $options = new ModuleOptions($this->options);

        $this->assertEquals('myStrategy', $options->getStrategy());
        $this->assertEquals('myTemplate', $options->getTemplate());
        $this->assertFalse($options->isBlocked());
        $this->assertCount(1, $options->getProviders());
        $this->assertCount(2, $options->getExclusions());
    }
}
