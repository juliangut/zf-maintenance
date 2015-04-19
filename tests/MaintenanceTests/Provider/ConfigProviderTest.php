<?php
/**
 * Juliangut Zend Framework Maintenance Module Module (https://github.com/juliangut/zf-maintenance)
 *
 * @link https://github.com/juliangut/zf-maintenance for the canonical source repository
 * @license https://github.com/juliangut/zf-maintenance/blob/master/LICENSE
 */

namespace Jgut\Zf\MaintenanceTests\Provider;

use PHPUnit_Framework_TestCase;
use Jgut\Zf\Maintenance\Provider\ConfigProvider;

/**
 * @covers Jgut\Zf\Maintenance\Provider\ConfigProvider
 */
class ConfigProviderTest extends PHPUnit_Framework_TestCase
{
    protected $provider;

    public function setUp()
    {
        $this->provider = new ConfigProvider();
    }

    /**
     * @covers Jgut\Zf\Maintenance\Provider\ConfigProvider::setActive
     * @covers Jgut\Zf\Maintenance\Provider\ConfigProvider::isActive
     */
    public function testMutatorsAccessors()
    {
        $this->assertFalse($this->provider->isActive());

        $this->provider->setActive(true);

        $this->assertTrue($this->provider->isActive());
    }
}
