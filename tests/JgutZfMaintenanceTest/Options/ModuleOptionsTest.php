<?php
/**
 * JgutZfMaintenance Module (https://github.com/juliangut/zf-maintenance)
 *
 * @link https://github.com/juliangut/zf-maintenance for the canonical source repository
 * @license https://raw.githubusercontent.com/juliangut/zf-maintenance/master/LICENSE
 */

namespace JgutZfMaintenanceTest\Options;

use PHPUnit_Framework_TestCase;
use JgutZfMaintenance\Options\ModuleOptions;

/**
 * @covers JgutZfMaintenance\Options\ModuleOptions
 */
class ModuleOptionsTest extends PHPUnit_Framework_TestCase
{
    protected $options = array(
        'maintenance_strategy' => 'myStrategy',
        'template'             => 'myTemplate',
        'providers'            => array(
            'JgutZfMaintenance\Provider\ConfigProvider' => array(
                'active' => false,
            ),
        ),
        'exclusions'           => array(
            'JgutZfMaintenance\Exclusion\IpExclusion'    => array(
                '127.0.0.1',
            ),
            'JgutZfMaintenance\Exclusion\RouteExclusion' => array(
                'home',
            ),
        ),
    );

    /**
     * @covers JgutZfMaintenance\Options\ModuleOptions::getMaintenanceStrategy
     * @covers JgutZfMaintenance\Options\ModuleOptions::getTemplate
     * @covers JgutZfMaintenance\Options\ModuleOptions::getProviders
     * @covers JgutZfMaintenance\Options\ModuleOptions::getExclusions
     */
    public function testDefaultModuleOptions()
    {
        $options = new ModuleOptions(array());

        $this->assertEquals('JgutZfMaintenance\View\maintenanceStrategy', $options->getMaintenanceStrategy());
        $this->assertEquals('zf-maintenance/maintenance', $options->getTemplate());
        $this->assertInternalType('array', $options->getProviders());
        $this->assertInternalType('array', $options->getExclusions());
    }

    /**
     * @covers JgutZfMaintenance\Options\ModuleOptions::getMaintenanceStrategy
     * @covers JgutZfMaintenance\Options\ModuleOptions::getTemplate
     * @covers JgutZfMaintenance\Options\ModuleOptions::getProviders
     * @covers JgutZfMaintenance\Options\ModuleOptions::getExclusions
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
