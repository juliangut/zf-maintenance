<?php
/**
 * Juliangut Zend Framework Maintenance Module Module (https://github.com/juliangut/zf-maintenance)
 *
 * @link https://github.com/juliangut/zf-maintenance for the canonical source repository
 * @license https://github.com/juliangut/zf-maintenance/blob/master/LICENSE
 */

namespace Jgut\Zf\MaintenanceTests\Service;

use PHPUnit_Framework_TestCase;
use Jgut\Zf\Maintenance\Service\ModuleOptionsServiceFactory;
use Jgut\Zf\Maintenance\Options\ModuleOptions;

/**
 * @covers Jgut\Zf\Maintenance\Service\ModuleOptionsServiceFactory
 */
class ModuleOptionsServiceFactoryTest extends PHPUnit_Framework_TestCase
{
    protected $options = array(
        'zf-maintenance' => array(),
    );

    /**
     * @covers Jgut\Zf\Maintenance\Service\ModuleOptionsServiceFactory::createService
     * @covers Jgut\Zf\Maintenance\Options\ModuleOptions::__construct
     */
    public function testCreation()
    {
        $serviceManager = $this->getMock('Zend\\ServiceManager\\ServiceManager', array(), array(), '', false);
        $serviceManager->expects($this->once())->method('get')->will($this->returnValue($this->options));

        $factory = new ModuleOptionsServiceFactory();
        $moduleOptions = $factory->createService($serviceManager);

        $this->assertTrue($moduleOptions instanceof ModuleOptions);
    }
}
