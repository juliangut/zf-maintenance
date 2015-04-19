<?php
/**
 * Juliangut Zend Framework Maintenance Module Module (https://github.com/juliangut/zf-maintenance)
 *
 * @link https://github.com/juliangut/zf-maintenance for the canonical source repository
 * @license https://github.com/juliangut/zf-maintenance/blob/master/LICENSE
 */

namespace Jgut\Zf\MaintenanceTests\Provider;

use PHPUnit_Framework_TestCase;
use Jgut\Zf\Maintenance\Provider\FileProvider;

/**
 * @covers Jgut\Zf\Maintenance\Provider\FileProvider
 */
class FileProviderTest extends PHPUnit_Framework_TestCase
{
    protected $provider;

    protected static $tmpFile;

    public static function setUpBeforeClass()
    {
        self::$tmpFile = sys_get_temp_dir() . '/maintenance';

        touch(self::$tmpFile);
    }

    public static function tearDownAfterClass()
    {
        unlink(self::$tmpFile);
    }

    public function setUp()
    {
        $this->provider = new FileProvider();
    }

    /**
     * @covers Jgut\Zf\Maintenance\Provider\FileProvider::setFile
     * @covers Jgut\Zf\Maintenance\Provider\FileProvider::getFile
     */
    public function testMutatorsAccessors()
    {
        $this->provider->setFile(self::$tmpFile);

        $this->assertEquals(self::$tmpFile, $this->provider->getFile());
    }

    /**
     * @covers Jgut\Zf\Maintenance\Provider\FileProvider::setFile
     * @covers Jgut\Zf\Maintenance\Provider\FileProvider::isActive
     */
    public function testNotIsActive()
    {
        $this->assertFalse($this->provider->isActive());

        $this->provider->setFile('ficticious-file');

        $this->assertFalse($this->provider->isActive());
    }

    /**
     * @covers Jgut\Zf\Maintenance\Provider\FileProvider::setFile
     * @covers Jgut\Zf\Maintenance\Provider\FileProvider::isActive
     */
    public function testIsActive()
    {
        $this->provider->setFile(self::$tmpFile);

        $this->assertTrue($this->provider->isActive());
    }
}
