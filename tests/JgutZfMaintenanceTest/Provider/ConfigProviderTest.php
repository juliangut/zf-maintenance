<?php
/**
 * JgutZfMaintenance Module (https://github.com/juliangut/zf-maintenance)
 *
 * @link https://github.com/juliangut/zf-maintenance for the canonical source repository
 * @license https://raw.githubusercontent.com/juliangut/zf-maintenance/master/LICENSE
 */

namespace JgutZfMaintenanceTest\Exclusion;

use PHPUnit_Framework_TestCase;
use JgutZfMaintenance\Provider\ConfigProvider;

/**
 * @covers JgutZfMaintenance\Provider\ConfigProvider
 */
class ConfigProviderTest extends PHPUnit_Framework_TestCase
{
    /**
     * @covers JgutZfMaintenance\Provider\ConfigProvider::isActive
     */
    public function testIsActive()
    {
        $provider = new ConfigProvider();
        $provider->setActive(true);

        $this->assertTrue($provider->isActive());
    }

    /**
     * @covers JgutZfMaintenance\Provider\ConfigProvider::isActive
     */
    public function testNotIsActive()
    {
        $provider = new ConfigProvider();

        $this->assertFalse($provider->isActive());
    }
}
