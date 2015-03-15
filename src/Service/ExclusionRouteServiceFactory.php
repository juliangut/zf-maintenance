<?php
/**
 * Juliangut Zend Framework Maintenance Module Module (https://github.com/juliangut/zf-maintenance)
 *
 * @link https://github.com/juliangut/zf-maintenance for the canonical source repository
 * @license https://raw.githubusercontent.com/juliangut/zf-maintenance/master/LICENSE
 */

namespace Jgut\Zf\Maintenance\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Jgut\Zf\Maintenance\Exclusion\RouteExclusion;

class ExclusionRouteServiceFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     *
     * @return \Jgut\Zf\Maintenance\Exclusion\RouteExclusion
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $options    = $serviceLocator->get('zf-maintenance-options');
        $exclusions = $options->getExclusions();

        if (!isset($exclusions['Jgut\Zf\Maintenance\Exclusion\RouteExclusion'])) {
            throw new \InvalidArgumentException(
                'Config for "Jgut\Zf\Maintenance\Exclusion\RouteExclusion" not set'
            );
        }

        $routes     = $exclusions['Jgut\Zf\Maintenance\Exclusion\RouteExclusion'];
        $routeMatch = $serviceLocator->get('Application')->getMvcEvent()->getRouteMatch();

        return new RouteExclusion($routes, $routeMatch);
    }
}
