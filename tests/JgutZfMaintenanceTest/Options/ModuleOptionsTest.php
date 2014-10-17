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
    );

    /**
     * @covers JgutZfMaintenance\Options\ModuleOptions::getMaintenanceStrategy
     * @covers JgutZfMaintenance\Options\ModuleOptions::getTemplate
     */
    public function testDefaultModuleOptions()
    {
        $options = new ModuleOptions(array());

        $this->assertEquals('JgutZfMaintenance\View\maintenanceStrategy', $options->getMaintenanceStrategy());
        $this->assertEquals('zf-maintenance/maintenance', $options->getTemplate());
    }

    /**
     * @covers JgutZfMaintenance\Options\ModuleOptions::getMaintenanceStrategy
     * @covers JgutZfMaintenance\Options\ModuleOptions::getTemplate
     */
    public function testCustomModuleOptions()
    {
        $options = new ModuleOptions($this->options);

        $this->assertEquals('myStrategy', $options->getMaintenanceStrategy());
        $this->assertEquals('myTemplate', $options->getTemplate());
    }
}
