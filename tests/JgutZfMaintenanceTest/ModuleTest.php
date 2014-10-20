<?php
/**
 * JgutZfMaintenance Module (https://github.com/juliangut/zf-maintenance)
 *
 * @link https://github.com/juliangut/zf-maintenance for the canonical source repository
 * @license https://raw.githubusercontent.com/juliangut/zf-maintenance/master/LICENSE
 */

namespace JgutZfMaintenanceTest;

use PHPUnit_Framework_TestCase;
use JgutZfMaintenance\Module;

/**
 * @covers JgutZfMaintenance\Module
 */
class ModuleTest extends PHPUnit_Framework_TestCase
{
    /**
     * @covers JgutZfMaintenance\Module::getConfig
     */
    public function testGetConfig()
    {
        $module = new Module();

        $this->assertInternalType('array', $module->getConfig());
    }

    /**
     * @covers JgutZfMaintenance\Module::getAutoloaderConfig
     */
    public function testGetAutoloaderConfig()
    {
        $module = new Module();

        $this->assertInternalType('array', $module->getAutoloaderConfig());
    }
}
