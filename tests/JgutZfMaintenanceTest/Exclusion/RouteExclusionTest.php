<?php
/**
 * JgutZfMaintenance Module (https://github.com/juliangut/zf-maintenance)
 *
 * @link https://github.com/juliangut/zf-maintenance for the canonical source repository
 * @license https://raw.githubusercontent.com/juliangut/zf-maintenance/master/LICENSE
 */

namespace JgutZfMaintenanceTest\Exclusion;

use PHPUnit_Framework_TestCase;
use JgutZfMaintenance\Exclusion\RouteExclusion;

/**
 * @covers JgutZfMaintenance\Exclusion\RouteExclusion
 */
class RouteExclusionTest extends PHPUnit_Framework_TestCase
{
    protected $excludedRoutes = array(
        'home',
        'login',
        array(
            'controller' => 'JgutZfMaintenance\\Controller\\Index',
            'action'     => 'index'
        ),
    );

    /**
     * @covers JgutZfMaintenance\Exclusion\RouteExclusion::isExcluded
     */
    public function testIsExcluded()
    {
        $routeProvider = $this->getMock('Zend\\Mvc\\Router\\RouteMatch', array(), array(), '', false);
        $routeProvider->expects($this->once())->method('getMatchedRouteName')->will($this->returnValue('login'));
        $routeProvider->expects($this->once())->method('getParams')->will(
            $this->returnValue(array('controller' => '', 'action' => ''))
        );

        $exclusion = new RouteExclusion($this->excludedRoutes, $routeProvider);

        $this->assertTrue($exclusion->isExcluded());

        $routeProvider = $this->getMock('Zend\\Mvc\\Router\\RouteMatch', array(), array(), '', false);
        $routeProvider->expects($this->once())->method('getMatchedRouteName')->will($this->returnValue(''));
        $routeProvider->expects($this->once())->method('getParams')->will(
            $this->returnValue(array('controller' => 'JgutZfMaintenance\\Controller\\Index', 'action' => 'index'))
        );

        $exclusion = new RouteExclusion($this->excludedRoutes, $routeProvider);

        $this->assertTrue($exclusion->isExcluded());
    }

    /**
     * @covers JgutZfMaintenance\Exclusion\RouteExclusion::isExcluded
     */
    public function testNotIsExcluded()
    {
        $routeProvider = $this->getMock('Zend\\Mvc\\Router\\RouteMatch', array(), array(), '', false);
        $routeProvider->expects($this->once())->method('getMatchedRouteName')->will($this->returnValue('admin'));
        $routeProvider->expects($this->once())->method('getParams')->will(
            $this->returnValue(array('controller' => '', 'action' => ''))
        );

        $exclusion = new RouteExclusion($this->excludedRoutes, $routeProvider);

        $this->assertFalse($exclusion->isExcluded());

        $routeProvider = $this->getMock('Zend\\Mvc\\Router\\RouteMatch', array(), array(), '', false);
        $routeProvider->expects($this->once())->method('getMatchedRouteName')->will($this->returnValue(''));
        $routeProvider->expects($this->once())->method('getParams')->will(
            $this->returnValue(array('controller' => 'Admin\\Controller\\Index', 'action' => 'index'))
        );

        $exclusion = new RouteExclusion($this->excludedRoutes, $routeProvider);

        $this->assertFalse($exclusion->isExcluded());
    }
}
