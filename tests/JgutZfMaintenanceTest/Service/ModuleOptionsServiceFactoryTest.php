<?php
/**
 * JgutZfMaintenance Module (https://github.com/juliangut/zf-maintenance)
 *
 * @link https://github.com/juliangut/zf-maintenance for the canonical source repository
 * @license https://raw.githubusercontent.com/juliangut/zf-maintenance/master/LICENSE
 */

namespace JgutZfMaintenanceTest\Service;

use PHPUnit_Framework_TestCase;
use JgutZfMaintenance\Service\ModuleOptionsServiceFactory;
use JgutZfMaintenance\Options\ModuleOptions;

/**
 * @covers JgutZfMaintenance\Service\ModuleOptionsServiceFactory
 */
class ModuleOptionsServiceFactoryTest extends PHPUnit_Framework_TestCase
{
    protected $options = array(
        'zf-maintenance' => array(),
    );

    /**
     * @covers JgutZfMaintenance\Service\ModuleOptionsServiceFactory::createService
     * @covers JgutZfMaintenance\Options\ModuleOptions::__construct
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
