<?php
/**
 * Juliangut Zend Framework Maintenance Module Module (https://github.com/juliangut/zf-maintenance)
 *
 * @link https://github.com/juliangut/zf-maintenance for the canonical source repository
 * @license https://github.com/juliangut/zf-maintenance/blob/master/LICENSE
 */

namespace Jgut\Zf\MaintenanceTests\Provider;

use PHPUnit_Framework_TestCase;
use Jgut\Zf\Maintenance\Provider\EnvironmentProvider;

/**
 * @covers Jgut\Zf\Maintenance\Provider\EnvironmentProvider
 */
class EnvironmentProviderTest extends PHPUnit_Framework_TestCase
{
    protected $provider;

    public static function setUpBeforeClass()
    {
        putenv('zf-maintenance=On');
    }

    public static function tearDownAfterClass()
    {
        putenv('zf-maintenance');
    }

    public function setUp()
    {
        $this->provider = new EnvironmentProvider();
    }

    /**
     * @covers Jgut\Zf\Maintenance\Provider\EnvironmentProvider::setVar
     * @covers Jgut\Zf\Maintenance\Provider\EnvironmentProvider::getVar
     * @covers Jgut\Zf\Maintenance\Provider\EnvironmentProvider::setValue
     * @covers Jgut\Zf\Maintenance\Provider\EnvironmentProvider::getValue
     */
    public function testMutatorsAccessors()
    {
        $this->provider->setVar('zf-maintenance');
        $this->provider->setValue('On');

        $this->assertEquals('zf-maintenance', $this->provider->getVar());
        $this->assertEquals('On', $this->provider->getValue());
    }

    /**
     * @covers Jgut\Zf\Maintenance\Provider\EnvironmentProvider::setVar
     * @covers Jgut\Zf\Maintenance\Provider\EnvironmentProvider::setValue
     * @covers Jgut\Zf\Maintenance\Provider\EnvironmentProvider::isActive
     */
    public function testNotIsActive()
    {
        $this->assertFalse($this->provider->isActive());

        $this->provider->setVar('ficticious-environment-variable');

        $this->assertFalse($this->provider->isActive());

        $this->provider->setVar('zf-maintenance');
        $this->provider->setValue('Off');

        $this->assertFalse($this->provider->isActive());
    }

    /**
     * @covers Jgut\Zf\Maintenance\Provider\EnvironmentProvider::setVar
     * @covers Jgut\Zf\Maintenance\Provider\EnvironmentProvider::setValue
     * @covers Jgut\Zf\Maintenance\Provider\EnvironmentProvider::isActive
     */
    public function testIsActive()
    {
        $this->provider->setVar('zf-maintenance');

        $this->assertTrue($this->provider->isActive());

        $this->provider->setValue('On');

        $this->assertTrue($this->provider->isActive());
    }
}
