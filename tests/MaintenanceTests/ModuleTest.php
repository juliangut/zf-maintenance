<?php
/**
 * Juliangut Zend Framework Maintenance Module Module (https://github.com/juliangut/zf-maintenance)
 *
 * @link https://github.com/juliangut/zf-maintenance for the canonical source repository
 * @license https://github.com/juliangut/zf-maintenance/blob/master/LICENSE
 */

namespace Jgut\Zf\MaintenanceTests;

use PHPUnit_Framework_TestCase;
use Jgut\Zf\Maintenance\Module;

/**
 * @covers Jgut\Zf\Maintenance\Module
 */
class ModuleTest extends PHPUnit_Framework_TestCase
{
    /**
     * @covers Jgut\Zf\Maintenance\Module::getConfig
     */
    public function testGetConfig()
    {
        $module = new Module();

        $this->assertInternalType('array', $module->getConfig());
    }

    /**
     * @covers Jgut\Zf\Maintenance\Module::getAutoloaderConfig
     */
    public function testGetAutoloaderConfig()
    {
        $module = new Module();

        $this->assertInternalType('array', $module->getAutoloaderConfig());
    }
}
