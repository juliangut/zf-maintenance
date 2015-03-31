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
        'maintenance_strategy' => 'myStrategy',
        'template'             => 'myTemplate',
        'providers'            => array(
            'Jgut\Zf\Maintenance\Provider\ConfigProvider' => array(
                'active' => false,
            ),
        ),
        'exclusions'           => array(
            'Jgut\Zf\Maintenance\Exclusion\IpExclusion'    => array(
                '127.0.0.1',
            ),
            'Jgut\Zf\Maintenance\Exclusion\RouteExclusion' => array(
                'home',
            ),
        ),
    );

    /**
     * @covers Jgut\Zf\Maintenance\Options\ModuleOptions::getMaintenanceStrategy
     * @covers Jgut\Zf\Maintenance\Options\ModuleOptions::getTemplate
     * @covers Jgut\Zf\Maintenance\Options\ModuleOptions::getProviders
     * @covers Jgut\Zf\Maintenance\Options\ModuleOptions::getExclusions
     */
    public function testDefaultModuleOptions()
    {
        $options = new ModuleOptions(array());

        $this->assertEquals('Jgut\Zf\Maintenance\View\maintenanceStrategy', $options->getMaintenanceStrategy());
        $this->assertEquals('zf-maintenance/maintenance', $options->getTemplate());
        $this->assertInternalType('array', $options->getProviders());
        $this->assertInternalType('array', $options->getExclusions());
    }

    /**
     * @covers Jgut\Zf\Maintenance\Options\ModuleOptions::getMaintenanceStrategy
     * @covers Jgut\Zf\Maintenance\Options\ModuleOptions::getTemplate
     * @covers Jgut\Zf\Maintenance\Options\ModuleOptions::getProviders
     * @covers Jgut\Zf\Maintenance\Options\ModuleOptions::getExclusions
     */
    public function testCustomModuleOptions()
    {
        $options = new ModuleOptions($this->options);

        $this->assertEquals('myStrategy', $options->getMaintenanceStrategy());
        $this->assertEquals('myTemplate', $options->getTemplate());
        $this->assertCount(1, $options->getProviders());
        $this->assertCount(2, $options->getExclusions());
    }
}
